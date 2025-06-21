<?php

namespace App\Http\Livewire\Order;
use App\Models\Order;
use \App\Models\Product;
use \App\Models\Invoice;
use \App\Models\StockFabric;
use \App\Models\StockProduct;
use \App\Models\OrderStockEntry;
use \App\Models\ChangeLog;
use \App\Models\Delivery;
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
    public $selectedDeliveryItem = [];
    public $actualUsage;
    public $deliveryType = 'full';
    public $showExtraStockPrompt;

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

   

 

    public function updateStock($index, $inputName)
    {
        try {
            DB::beginTransaction();

            $item = $this->orderItems[$index];
            $orderItemId = $item['id'];
            $enteredQuantity = $this->rows[$inputName] ?? 0;

            // Validate input
            $validator = Validator::make(
                [$inputName => $enteredQuantity],
                [
                    $inputName => [
                        'required',
                        'numeric',
                        'min:1',
                    ],
                ],
                [
                    $inputName . '.required' => 'Quantity is required.',
                    $inputName . '.numeric'  => 'Quantity must be a number.',
                    $inputName . '.min'      => 'Quantity must be at least 1.',
                ]
            );

            if ($validator->fails()) {
                $this->rows['is_valid_' . $inputName] = false;
                $this->addError($inputName, $validator->errors()->first($inputName));
                DB::rollBack();
                return;
            }

            $stockEntry = OrderStockEntry::where('order_item_id', $orderItemId)->first();

            $previousQuantity = $stockEntry ? $stockEntry->quantity : 0;

            if ($item['collection_id'] == 1) {
                // fabric
                $fabricId = $item['fabrics']->id;
                $stock = StockFabric::where('fabric_id', $fabricId)->first();
                $availableStock = $stock->qty_in_meter;

            } elseif ($item['collection_id'] == 2) {
                // product
                $productId = $item['product']->id;
                $stock = StockProduct::where('product_id', $productId)->first();
                $availableStock = $stock->qty_in_pieces;
            }

        
            $maxAllowed = $availableStock + $previousQuantity;
            if ($enteredQuantity > $maxAllowed) {
                $this->addError($inputName, "Quantity must be less than or equal to {$maxAllowed}.");
                DB::rollBack();
                return;
            }

        
            $difference = $enteredQuantity - $previousQuantity;

            if ($stockEntry) {
                // update stock entry
                $stockEntry->update(['quantity' => $enteredQuantity]);
            } else {
                // create new stock entry
                $stockEntry = OrderStockEntry::create([
                    'order_id'     => $this->orderId,
                    'order_item_id'=> $orderItemId,
                    'fabric_id'    => $item['collection_id'] == 1 ? $item['fabrics']->id : null,
                    'product_id'   => $item['collection_id'] == 2 ? $item['product']->id : null,
                    'quantity'     => $enteredQuantity,
                    'unit'         => $item['stock_entry_data']['type'],
                    'created_by'   => auth()->guard('admin')->user()->id,
                ]);
            }

            // Now subtract difference from stock table
            if ($item['collection_id'] == 1) {
                $stock->update([
                    'qty_in_meter' => $stock->qty_in_meter - $difference
                ]);
            } elseif ($item['collection_id'] == 2) {
                $stock->update([
                    'qty_in_pieces' => $stock->qty_in_pieces - $difference
                ]);
            }

            // Log
            ChangeLog::create([
                'done_by' => auth()->guard('admin')->user()->id,
                'purpose' => 'stock_entry_update',
                'data_details' => json_encode($stockEntry)
            ]);

            DB::commit();

            $this->rows['is_done_' . $inputName] = true;
            $this->resetPage($inputName);
            $this->loadOrderItems();
            $this->openStockModal($index);

            return redirect()->route('production.order.details', $this->orderId);

        } catch (\Throwable $e) {
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
            $this->openStockModal($index);
            return redirect()->route('production.order.details',$this->orderId);

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

           $stock = null;
           $totalStock = 0;
           $used = 0;
            if($item->collection == 1){
                //Fabric
                $stock = StockFabric::where('fabric_id',$item->fabrics)->first();
                $totalStock = $stock ? $stock->qty_in_meter : 0;
                $used = OrderStockEntry::where('order_item_id', $item->id)->sum('quantity');
            }elseif ($item->collection == 2) {
                // Product
                $stock = StockProduct::where('product_id', $item->product_id)->first();
                $totalStock = $stock ? $stock->qty_in_pieces : 0;
                $used = OrderStockEntry::where('order_item_id', $item->id)->sum('quantity');
           }

            $initialStock = $totalStock + $used; // initial = current + used
            $totalUsed = $initialStock - $totalStock; // amount used so far

            return [
                'id' => $item->id,
                'product_name' => $item->product_name ?? $product->name,
                'collection_id' => $item->collection,
                'collection_title' => $item->collectionType ?  $item->collectionType->title : "",
                'fabrics' => $item->fabric,
                'product' => $item->product,
                'measurements' => $item->measurements,
                'catalogue' => $item->catalogue_id ? $item->catalogue:"",
                'catalogue_id' => $item->catalogue_id,
                'cat_page_number' => $item->cat_page_number,
                'price' => $item->piece_price,
                'quantity' => $item->quantity,
                'product_image' => $product ? $product->product_image : null,
                'stock_entry_data' => $stockData,
                'has_stock_entry'  => $hasStockEntry,
                'total_used' => $totalUsed,
                'initial_stock' => $initialStock
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

        $fabricId = $item['collection_id'] == 1 ? ($item['fabrics']->id ?? null) : null;
        $productId = $item['collection_id'] == 2 ? ($item['product']->id ?? null) : null;

         $totalUsed = OrderStockEntry::query()
                    ->where('order_item_id', $item['id'])
                    ->when($fabricId, fn($q) => $q->where('fabric_id', $fabricId))
                    ->when($productId, fn($q) => $q->where('product_id', $productId))
                    ->sum('quantity');

        $inputName = 'row_' . $index . '_' . $item['stock_entry_data']['input_name'];
         $this->selectedItem = [
            'item_id' => $item['id'],
            'index' => $index,
            'collection_title' => $item['collection_title'],
            'collection_id' => $item['collection_id'],
            'product_name' => $item['product']['name'] ?? '',
            'fabric_title' => $item['fabrics']['title'] ?? '',
            'available_label' => $item['stock_entry_data']['available_label'],
            'available_value' => $item['stock_entry_data']['available_value'],
            'updated_label' => $item['stock_entry_data']['updated_label'],
            'input_name' => $inputName,
            'has_stock_entry' => $item['has_stock_entry'],
            'total_used' => $totalUsed, 
      ]; 
        $this->rows[$inputName] = $totalUsed;
        $this->dispatch('open-stock-modal');
    }

    public function openDeliveryModal($index)
    {
        $item = $this->orderItems[$index];

        $fabricId = $item['collection_id'] == 1 ? ($item['fabrics']->id ?? null) : null;
        $productId = $item['collection_id'] == 2 ? ($item['product']->id ?? null) : null;

        $plannedUsage = OrderStockEntry::query()
            ->where('order_item_id', $item['id'])
            ->when($fabricId, fn($q) => $q->where('fabric_id', $fabricId))
            ->when($productId, fn($q) => $q->where('product_id', $productId))
            ->sum('quantity');

        $unit = $item['collection_id'] == 1 ? 'meters' : 'pieces';
        
        $this->selectedDeliveryItem = [
            'item_id' => $item['id'],
            'index' => $index,
            'collection_id' => $item['collection_id'],
            'collection_title' => $item['collection_title'],
            'product_name' => $item['product']['name'] ?? '',
            'fabric_title' => $item['fabrics']['title'] ?? '',
            'product_id'   => $productId,
            'fabric_id'    => $fabricId,
            'planned_usage' => $plannedUsage,
            'unit' => $unit,
        ];

        $this->dispatch('open-delivery-modal');
    }

    public function checkActualUsage()
    {   
        $planned = $this->selectedDeliveryItem['planned_usage'] ?? 0;
        if ($this->actualUsage > $planned) {
            $this->showExtraStockPrompt = true;
        } else {
            $this->showExtraStockPrompt = false;
        }
    }

    public function updatedActualUsage()
    {
        $planned = $this->selectedDeliveryItem['planned_usage'] ?? 0;
        $this->showExtraStockPrompt = $this->actualUsage > $planned;
    }

    public function addExtraStock(){
        $index = $this->selectedDeliveryItem['index'] ?? null;

        if ($index !== null) {
            $this->dispatch('close-delivery-modal');

            $this->openStockModal($index);
            // Also hide the prompt:
            $this->showExtraStockPrompt = false;
        }
    }

    public function processDelivery(){
       
       $this->validate([
        'actualUsage' => 'required|numeric|min:1',
       ]);

       $item = $this->selectedDeliveryItem;
       $actual = $this->actualUsage;
       $deliverType = $this->deliveryType ?? 'full';
       
     //    Create the delivery
       Delivery::create([
           'order_id' => $this->orderId,
           'order_item_id' => $item['item_id'],
           'delivery_type' => $deliverType,
           'product_id'    => $item['collection_id'] == 2 ? ($item['product_id'] ?? null)  : null,
           'fabric_id'     => $item['collection_id'] == 1 ? ($item['fabric_id'] ?? null)   : null,
           'delivered_quantity'=> $actual,
           'unit'   => $item['unit'],
           'delivered_by' => auth()->guard('admin')->user()->id,
           'delivered_at' => now()
       ]);

        $this->actualUsage = null;
         $this->loadOrderItems();
         $this->dispatch('close-delivery-modal');
         return redirect()->route('production.order.details',$this->orderId);
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
