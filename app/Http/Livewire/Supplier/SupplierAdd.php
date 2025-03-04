<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplierAdd extends Component
{
    use WithFileUploads;

    public $name, $email, $mobile, $is_wa_same, $whatsapp_no;
    public $billing_address, $billing_landmark, $billing_state, $billing_city, $billing_pin, $billing_country;
    public $gst_number, $gst_file, $credit_limit, $credit_days;
    protected $rules=[];

   public function rules(){
     return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
            'mobile' => [
                'required',
                'regex:/^\+?\d{' . env('VALIDATE_MOBILE', 8) . ',}$/',
            ],
            'whatsapp_no' => [
                'required',
                'regex:/^\+?\d{' . env('VALIDATE_WHATSAPP', 8) . ',}$/',
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
      
   
   
    public function save()
    {   
        // dd($this->all());
        $this->validate();

        if ($this->gst_file) {
            $gstFilePath = $this->gst_file->store('gst_files','public');
             $absoluteAssetPath = 'storage/' . $gstFilePath;
        }

        Supplier::create([
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
