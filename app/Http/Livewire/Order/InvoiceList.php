<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\User;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap'; // Optional: For Bootstrap styling
    public $search ="";
    public $created_by;

    public function downloadInvoice($orderId)
    {
        $invoice = Invoice::with(['order', 'customer', 'user', 'packing'])
                    ->where('order_id', $orderId)
                    ->firstOrFail();
    
        // Generate PDF
        $pdf = PDF::loadView('invoice.pdf', compact('invoice'));
    
        // Download the PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice_' . $invoice->invoice_no . '.pdf');
    } 

    public function render()
    {
        $this->usersWithOrders = User::whereHas('orders')->get();
        $invoices = Invoice::query()
        ->when($this->search, function ($query) {
            $query->where('invoice_no', 'like', '%' . $this->search . '%')
                  ->orWhereHas('order', function ($q) {
                      $q->where('order_number', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_name', 'like', '%' . $this->search . '%');
                  });
        })
        ->when($this->created_by, function ($query) {
            $query->where('created_by', $this->created_by);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(20);
    
        return view('livewire.order.invoice-list', [
            'invoices' => $invoices,
            'usersWithOrders' => $this->usersWithOrders, 
        ]);
    }
}
