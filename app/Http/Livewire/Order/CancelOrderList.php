<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\Invoice;

class CancelOrderList extends Component
{
    use WithPagination;
    
    public $customer_id;
    public $created_by, $search,$status,$start_date,$end_date; 
    public $invoiceId;
    public $orderId;


    protected $paginationTheme = 'bootstrap'; // Optional: For Bootstrap styling
    
   
    public function render()
    {
        $this->usersWithOrders = User::whereHas('orders')->get();
        $orders = Order::query()
        ->where('status', 'Cancelled')
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
    

        return view('livewire.order.cancel-order-list', [
            'orders' => $orders,
            'usersWithOrders' => $this->usersWithOrders, 
        ]);
    }
   
}
