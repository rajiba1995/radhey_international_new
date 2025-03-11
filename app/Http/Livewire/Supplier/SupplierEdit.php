<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Supplier;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplierEdit extends Component
{
    use WithFileUploads;

    public $prefix, $supplier, $name, $email, $mobile, $is_wa_same, $whatsapp_no;
    public $billing_address, $billing_landmark, $billing_state, $billing_city, $billing_pin, $billing_country;
    public $gst_number, $gst_file, $credit_limit, $credit_days;
    public $mobileLength;
    public $filteredCountries = [];
    public $searchTerm;
    public $existingGstFile;
    public $country_code;
    public $selectedCountryId;
    public $alternative_phone_number_1;
    public $alternative_phone_number_2;


    public function mount($id)
    {
        $this->supplier = Supplier::find($id);
        $this->prefix = $this->supplier->prefix;
        $this->name = $this->supplier->name;
        $this->email = $this->supplier->email;
        $this->mobile = $this->supplier->mobile;
        $this->is_wa_same = ($this->supplier->mobile == $this->supplier->whatsapp_no) ? 1 : 0;
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
        $this->searchTerm = Country::where('id',$this->supplier->country_id)->pluck('title');
        $this->selectedCountryId = $this->supplier->country_id;
        $country = Country::find($this->selectedCountryId);
        if($country){
            $this->country_code = $country->country_code;
            $this->mobileLength = $country->mobile_length;
        }
    }

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
            $this->country_code = $country->country_code;
            $this->searchTerm = $country->title;
            $this->mobileLength = $country->mobile_length;
        }

        $this->filteredCountries = [];
    }

 
    public function updateSupplier()
    {
        // dd($this->all());
        $this->validate([
            'searchTerm' => 'required',
            'prefix' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $this->supplier->id,
            'mobile' => [
                'required',
                'regex:/^\d{'. $this->mobileLength .'}$/',
            ],
            'whatsapp_no' => [
                'required',
                'regex:/^\d{'. $this->mobileLength .'}$/',
            ],
            'alternative_phone_number_1' => [
                'nullable',
                'regex:/^\d{'. $this->mobileLength .'}$/',
            ],
            'alternative_phone_number_2' => [
                'nullable',
                'regex:/^\d{'. $this->mobileLength .'}$/',
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
            'searchTerm.required' => 'Please select a country.',
            'name.required' => 'Supplier name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Mobile number must be exactly ' . $this->mobileLength . ' digits.',
            'whatsapp_no.required' => 'WhatsApp number is required.',
            'whatsapp_no.regex' => 'WhatsApp number must be exactly ' . $this->mobileLength . ' digits.',
            'alternative_phone_number_1.regex' => 'Alternative phone number 1 must be exactly ' . $this->mobileLength . ' digits.',
            'alternative_phone_number_2.regex' => 'Alternative phone number 2 must be exactly ' . $this->mobileLength . ' digits.',
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
            'mobile' => $this->mobile,
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
            'country_code' => $this->country_code,
            'alternative_phone_number_1' => $this->alternative_phone_number_1,
            'alternative_phone_number_2' => $this->alternative_phone_number_2,

        ]);

        session()->flash('success', 'Supplier updated successfully!');
        return redirect()->route('suppliers.index');
    }

    public function SameAsMobile(){
        if($this->is_wa_same == 0){
            $this->whatsapp_no = $this->mobile;
            $this->is_wa_same = 1;
        }else{
            $this->whatsapp_no = '';
            $this->is_wa_same = 0;
        }
    }

    public function render()
    {
        return view('livewire.supplier.supplier-edit');
    }
}
