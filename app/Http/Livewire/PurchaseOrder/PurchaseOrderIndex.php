<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderIndex extends Component
{
    public $purchaseOrders = '';
    public $search = '';
    protected $paginationTheme = 'bootstrap'; // Optional: For Bootstrap styling
    public function mount(){
        
    }
    public function FindCustomer($keywords){
        $this->search = $keywords;
    }

    public function resetForm(){
        $this->reset(['search']);
    }
    
    public function render()
    {
        $query = PurchaseOrder::with(['orderproducts.product', 'orderproducts.fabric', 'orderproducts.collection'])
        ->when(!empty($this->search), function ($query) {
            $query->where('unique_id', 'like', '%' . $this->search . '%')
                ->orWhereHas('supplier', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('mobile', 'like', '%' . $this->search . '%');
                });
        })
        ->orderBy('id','DESC')
        ->paginate(20);

        return view('livewire.purchase-order.purchase-order-index', [
            'data' => $query,
        ]);
    }
    
}
