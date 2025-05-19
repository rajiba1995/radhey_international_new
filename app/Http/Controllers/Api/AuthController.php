<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Otp;
use App\Models\Order;
use App\Models\UserLogin;
use App\Models\Ledger;
use App\Models\Country;
use App\Models\BusinessType;
use App\Models\PaymentCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function CountryList(){
        $data = Country::select('id', 'title', 'country_code', 'mobile_length')->orderBy('title', 'ASC')->where('status', 1)->get();
        return response()->json([
            'status' => true,
            'message' => 'Country list retrieved successfully',
            'countries' => $data,
        ], 200);
    }
    public function CountryDetailsByID($id){
        $data = Country::select('title', 'country_code', 'mobile_length')->find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Country not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Country data retrieved successfully',
            'country' => $data,
        ], 200);
    }

    // User Login
    public function checkDevice(Request $request){
        $validator = Validator::make($request->all(), [
            'device_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userLogin = UserLogin::where('device_id', $request->device_id)->first();

        if ($userLogin) {
            return response()->json([
                'message' => 'Device found, use MPIN to login',
                'data'=>$userLogin,
                'show_mpin' => true
            ], 200);
        }

        return response()->json([
            'message' => 'Device not registered, login with OTP first',
            'show_mpin' => false
        ], 200);
    }

    public function userLogin(Request $request){
       // dd('hi');
        $validator = Validator::make($request->all(),[
            'country_code' => 'required',
            'mobile' => [
            'required',
            'numeric',
            function ($attribute, $value, $fail) {
                $exists = User::where('phone', $value)
                            ->where('user_type', 1)
                            ->exists();

                if (! $exists) {
                    $fail('The selected mobile number is invalid or does not belong to a valid user.');
                }
            },
        ],
            'device_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(), // Returns only the first error message
            ], 422);
        }

        // Check if the user already exists in user_logins
        $userLogin = UserLogin::where('country_code', $request->country_code)
         ->where('mobile', $request->mobile)
         ->first();
         $user = User::where('country_code_phone', $request->country_code)
         ->where('phone', $request->mobile)
         ->first();

        if ($userLogin && $userLogin->is_verified) {
            return response()->json([
                'message' => 'User already verified, use MPIN to login',
                'show_mpin' => true
            ], 200);
        }

        // Generate and store OTP
        // $otp = rand(1000, 9999);
        $otp = 1234;
        UserLogin::updateOrCreate(
            ['user_id'=>$user->id,'country_code' => $request->country_code, 'mobile' => $request->mobile],
            ['otp' => $otp, 'device_id' => $request->device_id]
        );

        // Send OTP (Replace with SMS API)
        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully',
            'otp' => $otp // Remove in production
        ], 200);
    }

    public function verifyOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|exists:users,phone',
            'otp' => 'required|digits:4',
            'device_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        
        $userLogin = UserLogin::where('country_code', $request->country_code)
            ->where('mobile', $request->mobile)
            ->where('otp', $request->otp)
            ->first();

        if (!$userLogin) {
            return response()->json([
                'status'=>false,
                'message' => 'Invalid OTP'
            ], 401);
        }

        $userLogin->is_verified = true;
        $userLogin->otp = null;
        $userLogin->device_id = $request->device_id;
        $userLogin->save();

        return response()->json([
            'status'=>true,
            'message' => 'OTP verified successfully. Please set MPIN.',
        ], 200);
    }

    /**
     * Step 4: Set MPIN
     */
    public function setMpin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|exists:user_logins,mobile',
            'mpin' => 'required|digits:4',
            'device_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userLogin = UserLogin::where('mobile', $request->mobile)->first();
        if (!$userLogin) {
            return response()->json([
                'status'=>false,
                'message' => 'User not found'
            ], 404);
        }

        $userLogin->mpin = Hash::make($request->mpin);
        $userLogin->save();

            // return response()->json([
            //     'status'=>true,
            //     'message' => 'MPIN set successfully',
            // ], 200);

        if (!$userLogin || !Hash::check($request->mpin, $userLogin->mpin)) {
            return response()->json([
                'status'=>false,
                'message' => 'Invalid MPIN or Device ID'
            ], 401);
        }

        $userLogin->device_id = $request->device_id;
        $userLogin->save();
        // Generate API token
        $user = $userLogin->user; // Assuming `user_id` is linked to `users` table
        $user->tokens()->delete();
        $token = $user->createToken('Login API')->plainTextToken;
        $data=[
            'id' => $user->id,
            'firstname' => $user->name,
            'surname' => $user->surname ?? '', // Avoid errors if surname is null
            'designation' => optional($user->designationDetails)->name ?? 'N/A', // Check if relation exists
            'email' => $user->email,
            'mobile' => $user->phone,
            'country_code' => $user->country_code_phone,
        ];
        return response()->json([
            'status'=>true,
            'message' => 'MPIN set with login successful',
            'token' => $token,
            'user' => $data
        ], 200);
    }

     /**
     * Step 5: Login with MPIN and Device ID
     */
    public function mpinLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|exists:user_logins,mobile',
            'mpin' => 'required|digits:4',
            'device_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userLogin = UserLogin::where('mobile', $request->mobile)
            ->first();

        if (!$userLogin || !Hash::check($request->mpin, $userLogin->mpin)) {
            return response()->json([
                'status'=>false,
                'message' => 'Invalid MPIN or Device ID'
            ], 401);
        }

        $userLogin->device_id = $request->device_id;
        $userLogin->save();
        // Generate API token
        $user = $userLogin->user; // Assuming `user_id` is linked to `users` table
        $user->tokens()->delete();
        $token = $user->createToken('Login API')->plainTextToken;
        $data=[
            'id' => $user->id,
            'firstname' => $user->name,
            'surname' => $user->surname ?? '', // Avoid errors if surname is null
            'designation' => optional($user->designationDetails)->name ?? 'N/A', // Check if relation exists
            'email' => $user->email,
            'mobile' => $user->phone,
            'country_code' => $user->country_code_phone,
        ];
        return response()->json([
            'status'=>true,
            'message' => 'MPIN login successful',
            'token' => $token,
            'user' => $data
        ], 200);
    }

    public function logout(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|exists:user_logins,mobile',
            'device_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userLogin = UserLogin::where('mobile', $request->mobile)
            ->where('device_id', $request->device_id)
            ->first();
        if (!$userLogin) {
            return response()->json(['message' => 'User not found or already logged out'], 404);
        }

        // Remove device ID to require OTP on next login
        $userLogin->device_id = null;
        // $userLogin->mpin = null; // Optional: Remove MPIN if required
        $userLogin->save();

        // Delete API tokens if the user is authenticated
        if (Auth::check()) {
            Auth::user()->tokens()->delete(); // Logs out by deleting all tokens
        }
        return response()->json([
            'message' => 'Logout successful. Next login will require OTP.'
        ], 200);
    }

    /**
     * Step 1: Send OTP for Forgot MPIN
     */
    public function forgotMpin(Request $request){

        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|exists:user_logins,mobile',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Generate a 4-digit OTP
        // $otp = rand(1000, 9999);
        $otp = 1234;

        // Update OTP in the database
        $userLogin = UserLogin::where('mobile', $request->mobile)
        ->where('country_code', $request->country_code)
        ->first();
        if ($userLogin) {
            $userLogin->otp = $otp;
            $userLogin->save();

            // TODO: Send OTP via SMS (Integrate SMS API here)

            return response()->json([
                'status' => true,
                'message' => 'OTP sent to your mobile.'
            ], 200);
        }

        return response()->json([
            'status' => false, 
            'message' => 'User not found.'
        ], 404);
    }

     /**
     * Step 2: Verify OTP for Forgot MPIN
     */
    public function verifyOtpMpin(Request $request){
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|exists:user_logins,mobile',
            'otp' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userLogin = UserLogin::where('mobile', $request->mobile)
            ->where('country_code', $request->country_code)
            ->where('otp', $request->otp)
            ->first();

        if (!$userLogin) {
            return response()->json([
                'status' => false, 
                'message' => 'Invalid OTP.'
            ], 400);
        }

        // OTP verified successfully, clear OTP and allow reset MPIN
        $userLogin->otp = null;
        $userLogin->save();

        return response()->json([
            'status' => true, 
            'message' => 'OTP verified. You can now reset MPIN.'
        ], 200);
    }

     /**
     * Step 3: Reset MPIN After OTP Verification
     */
    public function resetMpin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|exists:user_logins,mobile',
            'new_mpin' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userLogin = UserLogin::where('mobile', $request->mobile)
            ->where('country_code', $request->country_code)
            ->first();

        if (!$userLogin) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        // Hash the MPIN before saving
        $userLogin->mpin = Hash::make($request->new_mpin);
        $userLogin->save();

        return response()->json(['status' => true, 'message' => 'MPIN reset successfully.'], 200);
    }

    protected function getAuthenticatedUser()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        return $user;
    }
    public function profile(){
        $user = $this->getAuthenticatedUser();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user; // Return the response if the user is not authenticated
        }

        return response()->json([
            'status' => true,
            'message' => 'User profile retrieved successfully',
            'user' => [
                'id' => $user->id,
                'firstname' => $user->name,
                'surname' => $user->surname ?? '', // Avoid errors if surname is null
                'designation' => optional($user->designationDetails)->name ?? 'N/A', // Check if relation exists
                'email' => $user->email,
                'mobile' => $user->phone,
                'country_code' => $user->country_code_phone,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }

    public function dashboard(){
        $user = $this->getAuthenticatedUser();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user; // Return the response if the user is not authenticated
        }
        // Get total sales Amount for this user from order table
        $totalSales = Order::where('created_by', $user->id)
        ->whereDate('created_at', Carbon::today()) // Filters only today's orders
        ->sum('total_amount');

        // Get Total Collections for this user from payment_collections table
        $totalCollections = PaymentCollection::where('created_at', Carbon::today())->where('user_id', $user->id)
        ->sum('collection_amount');

        // Get All business type

        $totalBusinesstype = BusinessType::select('id', 'title', 'image')->orderBy('title', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => 'Dashboard data retrieved successfully',
            'data' => [
                'total_sales' => $totalSales,
                'total_collections' => $totalCollections,
                'total_business_type' => $totalBusinesstype
            ]
        ], 200);

    }

    public function customer_list(){
        $user = $this->getAuthenticatedUser();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user; // Return the response if the user is not authenticated
        }

        // Get All customer created by this user

        $customers = User::with('billingAddress')->where('created_by', $user->id)->orderBy('id','DESC')->get();
        // dd($customers);
        return response()->json([
            'status' => true,
            'message' => 'Customer list retrieved successfully',
            'customers' => $customers
        ], 200);
    }
    public function customer_details($id){
        $user = $this->getAuthenticatedUser();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user; // Return the response if the user is not authenticated
        }

        $details = User::with('billingAddress')->find($id);
      
        if (!$details) {
            return response()->json([
                'status' => false,
                'message' => 'Customer details not found',
            ], 404);
        }
        $latest_order = Order::select('id', 'order_number', 'total_amount','created_at')
        ->where('customer_id', $id)
        ->where('created_by', $user->id)
        ->with(['items' => function ($query) {
            $query->select('order_id', 'product_name'); // Fetch only relevant columns
        }])
        ->withCount('items') // Get the count of related items
        ->latest('id')
        ->get();
        $orders = [];
      
        if(count($latest_order)>0){
            foreach($latest_order as $key => $item){
                $orders[$key]['id'] =$item->id; 
                $orders[$key]['order_number'] =$item->order_number; 
                $orders[$key]['total_amount'] =$item->total_amount;
                $extra_item = count($item->items)==1?"":" +(".(count($item->items)-1)." Item)";
                $orders[$key]['products'] =count($item->items)==1?$item->items[0]->product_name.$extra_item:"N/A"; 
                $orders[$key]['order_date'] = date('d-m-y', strtotime($item->created_at)); 
            }
        }
       
        $ledgerCredit=Ledger::where('customer_id',$id)->where('is_credit',1)->sum('transaction_amount');
        $ledgerDebit=Ledger::where('customer_id',$id)->where('is_debit',1)->sum('transaction_amount');
        
        $data = [];
        $data['details']=$details;
        $data['latest_orders']=$orders;
        $data['wallet']=$ledgerCredit;
        $data['collectionAmount']=$ledgerDebit;
        return response()->json([
            'status' => true,
            'message' => 'Customer data retrieved successfully',
            'data' => $data,
        ], 200);
    }

    public function customer_filter(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user; // Return the response if the user is not authenticated
        }
        $filter = $request->keyword;
        
        // Fetch filtered users
        $users = User::with('billingAddress')->where('user_type', 1)
            ->where('status', 1)
            ->when($filter, function ($query) use ($filter) {
                $query->where(function ($q) use ($filter) {
                    $q->where('name', 'like', "%{$filter}%")
                    ->orWhere('phone', 'like', "%{$filter}%")
                    ->orWhere('whatsapp_no', 'like', "%{$filter}%")
                    ->orWhere('company_name', 'like', "%{$filter}%")
                    ->orWhere('email', 'like', "%{$filter}%");
                });
            })
            ->where('created_by', $user->id)
            ->take(20)
            ->get();
          
            // Fetch orders and get the first matching customer's details
            $order = Order::where('order_number', 'like', "%{$filter}%")
                ->orWhereHas('customer', function ($query) use ($filter) {
                    $query->where('name', 'like', "%{$filter}%");
                })
                ->where('created_by', $user->id)
                ->latest()
                ->first(); // Fetch only the first order directly
            
            if ($order && $order->customer) {
                $users->prepend($order->customer);
            }
            
            // $data = $users->map(function ($user) {
            //     return [
            //         'id' => $user->id,
            //         'name' => $user->name,
            //         'email' => $user->email,
            //         'phone' => $user->phone,
            //     ];
            // });
        return response()->json([
            'status' => true,
            'message' => 'Data fetched successfully!',
            'data' => $users,
        ],200);
    }
    public function customer_store(Request $request){
        $authUser = $this->getAuthenticatedUser();
        $phone_code_length = $request->phone_code_length;
        $whatsapp_code_length = $request->whatsapp_code_length;
        $alternative_phone_1_code_length = $request->alternative_phone_1_code_length;
        $alternative_phone_2_code_length = $request->alternative_phone_2_code_length;
        $rules = [
            'prefix' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_code' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^\d{'. $phone_code_length .'}$/',
            ],
            'whatsapp_code' => 'required|string|max:255',
            'whatsapp_no' => [
                'required',
                'regex:/^\d{'. $whatsapp_code_length .'}$/',
            ],
            'country_code_alt_1' => 'nullable|string|max:255',
            'alternative_phone_number_1' => [
                'nullable',
                'regex:/^\d{'. $alternative_phone_1_code_length .'}$/',
            ],

            'country_code_alt_2' => 'nullable|string|max:255',
            'alternative_phone_number_2' => [
                'nullable',
                'regex:/^\d{'. $alternative_phone_2_code_length .'}$/',
            ],
            
            'dob' => 'required|date',
            'company_name' => 'nullable|string|max:255',
            'employee_rank' => 'nullable|string|max:255',
           
            'billing_address' => 'required|string',
            'billing_landmark' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_country' => 'required|string|max:255',
            'billing_pin' => 'nullable|string|max:10',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'verified_video' => 'nullable|file|mimes:mp4,avi,mkv|max:10240',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // Return error response if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        
        DB::beginTransaction();

        try {
            $profileImagePath = $request->hasFile('profile_image')
                ? 'storage/' . $request->file('profile_image')->store('profile_images', 'public')
                : null;

            $verifiedVideoPath = $request->hasFile('verified_video')
                ? 'storage/' . $request->file('verified_video')->store('verified_videos', 'public')
                : null;
            // Create the user
            $user = User::create([
                'prefix' => $request->prefix,
                'name' => $request->name,
                'email' => $request->email,
                'country_code_phone' => $request->phone_code,
                'phone' => $request->phone,
                'country_code_whatsapp' => $request->whatsapp_code,
                'whatsapp_no' => $request->whatsapp_no,
                'country_code_alt_1' => $request->country_code_alternative_1,
                'alternative_phone_number_1' => $request->alternative_phone_number_1,
                'country_code_alt_2' => $request->country_code_alternative_2,
                'alternative_phone_number_2'  => $request->alternative_phone_number_2,
                'dob' => $request->dob,
                'company_name' => $request->company_name,
                'employee_rank' => $request->employee_rank,
                'profile_image' => $profileImagePath,
                'user_type' => 1,
                'created_by' => $authUser->id,
                'verified_video' => $verifiedVideoPath,
            ]);
            // Save billing address
            UserAddress::create([
                'user_id' => $user->id,
                'address_type' => 1, // Billing address
                'address' => $request->billing_address,
                'landmark' => $request->billing_landmark,
                'city' => $request->billing_city,
                'country' => $request->billing_country,
                'zip_code' => $request->billing_pin,
            ]);
            DB::commit();

            // Return success response
            return response()->json([
                'status' => true,
                'message' => 'Customer information saved successfully!',
                'user' => $user->load('userAddress'),
            ]);
        } catch (\Exception $e) {
            // Log error and return response
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function customer_update($id, Request $request){
        $phone_code_length = $request->phone_code_length;
        $whatsapp_code_length = $request->whatsapp_code_length;
        $alternative_phone_1_code_length = $request->alternative_phone_1_code_length;
        $alternative_phone_2_code_length = $request->alternative_phone_2_code_length;
        // dd($whatsapp_code_length);
        // Validation Rules
        $rules = [
            'prefix' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_code' => 'required|string|max:10',
            'phone' => [
                'required',
                "regex:/^\d{{$phone_code_length}}$/",
            ],
            'whatsapp_code' => 'required|string|max:10',
            'whatsapp_no' => [
                'required',
                "regex:/^\d{{$whatsapp_code_length}}$/",
            ],
            'country_code_alt_1' => 'nullable|string|max:255',
            'alternative_phone_number_1' => [
                'nullable',
                'regex:/^\d{'. $alternative_phone_1_code_length .'}$/',
            ],

            'country_code_alt_2' => 'nullable|string|max:255',
            'alternative_phone_number_2' => [
                'nullable',
                'regex:/^\d{'. $alternative_phone_2_code_length .'}$/',
            ],
            
            'dob' => 'required|date',
            'company_name' => 'nullable|string|max:255',
            'employee_rank' => 'nullable|string|max:255',
            'billing_address' => 'required|string',
            'billing_landmark' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_country' => 'required|string|max:255',
            'billing_pin' => 'nullable|string|max:10',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'verified_video' => 'nullable|file|mimes:mp4,avi,mkv|max:10240',
        ];

        // Validate input data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Find user by ID
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found!',
                ], 404);
            }

            // Handle Profile Image Upload
            if ($request->hasFile('profile_image')) {
                // Delete the old profile image if exists
                if ($user->profile_image && Storage::exists($user->profile_image)) {
                    Storage::delete($user->profile_image);
                }
                $profileImagePath = 'storage/' . $request->file('profile_image')->store('profile_images', 'public');
            } else {
                $profileImagePath = $user->profile_image;
            }

            // Handle Verified Video Upload
            if ($request->hasFile('verified_video')) {
                if ($user->verified_video && Storage::exists($user->verified_video)) {
                    Storage::delete($user->verified_video);
                }
                $verifiedVideoPath = 'storage/' . $request->file('verified_video')->store('verified_videos', 'public');
            } else {
                $verifiedVideoPath = $user->verified_video;
            }

            // Update user information
            $user->update([
                'prefix' => $request->prefix,
                'name' => $request->name,
                'email' => $request->email,
                'country_code_phone' => $request->phone_code,
                'phone' => $request->phone,
                'country_code_whatsapp' => $request->whatsapp_code,
                'whatsapp_no' => $request->whatsapp_no,
                'country_code_alt_1' => $request->country_code_alternative_1,
                'alternative_phone_number_1' => $request->alternative_phone_number_1,
                'country_code_alt_2' => $request->country_code_alternative_2,
                'alternative_phone_number_2'  => $request->alternative_phone_number_2,
                'dob' => $request->dob,
                'company_name' => $request->company_name,
                'employee_rank' => $request->employee_rank,
                'profile_image' => $profileImagePath,
                'verified_video' => $verifiedVideoPath,
            ]);

            // Update or Create Billing Address
            UserAddress::updateOrCreate(
                ['user_id' => $user->id, 'address_type' => 1], // Billing Address Type
                [
                    'address' => $request->billing_address,
                    'landmark' => $request->billing_landmark,
                    'city' => $request->billing_city,
                    'country' => $request->billing_country,
                    'zip_code' => $request->billing_pin,
                ]
            );

            DB::commit();

            // Return Success Response
            return response()->json([
                'status' => true,
                'message' => 'Customer information updated successfully!',
                'user' => $user->load('billingAddress'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Update failed: ' . $e->getMessage(),
            ]);
        }
    }

   
}
