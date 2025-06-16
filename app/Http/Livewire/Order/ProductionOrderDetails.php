<?php

namespace App\Http\Livewire\Order;
use App\Models\Order;
use \App\Models\Product;
use \App\Models\Invoice;
use Livewire\Component;

class ProductionOrderDetails extends Component
{
     public $oderId;
    public $latestOrders = [];
    public $order;

    public function mount($id){
        $this->orderId = $id;
        $this->order = Order::with('items')->findOrFail($this->orderId);
        // dd($this->order);
        $invoicePayment = Invoice::where('order_id', $this->order->id)->orderBy('id','desc')->first(); 
        if($invoicePayment){
            $this->order->total_amount = $invoicePayment->net_price;
            $this->order->paid_amount = $invoicePayment->net_price - $invoicePayment->required_payment_amount;
            $this->order->remaining_amount = $invoicePayment->required_payment_amount;
        }
         // Fetch the latest 5 orders for the user (customer)
         $this->latestOrders = Order::where('customer_id',$this->order->customer_id)
                                     ->latest()
                                     ->where('id', '!=', $this->order->id)
                                     ->take(5)
                                     ->get();
    }

    public function render()
    {
         // Fetch the order and its related items
         $order = Order::with('items')->findOrFail($this->orderId);
         // Fetch product details for each order item
         $orderItems = $order->items->map(function ($item) use($order) {
            $product = Product::find($item->product_id);
            return [
                'product_name' => $item->product_name ?? $product->name,
                'collection_id' => $item->collection,
                'collection_title' => $item->collectionType ?  $item->collectionType->title : "",
                'fabrics' => $item->fabric,
                'measurements' => $item->measurements,
                'catalogue' => $item->catalogue_id?$item->catalogue:"",
                'catalogue_id' => $item->catalogue_id,
                'cat_page_number' => $item->cat_page_number,
                'price' => $item->piece_price,
                'quantity' => $item->quantity,
                'product_image' => $product ? $product->product_image : null,
            ];
        });
        return view('livewire.order.production-order-details',[
             'order' => $order,
            'orderItems' => $orderItems,
            'latestOrders'=>$this->latestOrders
        ]);
    }
}
