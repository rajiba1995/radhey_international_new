<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Supplier;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplierAdd extends Component
{
    use WithFileUploads;

    public $prefix, $name, $email, $mobile, $is_wa_same, $whatsapp_no ,$alternative_phone_number_1, $alternative_phone_number_2;
    public $billing_address, $billing_landmark, $billing_state, $billing_city, $billing_pin, $billing_country;
    public $gst_number, $gst_file, $credit_limit, $credit_days;
    public $searchTerm;
    protected $rules=[];
    public $filteredCountries = [];
    public $selectedCountryId;
    public $country_code;
    public $mobileLength;

    public function mount(){
        $this->selectedCountryId = null;
        $this->country_code = '';
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
            $this->searchTerm  = $country->title;
            $this->country_code = $country->country_code;
            $this->mobileLength = $country->mobile_length;
        }

        $this->filteredCountries = [];
        
    }

   public function rules(){
     return [
            'searchTerm' => 'required',
            'prefix' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
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
            'billing_state' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_pin' => 'nullable|string|max:10',
            'billing_country' => 'required|string|max:255',
            'gst_number' => 'nullable|string|max:255',
            'gst_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:1024',
            'credit_limit' => 'nullable|numeric',
            'credit_days' => 'nullable|numeric',
        ];    
   }
      
   public function messages()
    {
        return [
            'searchTerm.required' => 'Please select a country.',
            'name.required' => 'Supplier name is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already taken.',
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
        ];
    }
   
    public function save()
    {   
        // dd($this->all());
        $this->validate();

        if ($this->gst_file) {
            $gstFilePath = $this->gst_file->store('gst_files','public');
             $absoluteAssetPath = 'storage/' . $gstFilePath;
        }

        Supplier::create([
            'prefix' => $this->prefix,
            'name' => $this->name,
            'email' => $this->email,
            'country_id'=> $this->selectedCountryId,
            'country_code'=> $this->country_code,
            'alternative_phone_number_1' => $this->alternative_phone_number_1,
            'alternative_phone_number_2' => $this->alternative_phone_number_2,
            'mobile' => $this->mobile,
            'whatsapp_no' => $this->whatsapp_no,
            'billing_address' => $this->billing_address,
            'billing_landmark' => $this->billing_landmark,
            'billing_state' => $this->billing_state,
            'billing_city' => $this->billing_city,
            'billing_pin' => $this->billing_pin,
            'billing_country' => $this->billing_country,
            'gst_number' => $this->gst_number,
            'gst_file' => isset($absoluteAssetPath) ? $absoluteAssetPath : null, 
            'credit_limit' => $this->credit_limit,
            'credit_days' => $this->credit_days,
        ]);

        session()->flash('success', 'Supplier added successfully!');
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
        return view('livewire.supplier.supplier-add');
    }
}
