<?php

namespace App\Http\Livewire\Order;
use App\Models\Order;
use App\Models\OrderItem;

use \App\Models\Product;
use \App\Models\Invoice;
use App\Models\Delivery;

use Livewire\Component;

class OrderView extends Component
{
    public $oderId;
    public $latestOrders = [];
    public $order;
    protected $listeners = ['deliveredToCustomerPartial'];

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
         $order = Order::with([
            'items.deliveries' => fn($q) => $q->with('user:id,name')
        ])->findOrFail($this->orderId);
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
                'deliveries' => !empty($item->deliveries)?$item->deliveries:"",
                'quantity' => $item->quantity,
                'product_image' => $product ? $product->product_image : null,
            ];
        });
        return view('livewire.order.order-view',[
            'order' => $order,
            'orderItems' => $orderItems,
            'latestOrders'=>$this->latestOrders
        ]);
    }
    public function deliveredToCustomerPartial($Id = null,$orderId=null)
    {
        \Log::info("Mark As Customer Delivered Method method triggered with Order ID: " . ($Id ?? 'NULL'));

        if (!$Id) {
            throw new \Exception("Order ID is required but received null.");
        }
        $totalQuantity = OrderItem::where('order_id', $orderId)->sum('quantity');

        // Perform order cancellation logic here
         Delivery::where('id', $Id)->update( ['status' => 'Delivered to Customer']);

        $totalDelevery= Delivery::where('order_id', $orderId)->where('status','Delivered to Customer')->sum('delivered_quantity');

        if($totalQuantity==$totalDelevery)
        {
           Order::where('id', operator: $orderId)->update(['status' => 'Delivered to Customer']);

        }
        else{
            Order::where('id', operator: $orderId)->update(['status' => 'Delivered to Customer']);

        }

        //session()->flash('message', 'Order has been Delivered to Customer successfully.');
        //return redirect()->route('admin.order.index'); // or redirect()->to('/some-url');
        return redirect(url()->previous())->with('success', 'Order has been Delivered to Customer successfully!');
    }
}
