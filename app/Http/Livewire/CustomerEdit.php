<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Country;
use App\Models\UserAddress;
use Livewire\WithFileUploads;

class CustomerEdit extends Component
{
    use WithFileUploads;

    public $id, $name,$dob, $company_name, $employee_rank,$email, $phone, $whatsapp_no, $is_wa_same, $gst_number, $credit_limit, $credit_days, $gst_certificate_image, $image, $verified_video ,$alternative_phone_number_1, $alternative_phone_number_2;
    public $billing_address, $billing_landmark, $billing_city, $billing_state, $billing_country, $billing_pin;
    public $shipping_address, $shipping_landmark, $shipping_city, $shipping_state, $shipping_country, $shipping_pin;
    public $is_billing_shipping_same;
    public $tempImageUrl;
    public $filteredCountries = [];
    public $mobileLength;
    public $country_id;
    public $searchTerm;
    public $country_code;

    public function mount($id)
    {
        if ($id) {
            $user = User::find($id);

            $this->fillUserData($user);

            $billingAddress = $user->address()->where('address_type', 1)->first();
            $shippingAddress = $user->address()->where('address_type', 2)->first();

            $this->fillAddressData($billingAddress, $shippingAddress);
            $this->alternative_phone_number_1 = $user->alternative_phone_number_1;
            $this->alternative_phone_number_2 = $user->alternative_phone_number_2;
            // $this->searchTerm = Country::find($user->country_id)?->title ?? '';
            if($user->country_id){
                $country = Country::find($user->country_id);
                if ($country) {
                    $this->country_id = $country->id;
                    $this->country_code = $country->country_code;
                    $this->mobileLength = $country->mobile_length;
                    $this->searchTerm = $country->title; 
                }
            }
        }
    }

    public function FindCustomer($term){
        $this->searchTerm = $term;
        if(!empty($this->searchTerm)){
            $this->filteredCountries = Country::where('title' , 'LIKE' , '%' . $this->searchTerm . '%')->get();
        }else{
            $this->filteredCountries = [];
        }
    }

    public function selectCountry($countryId){
        $country = Country::find($countryId);
        if($country){
            $this->country_id = $country->id;
            $this->country_code = $country->country_code;
            $this->searchTerm = $country->title;
            $this->mobileLength = $country->mobile_length;
            $this->filteredCountries = [];  
        }
    }

    public function toggleShippingAddress()
    {
        if (!$this->is_billing_shipping_same) {
             // Reset shipping fields if the checkbox is unchecked
             $this->resetShippingFields();
        } else {
             // Populate shipping fields with billing address data when checked
            $this->shipping_address = $this->billing_address;
            $this->shipping_landmark = $this->billing_landmark;
            $this->shipping_city = $this->billing_city;
            $this->shipping_state = $this->billing_state;
            $this->shipping_country = $this->billing_country;
            $this->shipping_pin = $this->billing_pin;
        }
    }

    private function resetShippingFields()
    {
         // Reset shipping address fields to make them empty and editable when checkbox is unchecked
        $this->shipping_address = '';
        $this->shipping_landmark = '';
        $this->shipping_city = '';
        $this->shipping_state = '';
        $this->shipping_country = '';
        $this->shipping_pin = '';
    }


    

    private function fillUserData($user)
    {
        $this->name = $user->name ?? "";
        $this->company_name = $user->company_name ?? "";
        $this->employee_rank = $user->employee_rank ?? "";
        $this->email = $user->email ?? "";
        $this->dob   = $user->dob ?? "";  
        $this->phone = $user->phone ?? "";
        $this->whatsapp_no = $user->whatsapp_no ?? "";
        $this->is_wa_same =  ($this->phone =  $this->whatsapp_no) ? 1 : 0;
        $this->gst_number = $user->gst_number ?? "";
        $this->credit_limit = $user->credit_limit ?? "";
        $this->credit_days = $user->credit_days ?? "";
        $this->image = $user->profile_image ? asset( $user->profile_image) : "";
        $this->verified_video = $user->verified_video ? asset( $user->verified_video) : "";
        $this->gst_certificate_image = $user->gst_certificate_image ? asset( $user->gst_certificate_image) : "";
      
        
    }

    private function fillAddressData($billingAddress, $shippingAddress)
    {
        if ($billingAddress) {
            $this->billing_address = $billingAddress->address;
            $this->billing_landmark = $billingAddress->landmark;
            $this->billing_city = $billingAddress->city;
            $this->billing_state = $billingAddress->state;
            $this->billing_country = $billingAddress->country;
            $this->billing_pin = $billingAddress->zip_code;
        }

        if ($shippingAddress) {
            $this->shipping_address = $shippingAddress->address;
            $this->shipping_landmark = $shippingAddress->landmark;
            $this->shipping_city = $shippingAddress->city;
            $this->shipping_state = $shippingAddress->state;
            $this->shipping_country = $shippingAddress->country;
            $this->shipping_pin = $shippingAddress->zip_code;
        }

        $this->is_billing_shipping_same = $billingAddress && $shippingAddress && ($billingAddress->address == $shippingAddress->address);
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'employee_rank'=>'nullable|string',
            'image' => $this->image instanceof \Illuminate\Http\UploadedFile ? 'nullable|mimes:jpg,jpeg,png,gif' : 'nullable',
            'verified_video' => $this->verified_video instanceof \Illuminate\Http\UploadedFile ? 'nullable|mimes:mp4,mov,avi,wmv' : 'nullable',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->id,
            'dob'=> 'required|date',
            'phone' => [
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
            'gst_number' => 'nullable|string|max:15',
            'credit_limit' => 'nullable|numeric|min:0',
            'credit_days' => 'nullable|integer|min:0',
            'billing_address' => 'required|string',
            'billing_landmark' => 'nullable|string',
            'billing_city' => 'required|string',
            'billing_state' => 'nullable|string',
            'billing_country' => 'required|string',
            'billing_pin' => 'nullable|string',
        ];

        if (!$this->is_billing_shipping_same) {
            $rules = array_merge($rules, [
                'shipping_address' => 'required|string',
                'shipping_landmark' => 'nullable|string',
                'shipping_city' => 'required|string',
                'shipping_state' => 'nullable|string',
                'shipping_country' => 'required|string',
                'shipping_pin' => 'nullable|string',
            ]);
        }

        return $rules;
    }

    public function update()
    {
        // dd($this->all());
         // Prepare data for dd and avoid showing existing image/verified_video
        $dataToLog = $this->all();

        // Check if 'image' exists already and unset it from the log data
        if (isset($this->image) && !empty($this->image)) {
            // Don't log image data if it already exists
            unset($dataToLog['image']);
        }

        // Check if 'verified_video' exists already and unset it from the log data
        if (isset($this->verified_video) && !empty($this->verified_video)) {
            // Don't log verified_video data if it already exists
            unset($dataToLog['verified_video']);
        }

        // Log data without the image and verified_video if they exist
        // dd($dataToLog);
        $this->validate();
      
        $user = User::find($this->id);
        $user->fill($this->prepareUserData());
        
        // Handle image upload only if a new image is provided
        if ($this->image && $this->image instanceof \Illuminate\Http\UploadedFile) {
            $user->profile_image = $this->uploadImage();
        }

        // Handle video upload only if a new video is provided
        if ($this->verified_video && $this->verified_video instanceof \Illuminate\Http\UploadedFile) {
            $user->verified_video = $this->uploadVideo();
        }

        // Handle GST certificate upload only if a new certificate is provided
        if ($this->gst_certificate_image && $this->gst_certificate_image instanceof \Illuminate\Http\UploadedFile) {
            $user->gst_certificate_image = $this->uploadGSTCertificate();
        }

        $user->save();

        $this->storeAddress($user->id, 1, $this->billing_address, $this->billing_landmark, $this->billing_city, $this->billing_state, $this->billing_country, $this->billing_pin);

        $this->storeAddress(
            $user->id,
            2,
            $this->is_billing_shipping_same ? $this->billing_address : $this->shipping_address,
            $this->is_billing_shipping_same ? $this->billing_landmark : $this->shipping_landmark,
            $this->is_billing_shipping_same ? $this->billing_city : $this->shipping_city,
            $this->is_billing_shipping_same ? $this->billing_state : $this->shipping_state,
            $this->is_billing_shipping_same ? $this->billing_country : $this->shipping_country,
            $this->is_billing_shipping_same ? $this->billing_pin : $this->shipping_pin
        );

        session()->flash('success', 'Customer information updated successfully!');
        return redirect()->route('customers.index');
    }

    private function prepareUserData()
    {
        return [
            'name' => $this->name,
            'company_name' => $this->company_name,
            'employee_rank' => $this->employee_rank,
            'email' => $this->email,
            'dob'=>$this->dob,
            'phone' => $this->phone,
            'whatsapp_no' => $this->whatsapp_no,
            'gst_number' => $this->gst_number,
            'credit_limit' => $this->credit_limit === '' ? 0 : $this->credit_limit,
            'credit_days' => $this->credit_days === '' ? 0 : $this->credit_days,
        ];
    }

    private function storeAddress($userId, $addressType, $address, $landmark, $city, $state, $country, $zipCode)
    {
        UserAddress::updateOrCreate(
            ['user_id' => $userId, 'address_type' => $addressType],
            ['address' => $address, 'landmark' => $landmark, 'city' => $city, 'state' => $state, 'country' => $country, 'zip_code' => $zipCode]
        );
    }

    private function uploadImage()
    {
        return $this->handleFileUpload($this->image, 'profile_image');
    }

    private function uploadVideo()
    {
        return $this->handleFileUpload($this->verified_video, 'verified_video');
    }

    private function uploadGSTCertificate()
    {
        return $this->handleFileUpload($this->gst_certificate_image, 'gst_certificate_image');
    }

    private function handleFileUpload($file, $folder)
    {
        if ($file && $file instanceof \Illuminate\Http\UploadedFile) {
            $timestamp = now()->timestamp;
            $fileName = $timestamp . '.' . $file->getClientOriginalExtension();
            $storedPath = $file->storeAs($folder, $fileName, 'public');
            return "storage/".$storedPath;
        }
        return null;
    }

    public function SameAsMobile()
    {
        if ($this->is_wa_same == 0) {
            $this->whatsapp_no = $this->phone;
            $this->is_wa_same = 1;
        } else {
            $this->whatsapp_no = '';
            $this->is_wa_same = 0;
        }
    }

    public function render()
    {
        return view('livewire.customer-edit');
    }
}
