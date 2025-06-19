<?php

namespace App\Http\Livewire\Order;
use App\Models\Order;
use \App\Models\Product;
use \App\Models\Invoice;
use \App\Models\StockFabric;
use \App\Models\StockProduct;
use \App\Models\OrderStockEntry;
use \App\Models\ChangeLog;
use Livewire\Component;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductionOrderDetails extends Component
{
    public $showModal = false;
    public $selectedItem = [];
    public $orderItems = [];
    public $rows = [];
    public $orderId;
    public $latestOrders = [];
    public $order;
    public $available_meter;

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

    public function checkQuantity($index,$inputName, $available)
    {
        // Find the item
       
        $entered = $this->rows[$inputName] ?? 0;

        if ($entered > $available) {
            $this->rows['is_valid_'.$inputName] = false;
        } else {
            $this->rows['is_valid_'.$inputName] = true;
        }
    }

    public function updateStock($index,$inputName){
       try {
           DB::beginTransaction();
        $item = $this->orderItems[$index];
        $orderItemId = $item['id'];
        $enteredQuantity = $this->rows[$inputName] ?? 0;

        $validator = Validator::make(
            [$inputName => $enteredQuantity],
            [
                $inputName => [
                    'required',
                    'numeric',
                    'min:1',
                    'max:'.$item['stock_entry_data']['available_value'],
                ],
            ],
            [
                $inputName.'.required' => 'Quantity is required.',
                $inputName.'.numeric' => 'Quantity must be numeric.',
                $inputName.'.min' => 'Quantity must be at least 1.',
                $inputName.'.max' => 'Quantity must be less than or equal to available.',
            ]
        );

        if ($validator->fails()) {
            //  Mark invalid for red border + feedback
            $this->rows['is_valid_'.$inputName] = false;
            $this->addError($inputName, $validator->errors()->first($inputName));
            DB::rollBack();
            return;
        }
        //1. Insert into order_stock_entries
        $stock_entry = OrderStockEntry::create([
            'order_id'     => $this->orderId,
            'order_item_id'=> $orderItemId,
            'fabric_id'   => $item['collection_id'] == 1 ? $item['fabrics']->id : null,
            'product_id'  => $item['collection_id'] == 2 ? $item['product']->id : null,
            'quantity'    => $enteredQuantity,
            'unit'        => $item['stock_entry_data']['type'],
            'created_by'  => auth()->guard('admin')->user()->id
        ]);

        // update stock
        if($item['collection_id'] == 1){
            $fabricId = $item['fabrics']->id;
            $stock = StockFabric::where('fabric_id', $fabricId)->first();
            $previous = $stock->qty_in_meter;
            $newQty = max($previous - $enteredQuantity, 0);
            $stock->update(['qty_in_meter' => $newQty]);
            
        }elseif($item['collection_id'] == 2){
            $productId = $item['product']->id;
            $stock = StockProduct::where('product_id',$productId)->first();
            $previous = $stock->qty_in_pieces;
            $newQty = max($previous - $enteredQuantity, 0);
            $stock->update(['qty_in_pieces' => $newQty]);
        }

        // Stock Out log status
        ChangeLog::create([
            'done_by' => auth()->guard('admin')->user()->id,
            'purpose' => 'stock_entry_update',
            'data_details' => json_encode($stock_entry)
        ]);

            DB::commit();
        $this->rows['is_done_'.$inputName] = true;
        $this->resetPage($inputName);
        $this->loadOrderItems();
                
        }catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function revertBackStock($index,$inputName){
         try {
           DB::beginTransaction();
           $item = $this->orderItems[$index];
            $orderItemId = $item['id'];
            $enteredQuantity = $this->rows[$inputName] ?? 0;

            // Find the latest stock entry for this order item
            $stockEntry = OrderStockEntry::where('order_item_id', $orderItemId)
                            ->latest()->first();
            if ($stockEntry) {
            // Revert the stock
            if ($item['collection_id'] == 1) {
                $stock = StockFabric::where('fabric_id', $stockEntry->fabric_id)->first();
                $stock->update(['qty_in_meter' => $stock->qty_in_meter + $stockEntry->quantity]);
            } elseif ($item['collection_id'] == 2) {
                $stock = StockProduct::where('product_id', $stockEntry->product_id)->first();
                $stock->update(['qty_in_pieces' => $stock->qty_in_pieces + $stockEntry->quantity]);
            }

            $stockEntry->delete();

           
        }
           DB::commit(); 
            // Reset and reload
            $this->resetPage($inputName);
            $this->loadOrderItems();

         }catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function loadOrderItems(){
        $this->orderItems = $this->order->items->map(function ($item) {
            $product = Product::find($item->product_id);
            $stockData = Helper::getStockEntryData(
                $item->collection,
                $item->fabrics,
                $item->product_id,
                $this->orderId,
                $item->id
            );
           $hasStockEntry = OrderStockEntry::where('order_item_id', $item->id)->exists();
            return [
                'id' => $item->id,
                'product_name' => $item->product_name ?? $product->name,
                'collection_id' => $item->collection,
                'collection_title' => $item->collectionType ?  $item->collectionType->title : "",
                'fabrics' => $item->fabric,
                'product' => $item->product,
                'measurements' => $item->measurements,
                'catalogue' => $item->catalogue_id?$item->catalogue:"",
                'catalogue_id' => $item->catalogue_id,
                'cat_page_number' => $item->cat_page_number,
                'price' => $item->piece_price,
                'quantity' => $item->quantity,
                'product_image' => $product ? $product->product_image : null,
                'stock_entry_data' => $stockData,
                'has_stock_entry'  => $hasStockEntry
            ];
        });
        
    }

    public function resetPage($inputName){
         // Clear the input field
        $this->rows[$inputName] = '';
         // Reset validation for this input
        unset($this->rows['is_valid_'.$inputName]);
    }   

    public function openStockModal($index){
        $item =  $this->orderItems[$index];
         $this->selectedItem = [
            'index' => $index,
            'collection_title' => $item['collection_title'],
            'collection_id' => $item['collection_id'],
            'product_name' => $item['product']['name'] ?? '',
            'fabric_title' => $item['fabrics']['title'] ?? '',
            'available_label' => $item['stock_entry_data']['available_label'],
            'available_value' => $item['stock_entry_data']['available_value'],
            'updated_label' => $item['stock_entry_data']['updated_label'],
            'input_name' => 'row_' . $index . '_' . $item['stock_entry_data']['input_name'],
            'has_stock_entry' => $item['has_stock_entry'],
      ]; 
        $this->dispatch('open-stock-modal');
    }

    public function render()
    {
         // Fetch the order and its related items
        //  $order = Order::with('items')->findOrFail($this->orderId);
         
         // Fetch product details for each order item
         $this->loadOrderItems();
        return view('livewire.order.production-order-details',[
            //  'order' => $this->order,
            'orderItems' => $this->orderItems,
            'latestOrders'=>$this->latestOrders,
        ]);
    }
}
