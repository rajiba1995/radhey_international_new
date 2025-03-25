<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Helpers\Helper;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use App\Models\Invoice;
// use Barryvdh\DomPDF\Facade as PDF;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf;



class OrderIndex extends Component
{
    use WithPagination;
    
    public $customer_id;
    public $created_by, $search,$status,$start_date,$end_date; 
    public $invoiceId;
    public $orderId;
    public $totalPrice;
    
    // protected $listeners = ['cancelOrder'];
    protected $listeners = ['cancelOrder'];

    protected $paginationTheme = 'bootstrap'; // Optional: For Bootstrap styling
    
    public function resetForm(){
        $this->reset(['search', 'start_date','end_date','created_by']);
    }
    public function mount($customer_id = null)
    {
        $this->customer_id = $customer_id; // Store the customer_id if provided
    }
    public function FindCustomer($keywords){
        $this->search = $keywords;
    }
    public function AddStartDate($date){
        $this->start_date = $date;
    }
    public function AddEndDate($date){
        $this->end_date = $date;
    }
    public function CollectedBy($staff_id){
        $this->created_by = $staff_id;
    }
    
    public function export()
    {
        return Excel::download(new OrdersExport(
            $this->customer_id,
            $this->created_by,
            $this->start_date,
            $this->end_date,
            $this->search
        ), 'orders.csv');
    }

    // public function updateStatus($status, $id)
    // {
    //     $order = Order::find($id); // Fetch the order by ID
        
    //     if ($order) {
    //         $order->update(['status' => $status]);
    //         session()->flash('success', 'Order status updated successfully.');
    //     } else {
    //         session()->flash('error', 'Order not found.');
    //     }
    // }

    
    public function render()
    {
        // Fetch users for the dropdown
        // $users = User::all();
        $this->usersWithOrders = User::whereHas('orders')->get();
        $orders = Order::query()
        // ->where('status', '!=' , 'Cancelled')
        ->when($this->customer_id, function ($query) { // If customer_id is set, filter orders
            $query->where('customer_id', $this->customer_id);
        })
        ->when($this->search, function ($query) {
            $query->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                  });
        })
        ->when($this->created_by, function ($query) {
            $query->where('created_by', $this->created_by);
        })
        ->when($this->start_date, function ($query) {
            $query->whereDate('created_at', '>=', $this->start_date);
        })
        ->when($this->end_date, function ($query) {
            $query->whereDate('created_at', '<=', $this->end_date);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('livewire.order.order-index', [
            'orders' => $orders,
            'usersWithOrders' => $this->usersWithOrders, 
        ]);
    }

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
    public function downloadOrderInvoice($orderId)
    {
        $invoice = Invoice::with(['order', 'customer', 'user', 'packing'])
                    ->where('order_id', $orderId)
                    ->firstOrFail();
        // dd($invoice);
        // Generate PDF
        $pdf = PDF::loadView('invoice.order_pdf', compact('invoice'));
    
        // Download the PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice_' . $invoice->invoice_no . '.pdf');
    }   
    public function downloadOrderBill($orderId)
    {
        $invoice = Invoice::with(['order', 'customer', 'user', 'packing'])
                    ->where('order_id', $orderId)
                    ->firstOrFail();
        // dd($invoice);
        // Generate PDF
        $pdf = PDF::loadView('invoice.bill_pdf', compact('invoice'));
    
        // Download the PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice_' . $invoice->invoice_no . '.pdf');
    }  

    // Cancelled Orders
    // public function confirmCancelOrder($id = null)
    // {
    //     // dd($orderId);
    //     if (!$id) {
    //         throw new \Exception("Order ID is missing in confirmCancelOrder.");
    //     }
    
    //     $this->dispatch('confirmCancel', ['orderId' => $id]);
    // }
    

    // public function cancelOrder($orderId = null)
    // {
    //     if (!$orderId) {
    //         throw new \Exception("Order ID is required but received null.");
    //     }
        
    //     dd("Order ID: " . $orderId);
    // }

    public function confirmCancelOrder($id = null)
    {
        if (!$id) {
            throw new \Exception("Order ID is missing in confirmCancelOrder.");
        }

        $this->dispatch('confirmCancel', orderId: $id);
    }

    public function cancelOrder($orderId = null)
    {
        \Log::info("cancelOrder method triggered with Order ID: " . ($orderId ?? 'NULL'));

        if (!$orderId) {
            throw new \Exception("Order ID is required but received null.");
        }

        // Perform order cancellation logic here
         Order::where('id', $orderId)->update(['status' => 'Cancelled']);

        session()->flash('message', 'Order has been cancelled successfully.');
    }

} 
