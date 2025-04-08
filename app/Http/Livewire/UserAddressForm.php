<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Country;
use App\Models\UserWhatsapp;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserAddressForm extends Component
{
    use WithFileUploads;

    public $id,$prefix, $name,$dob, $company_name,$employee_rank, $email, $phone, $whatsapp_no, $gst_number, $credit_limit, $credit_days,$gst_certificate_image,$image,$isWhatsappPhone,$isWhatsappAlt1,$isWhatsappAlt2;
    public $address_type, $address, $landmark, $city, $state, $country, $zip_code , $alternative_phone_number_1, $alternative_phone_number_2;
    public $billing_address;
    public $billing_landmark;
    public $billing_city;
    public $billing_state;
    public $billing_country;
    public $billing_pin;
    
    public $is_billing_shipping_same;

    public $shipping_address;
    public $shipping_landmark;
    public $shipping_city;
    public $shipping_state;
    public $shipping_country;
    public $shipping_pin;
    public $tempImageUrl;
    public $country_code;
    public $country_id;
    // public $filteredCountries = [];
    public $countries = [];
    public $selectedCountryPhone,$selectedCountryWhatsapp,$selectedCountryAlt1,$selectedCountryAlt2;
    public $mobileLengthPhone,$mobileLengthWhatsapp,$mobileLengthAlt1,$mobileLengthAlt2;
    public $badge_type;


    public function mount(){
        $this->countries = Country::where('status',1)->get();
    }

    public function GetCountryDetails($mobileLength, $field){
        switch($field){
            case 'phone':
                $this->mobileLengthPhone  = $mobileLength;
                break;

            // case 'whatsapp':
            //     $this->mobileLengthWhatsapp = $mobileLength;
            //     break;

            case 'alt_phone_1':
                $this->mobileLengthAlt1 = $mobileLength;
                break;
            
            case 'alt_phone_2':
                $this->mobileLengthAlt2 = $mobileLength;
                break;
        }
    }

    // Function to watch for changes in is_billing_shipping_same
    // public function toggleShippingAddress()
    // {
    //     // When the checkbox is checked
    //     if ($this->is_billing_shipping_same) {
    //         // Copy billing address to shipping address
    //         $this->shipping_address = $this->billing_address;
    //         $this->shipping_landmark = $this->billing_landmark;
    //         $this->shipping_city = $this->billing_city;
    //         $this->shipping_state = $this->billing_state;
    //         $this->shipping_country = $this->billing_country;
    //         $this->shipping_pin = $this->billing_pin;
    //     } else {
    //         // Reset shipping address fields
    //         $this->shipping_address = '';
    //         $this->shipping_landmark = '';
    //         $this->shipping_city = '';
    //         $this->shipping_state = '';
    //         $this->shipping_country = '';
    //         $this->shipping_pin = '';
    //     }
    // }

    
    public function rules()
    {
        // Base rules
        $rules = [
            'prefix'=> 'required',
            'name' => 'required|string|max:255',
            'employee_rank' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
            // 'verified_video' => 'nullable|mimes:mp4,mov,avi,wmv',
            'company_name'=>'nullable|string|max:255',
            'email' => 'nullable|email',
            'badge_type' => 'required|in:general,premium',
            'dob'=> 'nullable|date',
             'phone' => [
                'required',
                'regex:/^\d{'. $this->mobileLengthPhone .'}$/',
            ],
            // 'whatsapp_no' => [
            //     'required',
            //     'regex:/^\d{'. $this->mobileLengthWhatsapp .'}$/',
            // ],
            'gst_number' => 'nullable|string|max:15',
            'credit_limit' => 'nullable|numeric',
            'credit_days' => 'nullable|integer',
            // Billing address validation
            'billing_address' => 'required|string',
            'billing_landmark' => 'nullable|string',
            'billing_city' => 'required|string',
            'billing_state' => 'nullable|string',
            'billing_country' => 'required|string',
            'billing_pin' => 'nullable|string',
            'alternative_phone_number_1' => [
                'nullable',
                'regex:/^\d{'. $this->mobileLengthAlt1 .'}$/',
            ],
            'alternative_phone_number_2' => [
                'nullable',
                'regex:/^\d{'. $this->mobileLengthAlt2 .'}$/',
            ],  
        ];
    
        // Conditional shipping address rules based on the checkbox
        // if (!$this->is_billing_shipping_same) {
        //     $rules['shipping_address'] = 'required|string';
        //     $rules['shipping_landmark'] = 'nullable|string';
        //     $rules['shipping_city'] = 'required|string';
        //     $rules['shipping_state'] = 'nullable|string';
        //     $rules['shipping_country'] = 'required|string';
        //     $rules['shipping_pin'] = 'nullable|string';
        // } else {
        //     // If the shipping address is the same as the billing address, make the fields optional
        //     $rules['shipping_address'] = 'nullable|string';
        //     $rules['shipping_landmark'] = 'nullable|string';
        //     $rules['shipping_city'] = 'nullable|string';
        //     $rules['shipping_state'] = 'nullable|string';
        //     $rules['shipping_country'] = 'nullable|string';
        //     $rules['shipping_pin'] = 'nullable|string';
        // }
    
        return $rules;
    }
    public function messages()
{
    return [
        'prefix.required' => 'The prefix field is required.',
        'name.required' => 'Please enter your full name.',
        'name.max' => 'The name cannot exceed 255 characters.',
        'employee_rank.string' => 'Employee rank must be a valid text.',
        'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        'company_name.string' => 'Company name must be a valid text.',
        'company_name.max' => 'Company name cannot exceed 255 characters.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already in use.',
        'phone.required' => 'Phone number is required.',
        'phone.regex' => 'Phone number must be exactly ' . $this->mobileLengthPhone . ' digits.',
        // 'whatsapp_no.required' => 'WhatsApp number is required.',
        // 'whatsapp_no.regex' => 'WhatsApp number must be exactly ' . $this->mobileLengthWhatsapp . ' digits.',
        'gst_number.max' => 'GST number cannot exceed 15 characters.',
        'credit_limit.numeric' => 'Credit limit must be a valid number.',
        'credit_days.integer' => 'Credit days must be a valid integer.',
        'billing_address.required' => 'Address is required.',
        'billing_city.required' => 'City is required.',
        'billing_country.required' => 'Country is required.',
        'alternative_phone_number_1.regex' => 'Alternative phone number 1 must be exactly ' . $this->mobileLengthAlt1 . ' digits.',
        'alternative_phone_number_2.regex' => 'Alternative phone number 2 must be exactly ' . $this->mobileLengthAlt2 . ' digits.',
        // 'shipping_address.required' => 'Shipping address is required when billing and shipping addresses are different.',
        // 'shipping_city.required' => 'Shipping city is required when billing and shipping addresses are different.',
        // 'shipping_country.required' => 'Shipping country is required when billing and shipping addresses are different.',
    ];
}

    
    private function uploadImage()
    {
        if ($this->image) {
            $timestamp = now()->timestamp;
            $extension = $this->image->getClientOriginalExtension();
            $imageName = $timestamp . '.' . $extension;
            $storedPath =  $this->image->storeAs('profile_image', $imageName, 'public');
            return 'storage/' . $storedPath;
        }
        return null;
    }
    

    // private function uploadVideo()
    // {
    //     if ($this->verified_video) {
    //         $timestamp = now()->timestamp;
    //         $extension = $this->verified_video->getClientOriginalExtension();
    //         $videoName = $timestamp . '.' . $extension;

    //         // Store the video and return the path
    //         $storedVideoPath =  $this->verified_video->storeAs('verified_video', $videoName, 'public');
    //         return 'storage/'.$storedVideoPath;
    //     }
    //     return null;
    // }

    public function updatedImage(){
        if($this->image){
            $this->tempImageUrl = $this->image->temporaryUrl();
        }
    }


    private function uploadGSTCertificate()
    {
        // Handle file upload
        if ($this->gst_certificate_image) {
            $timestamp = now()->timestamp;
            $imageName = $timestamp . '-' . $this->gst_certificate_image->getClientOriginalExtension();
            $storedGstPath =  $this->gst_certificate_image->storeAs('gst_certificate_image', $imageName, 'public');
            return "storage/".$storedGstPath;
        }
        return null;
    }
    
    public function save()
    {
        // dd($this->all());
        // Start the transaction
        $this->validate();
        DB::beginTransaction();
        
        try {
            // Check if a user already exists and delete the old image if necessary
            if ($this->id) { 
                $existingUser = User::find($this->id);
                if ($existingUser && $existingUser->profile_image) {
                    // Delete the old image from storage
                    \Storage::disk('public')->delete($existingUser->profile_image);
                }
            }

            // Store user data
            $imagePath = $this->uploadImage(); 
            // $videoPath = $this->verified_video ? $this->uploadVideo() : null;
            $auth = Auth::guard('admin')->user();
            $userData = [
                'prefix' => $this->prefix,
                'name' => $this->name,
                'customer_badge' => $this->badge_type,
                'profile_image' => $imagePath,
                // 'verified_video' =>  $videoPath,
                'company_name' => $this->company_name,
                'employee_rank' => $this->employee_rank,
                'email' => $this->email,
                'dob'=>$this->dob,
                'country_code_phone' => $this->selectedCountryPhone,
                'phone' => $this->phone,
                'country_code_whatsapp' => $this->selectedCountryWhatsapp,
                // 'whatsapp_no' => $this->whatsapp_no,
                'gst_number' => $this->gst_number,
                'credit_limit' => $this->credit_limit === '' ? 0 : $this->credit_limit,
                'credit_days' => $this->credit_days === '' ? 0 : $this->credit_days,
                'gst_certificate_image' => $this->gst_certificate_image ? $this->uploadGSTCertificate() : null,
                'country_id' => $this->country_id,// Handle file upload
                // 'country_code' => $this->country_code,
                'country_code_alt_1'  => $this->selectedCountryAlt1,
                'alternative_phone_number_1'=> $this->alternative_phone_number_1,
                'country_code_alt_2'  => $this->selectedCountryAlt2,
                'alternative_phone_number_2' => $this->alternative_phone_number_2,
                'created_by' => $auth->id
            ];
        
            
            $user = User::create($userData);

            if($this->isWhatsappPhone){
                $existingRecord = UserWhatsapp::where('whatsapp_number', $this->phone)
                                                    ->where('user_id', '!=', $user->id)
                                                    ->exists();
                if(!$existingRecord){
                    UserWhatsapp::updateOrCreate(
                        ['user_id' => $user->id,
                        'whatsapp_number' => $this->phone,
                        ],
                        ['country_code' => $this->selectedCountryPhone,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }


            if ($this->isWhatsappAlt1) {
                $existingRecord = UserWhatsapp::where('whatsapp_number', $this->alternative_phone_number_1)
                                                ->where('user_id', '!=', $user->id)
                                                ->exists();
                if(!$existingRecord){
                UserWhatsapp::updateOrCreate([
                    'user_id' => $user->id,
                    'whatsapp_number' => $this->alternative_phone_number_1
                    ],
                    ['country_code' => $this->selectedCountryAlt1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
              }
            }
    
            if ($this->isWhatsappAlt2) {
                $existingRecord = UserWhatsapp::where('whatsapp_number', $this->alternative_phone_number_1)
                                                ->where('user_id', '!=', $user->id)
                                                ->exists();
                if(!$existingRecord){
                UserWhatsapp::updateOrCreate([
                    'user_id' => $user->id,
                    'whatsapp_number' => $this->alternative_phone_number_2,
                    ],
                    ['country_code' => $this->selectedCountryAlt2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
              }
            }

            // Store billing address
            $this->storeAddress($user->id, 1, $this->billing_address, $this->billing_landmark, $this->billing_city, $this->billing_state, $this->billing_country, $this->billing_pin);

            // Check if shipping address is the same as billing address
            // if(!$this->is_billing_shipping_same){
            //     // Store shipping address separately
            //     $this->storeAddress($user->id, 2, $this->shipping_address, $this->shipping_landmark, $this->shipping_city, $this->shipping_state, $this->shipping_country, $this->shipping_pin);
            // }else{
            //     // Store shipping address as the same as billing
            //     $this->storeAddress($user->id, 2, $this->billing_address, $this->billing_landmark, $this->billing_city, $this->billing_state, $this->billing_country, $this->billing_pin);
            // }

            // Commit the transaction
            DB::commit();
            session()->flash('success', 'Customer information saved successfully!');
            return redirect()->route('customers.index');
        } catch (\Exception $e) {
            // In case of an error, rollback the transaction
            DB::rollBack();

            // Log the exception
            \Log::error('Error saving customer information: ' . $e->getMessage());
            dd($e->getMessage());
            // Flash error message
            session()->flash('error', 'An error occurred while saving the customer information. Please try again.');

            // Return to the previous page with error message
            return back();
        }

    }

   

    private function storeAddress($userId,$addressType,$address,$landmark,$city,$state,$country,$zipCode){
        // Store address in the user_address table
        Useraddress::create([
            'user_id'=>$userId,
            'address_type'=>$addressType,
            'address'=>$address,
            'landmark'=>$landmark,
            'city'=>$city,
            'state'=>$state,
            'country'=>$country,
            'zip_code'=>$zipCode
        ]);
    }   
    

    public function render()
    {
        return view('livewire.user-address-form');
    }
}
