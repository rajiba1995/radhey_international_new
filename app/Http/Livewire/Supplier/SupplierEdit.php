<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplierEdit extends Component
{
    use WithFileUploads;

    public $supplier, $name, $email, $mobile, $is_wa_same, $whatsapp_no;
    public $billing_address, $billing_landmark, $billing_state, $billing_city, $billing_pin, $billing_country;
    public $gst_number, $gst_file, $credit_limit, $credit_days;

    public $existingGstFile;

    public function mount($id)
    {
        $this->supplier = Supplier::find($id);
        $this->name = $this->supplier->name;
        $this->email = $this->supplier->email;
        $this->mobile = $this->supplier->mobile;
        $this->is_wa_same = $this->supplier->is_wa_same;
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
    }

 
    public function updateSupplier()
    {
        // dd($this->all());
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $this->supplier->id,
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
            'billing_state' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_pin' => 'nullable|string|max:10',
            'billing_country' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:255',
            'gst_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:1024',
            'credit_limit' => 'nullable|numeric',
            'credit_days' => 'nullable|numeric',
        ]);

        if ($this->gst_file) {
            $gstFilePath = $this->gst_file->store('gst_files','public');
            $absolutePath = 'storage/' . $gstFilePath;
        }

        $this->supplier->update([
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
