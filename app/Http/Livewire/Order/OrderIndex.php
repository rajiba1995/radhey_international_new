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

use Illuminate\Support\Facades\Auth;
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
    public $auth;
    
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
        $orders = Order::query()
        // ->where('status', '!=' , 'Cancelled') // Uncomment if needed
        ->when($this->customer_id, fn($query) => $query->where('customer_id', $this->customer_id)) // Filter by customer ID
        ->when($this->search, function ($query) {
            $query->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function ($q) {
                      $q->where(function ($subQuery) {
                          $subQuery->where('name', 'like', '%' . $this->search . '%')
                                   ->orWhere('email', 'like', '%' . $this->search . '%')
                                   ->orWhere('phone', 'like', '%' . $this->search . '%')
                                   ->orWhere('whatsapp_no', 'like', '%' . $this->search . '%'); 
                      });
                  });
        })
        ->when($this->created_by, fn($query) => $query->where('created_by', $this->created_by)) // Filter by creator
        ->when($this->start_date, fn($query) => $query->whereDate('created_at', '>=', $this->start_date)) // Start date filter
        ->when($this->end_date, fn($query) => $query->whereDate('created_at', '<=', $this->end_date)) // End date filter
        ->when(!$auth->is_super_admin, fn($query) => $query->where('created_by', $auth->id)) // Restrict non-admins
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('livewire.order.order-index', [
            'placed_by' => $placed_by,
            'orders' => $orders,
            'usersWithOrders' => $this->usersWithOrders, 
        ]);
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
        }, 'bill_' . $invoice->order->order_number . '.pdf');
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
