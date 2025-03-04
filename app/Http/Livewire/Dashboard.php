<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Order;
use App\Models\Invoice;

class Dashboard extends Component
{
    public $total_suppliers = 0;
    public $total_customers = 0;
    public $total_orders = 0;
    public $total_invoice = 0;
    public function mount(){
        $this->total_suppliers = Supplier::count();
        $this->total_customers = User::where('user_type',1)->count();
        $this->total_orders = Order::count();
        $this->total_invoice = Invoice::count();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
