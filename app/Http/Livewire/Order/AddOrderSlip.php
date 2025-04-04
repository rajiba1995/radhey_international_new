<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PackingSlip;
use App\Models\Invoice;
use App\Models\Ledger;
use App\Models\InvoiceProduct;
use App\Models\PaymentCollection;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\AccountingRepositoryInterface;

class AddOrderSlip extends Component
{
    protected $accountingRepository;
    public $order;
    public $errorMessage = [];
    public $order_item = [];
    public $activePayementMode = 'cash';
    public $staffs =[];
    public $from_date;
    public $to_date;
    public $payment_collection_id = "";
    public $readonly = "readonly";
    public $customer,$customer_id, $staff_id,$staff_name, $total_amount, $actual_amount, $voucher_no, $payment_date, $payment_mode, $chq_utr_no, $bank_name, $receipt_for = "Customer",$amount;

    public function boot(AccountingRepositoryInterface $accountingRepository)
    {
        $this->accountingRepository = $accountingRepository;
    }
    public function mount($id){

        $this->order = Order::with('items','customer','createdBy')->where('id', $id)->first();
        if($this->order){
            foreach($this->order->items as $key=>$order_item){
                $this->order_item[$key]['id']= $order_item->id;
                $this->order_item[$key]['price']= (int)$order_item->piece_price;
                $this->order_item[$key]['quantity']= $order_item->quantity;
                $this->order_item[$key]['air_mail'] = $order_item->air_mail ?? 0;
            }
            $this->total_amount = $this->order->total_amount;
            $this->actual_amount = $this->order->total_amount;
            $this->customer = $this->order->customer->name;
            $this->customer_id = $this->order->customer->id;
            $this->staff_id = $this->order->createdBy->id;
            $this->staff_name = $this->order->createdBy->name;
            $this->payment_date = date('Y-m-d');
        }else{
            abort(404);
        }
        
        $this->voucher_no = 'PAYRECEIPT'.time();
        $this->staffs = User::where('user_type', 0)->where('designation', 2)->select('name', 'id')->orderBy('name', 'ASC')->get();
    }

    public function updateQuantity($value, $key,$price){
        if(!empty($value)){
            $this->order_item[$key]['quantity']= $value;
            $base_price = $price * $value;
            $air_mail = $this->order_item[$key]['air_mail'] ?? 0;
            $this->order_item[$key]['price'] = $base_price;
            $this->order_item[$key]['total'] = $base_price + $air_mail;

            $this->actual_amount = 0;
            foreach($this->order_item as $key=>$item){
                $air_mail = $item['air_mail'] ?? 0;
                $this->actual_amount +=$item['price'] + $air_mail;
            }
        }
    }

    public function submitForm(){
        // dd($this->all());
        $this->reset(['errorMessage']);
        $this->errorMessage = array();
        foreach ($this->order_item as $key => $item) {
            if (!isset($item['air_mail'])) {
                $item['air_mail'] = 0;
            }
            if (empty($item['quantity'])) {  // Ensure 'quantity' exists
                $this->errorMessage["order_item.$key.quantity"] = 'Please enter quantity.';
            }
        }
        // Validate customer
        if (empty($this->customer_id)) {
           $this->errorMessage['customer_id'] = 'Please select a customer.';
        }
        
        // Validate collected by
        if (empty($this->staff_id)) {
           $this->errorMessage['staff_id'] = 'Please select a staff member.';
        }

        // Validate amount
        // if (empty($this->amount) || !is_numeric($this->amount)) {
        //    $this->errorMessage['amount'] = 'Please enter a valid amount.';
        // }
        // Validate amount
        // if (empty($this->actual_amount) || !is_numeric($this->actual_amount)) {
        //    $this->errorMessage['actual_amount'] = 'Please enter a valid amount.';
        // }

        // Validate voucher no
        // if (empty($this->voucher_no)) {
        //    $this->errorMessage['voucher_no'] = 'Please enter a voucher number.';
        // }

        // Validate payment date
        // if (empty($this->payment_date) || !$this->is_valid_date($this->payment_date)) {
        //    $this->errorMessage['payment_date'] = 'Please select a valid payment date.';
        // }

        // Validate payment mode
        // if (empty($this->payment_mode)) {
        //    $this->errorMessage['payment_mode'] = 'Please select a payment mode.';
        // }

        // Validate cheque no / UTR no
        // if ($this->payment_mode != 'cash' && empty($this->chq_utr_no)) {
        //    $this->errorMessage['chq_utr_no'] = 'Please enter a cheque no / UTR no.';
        // }

        // Validate bank name
        // if ($this->payment_mode != 'cash' && empty($this->bank_name)) {
        //    $this->errorMessage['bank_name'] = 'Please enter a bank name.';
        // }
        if(count($this->errorMessage)>0){
            return $this->errorMessage;
        }else{
            try {
                DB::beginTransaction();
                $this->updateOrder();

                $this->updateOrderItems();

                $this->createPackingSlip();

                // $this->accountingRepository->StorePaymentReceipt($this->all());
              

                DB::commit();

                session()->flash('success', 'Payment receipt added successfully.');
                return redirect()->route('admin.order.index');
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('error', $e->getMessage());
            }
        }
       
    }
    public function updateOrder()
    {
        $this->validate([
            'total_amount' => 'required|numeric',
            'customer_id' => 'required|exists:users,id',
            'staff_id' => 'required|exists:users,id',
        ]);

        $order = Order::find($this->order->id); 

        if ($order) {
            $order->update([
                'customer_id' => $this->customer_id,
                'created_by' => $this->staff_id,
                'status' => "Confirmed",
                'last_payment_date' => $this->payment_date,
            ]);
        }
    }
    public function updateOrderItems()
    {
        $total_amount = 0;
        foreach ($this->order_item as $item) {
            $airMail = $item['air_mail'] ?? 0;
            $piecePrice = (float)$item['price']; 
            $quantity = (int)$item['quantity'];
            $totalPrice = ($piecePrice * $quantity) + $airMail;
            OrderItem::where('id', $item['id'])->update([
                'total_price' =>  $totalPrice,
                'quantity' => $item['quantity'],
                'air_mail' => $airMail,
                'piece_price' => $piecePrice,
            ]);

        }
        $order = Order::find($this->order->id);
        if ($order) {
            $totalAmount  = $order->items()->sum('total_price');
            $order->update([
                'total_amount' => $totalAmount,
            ]);
        }
    }
    public function createPackingSlip()
    {
        $order = Order::find($this->order->id);
        $remaining_amount = (is_numeric($this->actual_amount) ? (double) $this->actual_amount : 0) - 
            (is_numeric($this->amount) ? (double) $this->amount : 0);
            // $required_payment_amount = is_numeric($remaining_amount) ? $remaining_amount : 0;

        if ($order) {
            // Calculate the remaining amount
            $packingSlip=PackingSlip::create([
                'order_id' => $this->order->id,
                'customer_id' => $this->customer_id,
                'slipno' => $this->order->order_number, 
                // 'is_disbursed' => ($remaining_amount == 0) ? 1 : 0,
                'is_disbursed' => 0,
                'created_by' => $this->staff_id,
                'created_at' => now(),
                'disbursed_by' => $this->staff_id,
                // 'updated_by' => auth()->id(),
                // 'updated_at' => now(),
            ]);

            
            do {
                $lastInvoice = Invoice::orderBy('id', 'DESC')->first();
                $invoice_no = str_pad(optional($lastInvoice)->id + 1, 6, '0', STR_PAD_LEFT);
            } while (Invoice::where('invoice_no', $invoice_no)->exists()); // Ensure unique invoice_no
            

        $invoice = Invoice::create([
                'order_id' => $this->order->id,
                'customer_id' => $this->customer_id,
                'user_id' => $this->staff_id,
                'packingslip_id' => $packingSlip->id,
                'invoice_no' => $invoice_no,
                'net_price' => $order->total_amount,
                'required_payment_amount' =>$order->total_amount,
                'created_by' =>  $this->staff_id,
                'created_at' => now(),
                // 'updated_by' => auth()->id(),
                'updated_at' => now(),
            ]);

            // Fetch Products from Order Items
            $orderItems = $order->items;
             // Insert Invoice Products
             foreach ($orderItems as $key => $item) {
                InvoiceProduct::create([
                    'invoice_id' =>  $invoice->id,
                    'product_id' => $item->product_id,
                    'product_name'=> $item->product? $item->product->name : "",
                    'quantity' => $item->quantity,
                    'single_product_price'=> $item->piece_price,
                    'total_price' => $item->total_price + ($item->air_mail ?? 0),
                    'is_store_address_outstation' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
             }

            Ledger::insert([
                'user_type' => 'customer',
                'transaction_id' => $invoice_no,
                'customer_id' => $order->customer_id,
                'transaction_amount' => $order->total_amount,
                'bank_cash' => 'cash',
                'is_credit' => 0,
                'is_debit' => 1,
                'entry_date' => date('Y-m-d H:i:s'),
                'purpose' => 'invoice',
                'purpose_description' => 'invoice raised of sales order for customer',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }  
    }


    public function is_valid_date($date) {
        $timestamp = strtotime($date);
        if ($timestamp !== false) {
            return true;
        }
        return false;
    }
    public function ResetForm(){
        $this->reset(['customer','customer_id','staff_id', 'amount', 'voucher_no', 'payment_date', 'payment_mode', 'chq_utr_no', 'bank_name']);
        $this->voucher_no = 'PAYRECEIPT'.time();
    }
    public function ChangePaymentMode($value){
        $this->activePayementMode = $value;
    }
    public function render()
    {
        return view('livewire.order.add-order-slip');
    }
}
