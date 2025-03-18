<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Supplier;
use App\Models\Country;
use App\Models\UserWhatsapp;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplierEdit extends Component
{
    use WithFileUploads;

    public $prefix, $supplier, $name, $email, $mobile, $is_wa_same, $whatsapp_no;
    public $billing_address, $billing_landmark, $billing_state, $billing_city, $billing_pin, $billing_country;
    public $gst_number, $gst_file, $credit_limit, $credit_days;
    public $mobileLength;
    public $countries;
    // public $searchTerm;
    public $existingGstFile;
    public $country_code;
    public $selectedCountryId;
    public $alternative_phone_number_1;
    public $alternative_phone_number_2;
    public $selectedCountryPhone , $selectedCountryWhatsapp, $selectedCountryAlt1, $selectedCountryAlt2,
           $mobileLengthPhone , $mobileLengthWhatsapp, $mobileLengthAlt1, $mobileLengthAlt2;
    public $isWhatsappPhone, $isWhatsappAlt1, $isWhatsappAlt2;


    public function mount($id)
    {
        $this->supplier = Supplier::find($id);
        $this->prefix = $this->supplier->prefix;
        $this->name = $this->supplier->name;
        $this->email = $this->supplier->email;
        $this->mobile = $this->supplier->mobile;
        // $this->is_wa_same = ($this->supplier->mobile == $this->supplier->whatsapp_no) ? 1 : 0;
        $this->whatsapp_no = $this->supplier->whatsapp_no;
        $this->billing_address = $this->supplier->billing_address;
        $this->billing_landmark = $this->supplier->billing_landmark;
        $this->billing_state = $this->supplier->billing_state;
        $this->billing_city = $this->supplier->billing_city;
        $this->billing_pin = $this->supplier->billing_pin;
        $this->billing_country = $this->supplier->billing_country;
        $this->gst_number = $this->supplier->gst_number;
        $this->credit_limit = $this->supplier->credit_limit;
        $this->credit_days = $this->supplier->credit_days;
        // Set the existing GST file path
        $this->existingGstFile = $this->supplier->gst_file;
        $this->alternative_phone_number_1 = $this->supplier->alternative_phone_number_1;
        $this->alternative_phone_number_2 = $this->supplier->alternative_phone_number_2;

        $this->selectedCountryPhone = $this->supplier->country_code_mobile;
        $this->selectedCountryWhatsapp = $this->supplier->country_code_whatsapp;
        $this->selectedCountryAlt1 = $this->supplier->country_code_alt_1;
        $this->selectedCountryAlt2 = $this->supplier->country_code_alt_2;

        $this->mobileLengthPhone = Country::where('country_code',$this->selectedCountryPhone)->value('mobile_length') ?? '';
        $this->mobileLengthWhatsapp = Country::where('country_code',$this->selectedCountryWhatsapp)->value('mobile_length') ?? '';
        $this->mobileLengthAlt1 = Country::where('country_code',$this->selectedCountryAlt1)->value('mobile_length') ?? '';
        $this->mobileLengthAlt2 = Country::where('country_code',$this->selectedCountryAlt2)->value('mobile_length') ?? '';

        $this->isWhatsappPhone = UserWhatsapp::where('supplier_id',$this->supplier->id)->where('whatsapp_number',$this->mobile)->exists();
        $this->isWhatsappAlt1 =  UserWhatsapp::where('supplier_id',$this->supplier->id)->where('whatsapp_number',$this->alternative_phone_number_1)->exists();
        $this->isWhatsappAlt2 =  UserWhatsapp::where('supplier_id',$this->supplier->id)->where('whatsapp_number',$this->alternative_phone_number_2)->exists();

        // $this->searchTerm = Country::where('id',$this->supplier->country_id)->pluck('title');
        // $this->selectedCountryId = $this->supplier->country_id;
        // $country = Country::find($this->selectedCountryId);
        // if($country){
        //     $this->country_code = $country->country_code;
        //     $this->mobileLength = $country->mobile_length;
        // }

        $this->countries = Country::where('status',1)->get();
    }

    public function GetCountryDetails($mobileLength, $field){
        switch($field){
            case 'phone':
                $this->mobileLengthPhone  = $mobileLength;
                break;

            case 'whatsapp':
                $this->mobileLengthWhatsapp = $mobileLength;
                break;

            case 'alt_phone_1':
                $this->mobileLengthAlt1 = $mobileLength;
                break;
            
            case 'alt_phone_2':
                $this->mobileLengthAlt2 = $mobileLength;
                break;
            
                
        }
    }

    // public function FindCountry($term){
    //     $this->searchTerm = $term;
    //     if (!empty($this->searchTerm)) {
    //         $this->filteredCountries = Country::where('title', 'LIKE', '%' . $this->searchTerm . '%')->get();
    //     }else{
    //         $this->filteredCountries = [];
    //     }
    // }

    // public function selectCountry($countryId){
    //     $country = Country::find($countryId);
    //     if($country){
    //         $this->selectedCountryId = $country->id;
    //         $this->country_code = $country->country_code;
    //         $this->searchTerm = $country->title;
    //         $this->mobileLength = $country->mobile_length;
    //     }

    //     $this->filteredCountries = [];
    // }

 
    public function updateSupplier()
    {
        // dd($this->all());
        $this->validate([
            // 'searchTerm' => 'required',
            'prefix' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email,' . $this->supplier->id,
            'mobile' => [
                'required',
                'regex:/^\d{'. $this->mobileLengthPhone .'}$/',
            ],
            'whatsapp_no' => [
                'required',
                'regex:/^\d{'. $this->mobileLengthWhatsapp .'}$/',
            ],
            'alternative_phone_number_1' => [
                'nullable',
                'regex:/^\d{'. $this->mobileLengthAlt1 .'}$/',
            ],
            'alternative_phone_number_2' => [
                'nullable',
                'regex:/^\d{'. $this->mobileLengthAlt2 .'}$/',
            ],
            'billing_address' => 'required|string|max:255',
            'billing_landmark' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_pin' => 'nullable|string|max:10',
            'billing_country' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:255',
            'gst_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:1024',
            'credit_limit' => 'nullable|numeric',
            'credit_days' => 'nullable|numeric',
        ],[
            // 'searchTerm.required' => 'Please select a country.',
            'name.required' => 'Supplier name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Mobile number must be exactly ' . $this->mobileLengthPhone . ' digits.',
            'whatsapp_no.required' => 'WhatsApp number is required.',
            'whatsapp_no.regex' => 'WhatsApp number must be exactly ' . $this->mobileLengthWhatsapp . ' digits.',
            'alternative_phone_number_1.regex' => 'Alternative phone number 1 must be exactly ' . $this->mobileLengthAlt1 . ' digits.',
            'alternative_phone_number_2.regex' => 'Alternative phone number 2 must be exactly ' . $this->mobileLengthAlt2 . ' digits.',
            'billing_address.required' => 'Billing address is required.',
            'billing_state.required' => 'Billing state is required.',
            'billing_city.required' => 'Billing city is required.',
            'billing_country.required' => 'Billing country is required.',
            'gst_file.mimes' => 'GST file must be a PDF, JPEG, PNG, or JPG.',
            'gst_file.max' => 'GST file must not exceed 1MB.',
            'credit_limit.numeric' => 'Credit limit must be a number.',
            'credit_days.numeric' => 'Credit days must be a number.',
        ]);

        if ($this->gst_file) {
            $gstFilePath = $this->gst_file->store('gst_files','public');
            $absolutePath = 'storage/' . $gstFilePath;
        }

        $this->supplier->update([
            'prefix' => $this->prefix,
            'name' => $this->name,
            'email' => $this->email,
            'country_code_mobile' => $this->selectedCountryPhone,
            'mobile' => $this->mobile,
            'country_code_whatsapp' => $this->selectedCountryWhatsapp,
            'whatsapp_no' => $this->whatsapp_no,
            'billing_address' => $this->billing_address,
            'billing_landmark' => $this->billing_landmark,
            'billing_state' => $this->billing_state,
            'billing_city' => $this->billing_city,
            'billing_pin' => $this->billing_pin,
            'billing_country' => $this->billing_country,
            'gst_number' => $this->gst_number,
            'gst_file' => isset($absolutePath) ? $absolutePath :  $this->supplier->gst_file, // Use the new file path or the existing one
            'credit_limit' => $this->credit_limit,
            'credit_days' => $this->credit_days,
            'country_id' => $this->selectedCountryId,
            // 'country_code' => $this->country_code,
            'country_code_alt_1'  => $this->selectedCountryAlt1,
            'alternative_phone_number_1' => $this->alternative_phone_number_1,
            'country_code_alt_2'  => $this->selectedCountryAlt2,
            'alternative_phone_number_2' => $this->alternative_phone_number_2,

        ]);

        if ($this->isWhatsappPhone && $this->mobile) {
            UserWhatsapp::updateOrCreate(
                ['supplier_id' => $this->supplier->id, 'whatsapp_number' => $this->mobile],
                ['country_code' => $this->selectedCountryPhone, 'updated_at' => now()]
            ); 
        }else {
            UserWhatsapp::where('supplier_id', $this->supplier->id)->where('whatsapp_number', $this->mobile)->delete();
        }
        
        if ($this->isWhatsappAlt1 && $this->alternative_phone_number_1) {
            UserWhatsapp::updateOrCreate(
                ['supplier_id' =>  $this->supplier->id, 'whatsapp_number' => $this->alternative_phone_number_1],
                ['country_code' => $this->selectedCountryAlt1, 'updated_at' => now()]
            );
        }else {
            UserWhatsapp::where('supplier_id', $this->supplier->id)->where('whatsapp_number', $this->alternative_phone_number_1)->delete();
        }
    
        
        if ($this->isWhatsappAlt2 && $this->alternative_phone_number_1) {
            UserWhatsapp::updateOrCreate(
                ['supplier_id' =>  $this->supplier->id, 'whatsapp_number' => $this->alternative_phone_number_2],
                ['country_code' => $this->selectedCountryAlt2, 'updated_at' => now()]
            );
        }else {
            UserWhatsapp::where('supplier_id', $this->supplier->id)->where('whatsapp_number', $this->alternative_phone_number_2)->delete();
        }
    

        session()->flash('success', 'Supplier updated successfully!');
        return redirect()->route('suppliers.index');
    }

    // public function SameAsMobile(){
    //     if($this->is_wa_same == 0){
    //         $this->whatsapp_no = $this->mobile;
    //         $this->is_wa_same = 1;
    //     }else{
    //         $this->whatsapp_no = '';
    //         $this->is_wa_same = 0;
    //     }
    // }

    public function render()
    {
        return view('livewire.supplier.supplier-edit');
    }
}
