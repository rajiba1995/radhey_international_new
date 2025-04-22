<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\ProformaInvoice;
use Barryvdh\DomPDF\Facade\Pdf;


class ProformaIndex extends Component
{
    public $invoices = [];

    public function mount(){
        $this->invoices = ProformaInvoice::with('customer')->get();
    }

    public function downloadProformaInvoice($proformaId)
    {
        $proforma = ProformaInvoice::with('customer', 'items.product')->findOrFail($proformaId);

          // Generate PDF
            $pdf = PDF::loadView('invoice.proforma_invoice_pdf', compact('proforma'));
        
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, 'proforma_' . $proforma->proforma_number . '.pdf');
      
    }
    
    public function render()
    {
        return view('livewire.order.proforma-index');
    }
}
