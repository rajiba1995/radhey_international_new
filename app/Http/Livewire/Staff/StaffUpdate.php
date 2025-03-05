<?php

namespace App\Http\Livewire\Staff;

use Livewire\Component;
use App\Models\User;
use App\Models\Country;
use App\Models\Designation;
use App\Models\BusinessType;
use App\Models\Branch;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;


class StaffUpdate extends Component
{
    use WithFileUploads;

    public $staff,$branchNames, $designation, $person_name, $surname, $emp_code, $prof_name, $email, $mobile, $aadhaar_number, $whatsapp_no , $passport_no , $dob, $passport_issued_date , $visa_no;
    public $image, $passport_id_front, $passport_id_back , $passport_expiry_date;
    public $account_holder_name, $bank_name, $branch_name, $account_no, $ifsc;
    public $monthly_salary, $daily_salary, $travel_allowance;
    public $address, $landmark, $state, $city, $pincode, $country;
    public $staff_id,$is_wa_same,$designations,$user_id;  // Variable to hold the staff id
    public $Selectcountry;
    public $selectedCountryId;
    public $Business_type;
    public $selectedBusinessType;
    public $selectedBranchId;
    public $showRequiredFields = false;
    public $filteredCountries = [];
    public $searchTerm;


    public function mount($staff_id){
        $this->staff = User::with(['branch','businessType','bank','address','designationDetails'])->find($staff_id);
        $this->Selectcountry = Country::all();
        $this->Business_type = BusinessType::all();
        $this->branchNames = Branch::all();
        $this->selectedCountryId = $this->staff->country_id;
        $this->selectedBusinessType = $this->staff->business_type;
        $this->selectedBranchId = $this->staff->branch_id;
        $this->showRequiredFields = $this->selectedCountryId == 1;
        // dd( $this->staff->designationDetails->id);
        $this->designations = Designation::latest()->get();
         // If staff exists, assign the data to the public variables
         if ($this->staff) {
            $this->searchTerm = Country::where('id',$this->staff->country_id)->pluck('title');
            $this->designation = $this->staff->designationDetails->id;
            $this->person_name = $this->staff->name;
            $this->surname = $this->staff->surname;
            $this->emp_code = $this->staff->emp_code;
            $this->prof_name = $this->staff->prof_name;
            $this->email = $this->staff->email;
            $this->mobile = $this->staff->phone;
            $this->aadhaar_number = $this->staff->aadhar_name;
            $this->whatsapp_no = $this->staff->whatsapp_no;
            $this->is_wa_same = ($this->staff->phone == $this->staff->whatsapp_no) ? 1: 0;
            $this->image = $this->staff->image;
            $this->passport_id_front = $this->staff->passport_id_front;
            $this->passport_id_back = $this->staff->passport_id_back;
            $this->passport_expiry_date = $this->staff->passport_expiry_date;
            $this->passport_no = $this->staff->passport_no;
            $this->dob = $this->staff->dob;
            $this->passport_issued_date = $this->staff->passport_issued_date;
            $this->visa_no = $this->staff->visa_no;
            // Bank Information
            $this->account_holder_name = $this->staff->bank->account_holder_name;
            $this->bank_name = $this->staff->bank->bank_name;
            $this->branch_name = $this->staff->bank->branch_name;
            $this->account_no = $this->staff->bank->bank_account_no;
            $this->ifsc = $this->staff->bank->ifsc;
            $this->monthly_salary = $this->staff->bank->monthly_salary;
            $this->daily_salary = $this->staff->bank->bonus;
            $this->travel_allowance = $this->staff->bank->past_salaries;
              // Address Information
            $this->address = $this->staff->address->address;
            $this->landmark = $this->staff->address->landmark;
            $this->state = $this->staff->address->state;
            $this->city = $this->staff->address->city;
            $this->pincode = $this->staff->address->zip_code;
            $this->country = $this->staff->address->country;
        }


    }

    public function FindCustomer($term)
    {
        $this->searchTerm = $term;
        if (!empty($this->searchTerm)) {
            $this->filteredCountries = Country::where('title', 'LIKE', '%' . $this->searchTerm . '%')->get();
        } else {
            $this->filteredCountries = [];
        }
    }

    public function selectCountry($countryId)
    {
        $this->selectedCountryId = $countryId;
        $this->searchTerm = Country::where('id', $countryId)->value('title'); // Update input field
        $this->filteredCountries = []; // Hide dropdown after selection
    }
    
    public function SelectedCountry($value)
    {
        $this->selectedCountryId = $value;
        $this->showRequiredFields = $value == 1;
    }

    public function update(){
        $isIndia = $this->selectedCountryId == 1;
        $this->validate([
            'designation' => 'required',
            'person_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'mobile' => [
                'required',
                'regex:/^\+?\d{' . env('VALIDATE_MOBILE', 8) . ',}$/',
            ],
            'whatsapp_no' => [
                'required',
                'regex:/^\+?\d{' . env('VALIDATE_WHATSAPP', 8) . ',}$/',
            ],
            'aadhaar_number' => $isIndia ? 'required|numeric' : 'nullable|numeric',
            'passport_no'=> $isIndia ?  'required|numeric' : 'nullable|numeric',
            'visa_no'=> $isIndia ?  'required|numeric' : 'nullable|numeric',
            'image' => 'nullable|max:2048',
            'passport_id_front' => 'nullable|max:2048',
            'passport_id_back' => 'nullable|max:2048',
            'passport_expiry_date' => 'nullable',
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
            'state' => $isIndia ? 'required|string' : 'nullable:string',
            'city' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
       ]);
    try {
        
       // Store the files
       $imagePath = $this->image && $this->image instanceof \Illuminate\Http\UploadedFile ? $this->image->store('images', 'public') : $this->staff->image;
       $passportIdFrontPath = $this->passport_id_front && $this->passport_id_front instanceof \Illuminate\Http\UploadedFile ? $this->passport_id_front->store('user_ids', 'public') : $this->staff->passport_id_front;
       $passportIdBackPath = $this->passport_id_back && $this->passport_id_back instanceof \Illuminate\Http\UploadedFile ? $this->passport_id_back->store('user_ids', 'public') : $this->staff->passport_id_back;
       
         // Update the staff record
         $this->staff->update([
            'country_id'=> $this->selectedCountryId,
            'branch_id'=> $this->selectedBranchId,
            'designation'=> $this->designation,
            'name' => $this->person_name ?? '',
            'emp_code' => $this->emp_code ?? '',
            'surname' => $this->surname ?? '',
            'prof_name' => $this->prof_name ?? '',
            'dob' => $this->dob ?? '',
            'business_type' => $this->selectedBusinessType ?? '',
            'email' => $this->email ?? '',
            'phone' => $this->mobile ?? '',
            'aadhar_name' => $this->aadhaar_number ?? '',
            'whatsapp_no' => $this->whatsapp_no ?? '',
            'image' => $imagePath ?? '',
            'passport_id_front' => $passportIdFrontPath ?? '',
            'passport_id_back' => $passportIdBackPath ?? '',
            'passport_no' => $this->passport_no ?? '',
            'visa_no' => $this->visa_no ?? '',
            'passport_expiry_date' => !empty($this->passport_expiry_date) ? $this->passport_expiry_date : null,
            'passport_issued_date' => !empty($this->passport_issued_date) ? $this->passport_issued_date : null,
        ]);
        // Update bank details
        if ($this->staff->bank) {
            $this->staff->bank->update([
                'account_holder_name' => $this->account_holder_name ?? '',
                'bank_name' => $this->bank_name ?? '',
                'branch_name' => $this->branch_name ?? '',
                'bank_account_no' => $this->account_no ?? '',
                'ifsc' => $this->ifsc ?? '',
                'monthly_salary' => is_numeric($this->monthly_salary) ? $this->monthly_salary : null,
                'daily_salary' => is_numeric($this->daily_salary) ?  $this->daily_salary : null,
                'travelling_allowance' => is_numeric($this->travel_allowance) ? $this->travel_allowance : null,
            ]);
        } else {
            // If no bank record, create a new one
            $this->staff->bank()->create([
                'account_holder_name' => $this->account_holder_name ?? '',
                'bank_name' => $this->bank_name ?? '',
                'branch_name' => $this->branch_name ?? '',
                'bank_account_no' => $this->account_no ?? '',
                'ifsc' => $this->ifsc ?? '',
                'monthly_salary' => is_numeric($this->monthly_salary) ? $this->monthly_salary : null,
                'bonus' => is_numeric($this->daily_salary) ?  $this->daily_salary : null,
                'past_salaries' => is_numeric($this->travel_allowance) ? $this->travel_allowance : null,
            ]);
        }
         // Update address details
         if ($this->staff->address) {
            $this->staff->address->update([
                'address' => $this->address ?? '',
                'address_type' => 1,
                'landmark' => $this->landmark ?? '',
                'state' => $this->state ?? '',
                'city' => $this->city ?? '',
                'zip_code' => $this->pincode ?? '',
                'country' => $this->country ?? '',
            ]);
        } else {
            // If no address record, create a new one
            $this->staff->address()->create([
                'address' => $this->address ?? '',
                'address_type' => 1,
                'landmark' => $this->landmark ?? '',
                'state' => $this->state ?? '',
                'city' => $this->city ?? '',
                'zip_code' => $this->pincode ?? '',
                'country' => $this->country ?? '',
            ]);
        }

        session()->flash('message', 'Staff updated successfully');
        return redirect()->route('staff.index');
    } catch (\Exception $e) {
        // If any error occurs, catch it and flash an error message
        session()->flash('error', 'There was an error while updating the staff: ' . $e->getMessage());
        // dd($e->getMessage());
        // Optionally log the error for debugging purposes
        \Log::error('Staff update failed: ' . $e->getMessage());

        // Redirect back to the edit page or wherever necessary
        return back();
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

    public function render()
    {
        return view('livewire.staff.staff-update',['designations'=>$this->designations]);
    }
}
