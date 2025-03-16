<?php

namespace App\Http\Livewire\Staff;

use Livewire\Component;
use App\Models\Designation;
use App\Models\UserBank;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Country;
use App\Models\Branch;
use App\Models\BusinessType;
use App\Helpers\Helper;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class StaffAdd extends Component
{
    use WithFileUploads;
    public $employee_id,$emp_code,$dob,$branch_id,$passport_issued_date,$designation, $prefix, $person_name, $prof_name, $surname, $email, $mobile, $aadhaar_number, $whatsapp_no,$is_wa_same,$user_id,$passport_no,$visa_no;
    public $image, $passport_id_front, $passport_id_back, $passport_expiry_date;
    public $account_holder_name, $bank_name, $branch_name, $account_no, $ifsc, $monthly_salary, $daily_salary, $travel_allowance;
    public $address, $landmark, $state, $city, $pincode, $country;
    public $designations = [];
    public $branchNames = [];
    public $Selectcountry;
    public $filteredCountries = []; 
    public $selectedCountryId;
    public $searchTerm;
    public $Business_type;
    public $selectedBusinessType ;
    public $showRequiredFields  = false;
    public $emergency_contact_person,$emergency_mobile,$emergency_whatsapp,$emergency_address,$same_as_contact;
    public $countryCode;
    public $country_code;
    public $mobileLength;
    public $alternative_phone_number_1;
    public $alternative_phone_number_2;
    public $password;

    public function mount(){
        $this->designations = Designation::where('status',1)->orderBy('name', 'ASC')->where('id', '!=', 1)->get();
        $this->branchNames  = Branch::all();
        $this->Selectcountry = Country::all();
        $this->Business_type = BusinessType::all();
        $this->selectedCountryId = null;
        $this->selectedBusinessType  = null;
        $this->emp_code = $this->generateEmpCode();
    }

    public function generateEmpCode(){
        $lastUser = User::where('emp_code', 'LIKE', 'RI-%')
        ->orderBy('emp_code', 'DESC')
        ->first();

        if ($lastUser && preg_match('/RI-(\d+)/', $lastUser->emp_code, $matches)) {
            $nextNumber = str_pad($matches[1] + 1, 2, '0', STR_PAD_LEFT); 
        } else {
            $nextNumber = '01'; 
        }

        return 'RI-' . $nextNumber;
    }
  

    // public function SelectedCountry()
    // {
    //     $this->showRequiredFields  = $this->selectedCountryId == 1;
    // }

    public function FindCountry($term){
        $this->searchTerm = $term;
        if (!empty($this->searchTerm)) {
            $this->filteredCountries = Country::where('title', 'LIKE', '%' . $this->searchTerm . '%')->get();
        }else{
            $this->filteredCountries = [];
        }
    }

    public function selectCountry($countryId){
        $country = Country::find($countryId);
        if($country){
            $this->selectedCountryId = $country->id;
            $this->searchTerm  = $country->title;
            $this->country_code = $country->country_code;
            $this->mobileLength = $country->mobile_length;
        }

        // $this->country_code = $this->countryCode;

         // Hide the dropdown after selection
        $this->filteredCountries = [];
        $this->showRequiredFields  = $this->selectedCountryId == 76;

    }

    public function save(){
        // dd($this->all());
        $isIndia = $this->selectedCountryId == 76;

       $this->validate([
            'branch_id'   => 'required',
            'designation' => 'required',
            'emp_code' => 'required',
            'prefix' => 'required',
            'person_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'dob' => 'required|date|before_or_equal:today',
            'prof_name' => 'required|string|max:255',
            'selectedBusinessType' => 'required|integer',
            'searchTerm' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'alternative_phone_number_1' => [
                'nullable',
                'regex:/^\d{'. $this->mobileLength .'}$/',
            ],
            'alternative_phone_number_2' => [
                'nullable',
                'regex:/^\d{'. $this->mobileLength .'}$/',
            ],
          'mobile' => [
                'required',
                'regex:/^\d{'. $this->mobileLength .'}$/',
            ],
            'whatsapp_no' => [
                'required', // At least VALIDATE_WHATSAPP digits
                'regex:/^\d{'. $this->mobileLength .'}$/',
            ],
            'passport_no'=> $isIndia ?  'required|numeric' : 'nullable|numeric',
            'visa_no'=> $isIndia ?  'required|numeric' : 'nullable|numeric',
            'aadhaar_number' => $isIndia ? 'required|numeric' : 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
            'passport_id_front' => 'nullable|image|max:2048',
            'passport_id_back' => 'nullable|image|max:2048',
            'passport_expiry_date' => 'nullable',
            'passport_issued_date' => 'nullable',
            'account_holder_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|string|max:20',
            'ifsc' => 'nullable|string|max:11',
            'monthly_salary' => 'required|numeric',
            'daily_salary' => 'nullable|numeric',
            'travel_allowance' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'state' => $isIndia ? 'required|string' : 'nullable|string',
            'city' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
            'emergency_mobile'=> [
                'nullable',
                'regex:/^\d{'. $this->mobileLength .'}$/', // At least VALIDATE_MOBILE digits
            ],
            'emergency_whatsapp'=>[
                'nullable',
                'regex:/^\d{'. $this->mobileLength .'}$/',
            ],
            'emergency_contact_person' => 'nullable|string',
            'emergency_address' => 'nullable|string',
       ],[
            'branch_id.required' => 'Please select branch',
            'designation.required' => 'Designation is required.',
            'emp_code.required' => 'Employee code is required.',
            'person_name.required' => 'Person name is required.',
            'surname.required' => 'Surname is required.',
            'dob.required' => 'Date of birth is required.',
            'prof_name.required' => 'Professional name is required.',
            'selectedBusinessType.required' => 'Business type selection is required.',
            'searchTerm.required' => 'Please search a country name',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Enter a valid mobile number.',
            'mobile.unique' => 'This mobile number is already registered.',
            
            'whatsapp_no.required' => 'WhatsApp number is required.',
            'whatsapp_no.regex' => 'Enter a valid WhatsApp number.',
            
            'passport_no.required' => 'Passport number is required.',
            'visa_no.required' => 'Visa number is required.',
            'aadhaar_number.required' => 'Aadhaar number is required.',
            
            'image.image' => 'Only image files are allowed.',
            'image.max' => 'Image size must be less than 2MB.',
            
            'monthly_salary.required' => 'Monthly salary is required.',
            'monthly_salary.numeric' => 'Enter a valid salary amount.',
            
            'state.required' => 'State is required.',
            'alternative_phone_number_1.regex' => 'Enter a valid alternative mobile number',
            'alternative_phone_number_2.regex' => 'Enter a valid alternative mobile number',
            'emergency_mobile.regex' => 'Enter a valid emergency mobile number.',
            'emergency_whatsapp.regex' => 'Enter a valid emergency WhatsApp number.',
            'emergency_contact_person.string' => 'Emergency contact person name must be text',
            'emergency_address.string' => 'Emergency address must be text',
       ]);
       DB::beginTransaction();

       try { 

            // $lastEmployee = User::where('user_type', 0)->latest('id')->first();
            // $newEmployeeId = $lastEmployee ? intval(substr($lastEmployee->employee_id, 4)) + 1 : 1;
            // $formattedEmployeeId = 'RI-' . str_pad($newEmployeeId, 3, '0', STR_PAD_LEFT);


        // Check and upload the images only if they are provided
            $imagePath = $this->image ? Helper::uploadImage($this->image, 'staff2') : null;
            $passportIdFrontPath = $this->passport_id_front ? Helper::uploadImage($this->passport_id_front, 'staff') : null;
            $passportIdBackPath = $this->passport_id_back ? Helper::uploadImage($this->passport_id_back, 'staff') : null;

            // Now, you can handle these paths accordingly (e.g., store them in the database)


            // 1. Save the data into the users table
            $user = User::create([
                // 'employee_id' => $formattedEmployeeId,
                'emp_code' => $this->emp_code,
                'business_type' => $this->selectedBusinessType,
                'surname' => $this->surname,
                'prof_name'=> $this->prof_name,
                'dob'=> $this->dob,
                'branch_id' => $this->branch_id,
                'country_id'=> $this->selectedCountryId,
                'user_type' => 0, //for Staff
                'designation' => $this->designation ?? "",
                'prefix'    => $this->prefix,
                'name' => ucwords($this->person_name) ?? "",
                'email' => $this->email ?? "",
                'country_code' => $this->country_code ?? '',
                'phone' => $this->mobile ?? "",
                'aadhar_name' => $this->aadhaar_number ?? "",
                'whatsapp_no' => $this->whatsapp_no ?? "",
                'image' =>  $imagePath ?? "",
                'passport_id_front' =>  $passportIdFrontPath ?? "",
                'passport_id_back' => $passportIdBackPath ?? "",
                'passport_expiry_date' => !empty($this->passport_expiry_date) ? $this->passport_expiry_date : null,
                'passport_issued_date' => !empty($this->passport_issued_date) ? $this->passport_issued_date : null,
                'passport_no' => $this->passport_no,
                'visa_no' => $this->visa_no,
                'password'=> Hash::make($this->password),
                'emergency_contact_person' => $this->emergency_contact_person ?? "",
                'emergency_mobile' => $this->emergency_mobile ?? "",
                'emergency_whatsapp' => $this->emergency_whatsapp ?? "",
                'emergency_address' => $this->emergency_address ?? "",
                'alternative_phone_number_1' => $this->alternative_phone_number_1 ?? "",
                'alternative_phone_number_2' => $this->alternative_phone_number_2 ?? ""
            ]);
            

            // 2. Save the data into the user_banks table
            UserBank::create([
                'user_id' => $user->id,
                'account_holder_name' => $this->account_holder_name ?? "",
                'bank_name' => $this->bank_name ?? "",
                'branch_name' => $this->branch_name ?? "",
                'bank_account_no' => $this->account_no ?? "",
                'ifsc' => $this->ifsc ?? "",
                'monthly_salary' => is_numeric($this->monthly_salary) ? $this->monthly_salary : null,
                'bonus' => is_numeric($this->daily_salary) ?  $this->daily_salary : null,
                'past_salaries' => is_numeric($this->travel_allowance) ? $this->travel_allowance : null,
            ]);

            // 3. Save the data into the user_address table
            UserAddress::create([
                'user_id' => $user->id,
                'address_type' => 1, //for Staff
                'address' => $this->address ?? "",
                'landmark' => $this->landmark ?? "",
                'state' => $this->state ?? "",
                'city' => $this->city ?? "",
                'zip_code' => $this->pincode ?? "",
                'country' => $this->country ?? "",
            ]);

            // Commit the transaction if everything is successful
            DB::commit();

            session()->flash('message', 'Staff information saved successfully!');
            return redirect()->route('staff.index');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Handle the exception (e.g., log the error and show an error message)
            session()->flash('error', 'An error occurred while saving staff information: ' . $e->getMessage());
            // dd($e->getMessage());
            return back()->withInput();
        }
    }

    public function SameAsMobile(){
        if($this->is_wa_same == 0){
            $this->whatsapp_no = $this->mobile;
            $this->is_wa_same =1;
        }else{
            $this->whatsapp_no = '';
            $this->is_wa_same = 0;
        }
    }

    public function SameAsContact(){
        if($this->same_as_contact == 0){
            $this->emergency_whatsapp = $this->emergency_mobile;
            $this->same_as_contact = 1;
        }else{
            $this->emergency_whatsapp = '';
            $this->same_as_contact = 0;
        }

    }


    public function render()
    {
        return view('livewire.staff.staff-add');
    }
}
