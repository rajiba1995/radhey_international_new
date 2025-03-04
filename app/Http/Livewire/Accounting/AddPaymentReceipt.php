<?php

namespace App\Http\Livewire\Accounting;

use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentCollection;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\AccountingRepositoryInterface;

class AddPaymentReceipt extends Component
{   
    protected $accountingRepository;
    public $searchResults = [];
    public $errorMessage = [];
    public $activePayementMode = 'cash';
    public $staffs =[];
    public $payment_voucher_no;
    public $payment_id;
    public $payment_collection_id = "";
    public $readonly = "readonly";
    public $customer,$customer_id, $staff_id, $amount, $voucher_no, $payment_date, $payment_mode, $chq_utr_no, $bank_name, $receipt_for = "Customer";

    public function boot(AccountingRepositoryInterface $accountingRepository)
    {
        $this->accountingRepository = $accountingRepository;
    }
    public function mount($payment_voucher_no = ""){
        $payment_collection = PaymentCollection::with('customer', 'user')->where('voucher_no',$payment_voucher_no)->first();
        if(!empty($payment_voucher_no)){
            if(!$payment_collection){
                abort(404);
                return false;
            }
        }
     
        $this->payment_voucher_no = $payment_voucher_no;
        $this->voucher_no = 'PAYRECEIPT'.time();
        $this->staffs = User::where('user_type', 0)->where('designation', 2)->select('name', 'id')->orderBy('name', 'ASC')->get();
        if($payment_collection){
            $this->payment_collection_id = $payment_collection->id;
            $this->customer = $payment_collection->customer->name;
            $this->customer_id = $payment_collection->customer_id;
            $this->staff_id = $payment_collection->user_id;
            $this->amount = $payment_collection->collection_amount;
            $this->voucher_no = $payment_collection->voucher_no;
            $this->payment_date = $payment_collection->cheque_date;
            $this->payment_mode = $payment_collection->payment_type;
            $this->chq_utr_no = $payment_collection->cheque_number;
            $this->bank_name = $payment_collection->bank_name;
            $this->payment_id = $payment_collection->payment_id;
            $this->activePayementMode = $payment_collection->payment_type;
        }
        if(empty($payment_voucher_no)){
            $this->readonly = "";
        }
    }
   
    public function submitForm()
    {
        $this->reset(['errorMessage']);
        $this->errorMessage = array();
        // Validate customer
        if (empty($this->customer_id)) {
           $this->errorMessage['customer_id'] = 'Please select a customer.';
        }

        // Validate collected by
        if (empty($this->staff_id)) {
           $this->errorMessage['staff_id'] = 'Please select a staff member.';
        }

        // Validate amount
        if (empty($this->amount) || !is_numeric($this->amount)) {
           $this->errorMessage['amount'] = 'Please enter a valid amount.';
        }

        // Validate voucher no
        if (empty($this->voucher_no)) {
           $this->errorMessage['voucher_no'] = 'Please enter a voucher number.';
        }

        // Validate payment date
        if (empty($this->payment_date) || !$this->is_valid_date($this->payment_date)) {
           $this->errorMessage['payment_date'] = 'Please select a valid payment date.';
        }

        // Validate payment mode
        if (empty($this->payment_mode)) {
           $this->errorMessage['payment_mode'] = 'Please select a payment mode.';
        }

        // Validate cheque no / UTR no
        if ($this->payment_mode != 'cash' && empty($this->chq_utr_no)) {
           $this->errorMessage['chq_utr_no'] = 'Please enter a cheque no / UTR no.';
        }

        // Validate bank name
        if ($this->payment_mode != 'cash' && empty($this->bank_name)) {
           $this->errorMessage['bank_name'] = 'Please enter a bank name.';
        }
        if(count($this->errorMessage)>0){
            return $this->errorMessage;
        }else{
            try {
                DB::beginTransaction();
                //code...
                $this->accountingRepository->StorePaymentReceipt($this->all());
                session()->flash('success', 'Payment receipt added successfully.');
                DB::commit();
                return redirect()->route('admin.accounting.payment_collection');
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('error', $e->getMessage());
            }
        }
       
    }
    public function ResetForm(){
        $this->reset(['customer','customer_id','staff_id', 'amount', 'voucher_no', 'payment_date', 'payment_mode', 'chq_utr_no', 'bank_name']);
        $this->voucher_no = 'PAYRECEIPT'.time();
    }

    public function FindCustomer($term)
    {
        $this->searchResults = Helper::GetCustomerDetails($term);
    }
      // Function to validate date
       public function is_valid_date($date) {
            $timestamp = strtotime($date);
            if ($timestamp !== false) {
                return true;
            }
            return false;
        }

      public function selectCustomer($customer_id){
     
            $customer = User::find($customer_id);
            if($customer){
                $this->customer = $customer->name.'('.$customer->phone.')';
                $this->customer_id = $customer->id;
            }else{
                $this->reset(['customer','customer_id',]);
            }
            $this->searchResults = [];
           
      }
    public function ChangePaymentMode($value){
        $this->activePayementMode = $value;
    }
    public function render()
    {
        return view('livewire.accounting.add-payment-receipt');
    }
}
