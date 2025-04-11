<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Models\ManualInvoice;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap'; // Optional: For Bootstrap styling
    public $search ="";
    public $created_by;
    public $activeTab = "normal";

    public function setActiveTab($tab){
        $this->activeTab = $tab;
    }

    public function FindCustomer($keywords){
        $this->search = $keywords;
    }

    public function downloadOrderInvoice($orderId)
    {
        $invoice = Invoice::with(['order', 'customer', 'user', 'packing'])
                    ->where('order_id', $orderId)
                    ->firstOrFail();
    
        // Generate PDF
        $pdf = PDF::loadView('invoice.order_pdf', compact('invoice'));
    
        // Download the PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice_' . $invoice->invoice_no . '.pdf');
    } 

    public function downloadManualInvoice($manualInvoiceId){
        $manualInvoice = ManualInvoice::with('items')->findOrFail($manualInvoiceId);

         // Generate PDF
         $pdf = PDF::loadView('invoice.manual_invoice_pdf', compact('manualInvoice'));
         
          // Download the PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice_' . $manualInvoice->invoice_no . '.pdf');
    }
    

    public function CollectedBy($value){
        $this->created_by = $value;
    }

    public function resetForm(){
        $this->reset(['search','created_by']);
    }

    public function render()
    {
        $placed_by = User::where('user_type', 0)->get();
        $auth = Auth::guard('admin')->user();

        if($auth->is_super_admin){
            $wonOrders = order::get()->pluck('created_by')->toArray();
        }else{
            // Fetch orders
            $wonOrders = $auth->orders(); // Start the query
            // dd($wonOrders);
            // If the user is not a super admin, filter by `created_by`
            if (!$auth->is_super_admin) {
                $wonOrders->where('created_by', $auth->id);
            }
            // Execute the query
            $wonOrders = $wonOrders->get()->pluck('created_by')->toArray();
        }
        
       
        $this->usersWithOrders = $wonOrders;

        // Always define both variables
        $invoices = collect();
        $manualInvoices = collect();

      
            // Fetch invoices with filters
            $invoices = Invoice::query()
            ->when($this->search, function ($query) {
                $query->where('invoice_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('order', function ($q) {
                        $q->where('order_number', 'like', '%' . $this->search . '%')
                            ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                            ->orWhere('customer_name', 'like', '%' . $this->search . '%');
                    });
            })
    
            ->when($this->created_by, fn($query) => $query->where('created_by', $this->created_by))
            ->when(!$auth->is_super_admin, fn($query) => $query->where('created_by', $auth->id)) // Restrict non-admins
            ->orderBy('created_at', 'desc')
            ->paginate(20);
       
            $manualInvoices = ManualInvoice::query()
            ->when($this->search, function ($query) {
                $query->where('invoice_no', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('reference', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        


        return view('livewire.order.invoice-list', [
            'invoices' => $invoices,
            'manualInvoices' => $manualInvoices,
            'placed_by' => $placed_by,
            'usersWithOrders' => $this->usersWithOrders,
        ]);
    }
}
