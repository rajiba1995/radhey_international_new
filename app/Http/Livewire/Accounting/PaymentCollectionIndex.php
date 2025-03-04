<?php

namespace App\Http\Livewire\Accounting;

use Livewire\Component;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\PaymentCollection;
use App\Models\PaymentRevoke;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Ledger;
use App\Models\Journal;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class PaymentCollectionIndex extends Component
{
    use WithPagination;
    public $searchResults = [];
    public $data = [];
    public $total;
    public $staff_id;
    public $staffs = [];
    public $selected_customer;
    public $selected_customer_id;
    public $active_details = 0;

    public function mount(){
        $this->staffs = User::where('user_type', 0)->where('designation', 2)->select('name', 'id')->orderBy('name', 'ASC')->get();
    }

    public function CollectionData(){
        $desg = Auth::guard('admin')->user()->designation;
        $paginate = 20;
        $customer_id = $this->selected_customer_id;
        $staff_id = $this->staff_id;
    
        $query = PaymentCollection::with(['customer', 'user'])
            ->when(!empty($customer_id), function ($query) use ($customer_id) {
                $query->where('customer_id', $customer_id);
            })
            ->when(!empty($staff_id), function ($query) use ($staff_id) {
                $query->where('user_id', $staff_id);
            })
            ->orderBy('cheque_date', 'desc');
    
        $this->total = $query->count();
        return $query->paginate($paginate);
    }
    public function resetForm(){
        $this->active_details = 0;
        $this->reset(['selected_customer','selected_customer_id', 'staff_id']);
    }
    public function FindCustomer($term){
        $this->searchResults = Helper::GetCustomerDetails($term);
    }

    public function selectCustomer($customer_id){
        $customer = User::find($customer_id);
        if($customer){
            $this->selected_customer = $customer->name.'('.$customer->phone.')';
            $this->selected_customer_id = $customer->id;
        }else{
            $this->reset(['selected_customer','selected_customer_id']);
        }
        $this->searchResults = [];
    }

    public function CollectedBy($value){
        $this->staff_id = $value;
    }

    public function customerDetails($id){
        $this->active_details = $id;
    }

    public function revokePayment($id){
        $payment_collections = PaymentCollection::find($id);
        $customer_id = $payment_collections->customer_id;
        $voucher_no = $payment_collections->voucher_no;
        $collection_amount = $payment_collections->collection_amount;
        $payment_id = $payment_collections->payment_id;

        $paymentRevoke = array(
            'customer_id' => $customer_id,
            'done_by'     => Auth::guard('admin')->user()->id,
            'voucher_no'  => $voucher_no,
            'collection_amount' => $collection_amount,
            'paymentcollection_data_json' => json_encode($payment_collections),
            'created_at' => date('Y-m-d H:i:s')
        );

        PaymentRevoke::insert($paymentRevoke);
        $collection_data = $paymentIds = array();
        $other_payment_collections = PaymentCollection::where('customer_id',$customer_id)->where('id','!=',$id)->orderBy('cheque_date','asc')->get();
        foreach($other_payment_collections as $collections){
            $paymentIds[] = $collections->payment_id;
            $collection_data[] = array(
                'id' => $collections->id,
                'customer_id' => $collections->customer_id,
                'user_id' => $collections->user_id,
                'admin_id' => $collections->admin_id,
                'payment_id' => $collections->payment_id,
                'collection_amount' => $collections->collection_amount,
                'cheque_date' => $collections->cheque_date,
                'voucher_no' => $collections->voucher_no,
                'payment_type' => $collections->payment_type,
                'created_at' => date('Y-m-d H:i:s', strtotime($collections->created_at))
            );
        }

        $invoiceIds = array();
        $all_invoices = Invoice::where('customer_id',$customer_id)->get();
        foreach($all_invoices as $invoice){
            $invoiceIds[] = $invoice->id;
            # Revert Invoice Required Amount to Net Amount and All Payment Status
            Invoice::where('id',$invoice->id)->update([
                'required_payment_amount' => $invoice->net_price,
                'payment_status' => 0,
                'is_paid' => 0
            ]);
        }
        # Delete Invoice Payments
        InvoicePayment::whereIn('invoice_id',$invoiceIds)->delete();
        # Delete Ledger
        Ledger::where('payment_id',$payment_id)->delete();
        # Delete Journal
        Journal::where('payment_id',$payment_id)->delete();
        # Delete Payment
        Payment::where('id',$payment_id)->delete();
        $this->resetInvoicePayments($customer_id,$collection_data);

        # Delete Payment Collection
        PaymentCollection::where('id',$id)->delete();
        session()->flash('success', 'Payment revoked successfully'); 
    }

    private function resetInvoicePayments($customer_id, $collection_data){
        foreach($collection_data as $payments){
            $payment_amount = $payments['collection_amount'];
            $payment_collection_id = $payments['id'];
            $check_invoice_payments = InvoicePayment::where('voucher_no','=',$payments['voucher_no'])->get()->toarray();
            if(empty($check_invoice_payments)){
                $amount_after_settlement = $payment_amount;
                 $invoice = Invoice::where('customer_id',$customer_id)->where('is_paid',0)->orderBy('id','asc')->get();
                 $sum_inv_amount = 0;
                 foreach ($invoice as $inv) {
                    $amount = $inv->required_payment_amount;
                    $sum_inv_amount += $amount;
                    if($amount == $payment_amount){
                        // die('Full Covered');
                        Invoice::where('id',$inv->id)->update([
                            'required_payment_amount'=>'',
                            'payment_status' => 2,
                            'is_paid'=>1
                        ]);
                        InvoicePayment::insert([
                            'invoice_id' => $inv->id,
                            'payment_collection_id' => $payment_collection_id,
                            'invoice_no' => $inv->invoice_no,
                            'voucher_no' => $payments['vouchar_no'],
                            'invoice_amount' => $inv->net_price,
                            'vouchar_amount' => $payment_amount,
                            'paid_amount' => $amount,
                            'rest_amount' => '',
                            'created_at' => $payments['created_at'],
                            'updated_at' => $payments['created_at']
                        ]);
                        $amount_after_settlement = 0;
                    }else{
                        // die('Not Full Covered');
                        if($amount_after_settlement>$amount && $amount_after_settlement>0){
                            $amount_after_settlement=$amount_after_settlement-$amount;
                            Invoice::where('id',$inv->id)->update([
                                'required_payment_amount'=>'',
                                'payment_status' => 2,
                                'is_paid'=>1
                            ]);    
                            InvoicePayment::insert([
                                'invoice_id' => $inv->id,
                                'payment_collection_id' => $payment_collection_id,
                                'invoice_no' => $inv->invoice_no,
                                'voucher_no' => $payments['vouchar_no'],
                                'invoice_amount' => $inv->net_price,
                                'vouchar_amount' => $payment_amount,
                                'paid_amount' => $amount,
                                'rest_amount' => '',
                                'created_at' => $payments['created_at'],
                                'updated_at' => $payments['created_at']
                            ]);
                        }else if($amount_after_settlement<$amount && $amount_after_settlement>0){
                            $rest_payment_amount = ($amount - $amount_after_settlement);
                            Invoice::where('id',$inv->id)->update([
                                'required_payment_amount'=>$rest_payment_amount,
                                'payment_status' => 1,
                                'is_paid'=>0
                            ]);
                            InvoicePayment::insert([
                                'invoice_id' => $inv->id,
                                'payment_collection_id' => $payment_collection_id,
                                'invoice_no' => $inv->invoice_no,
                                'voucher_no' => $payments['vouchar_no'],
                                'invoice_amount' => $inv->net_price,
                                'vouchar_amount' => $payment_amount,
                                'paid_amount' => $amount_after_settlement,
                                'rest_amount' => $rest_payment_amount,
                                'created_at' => $payments['created_at'],
                                'updated_at' => $payments['created_at']
                            ]);    
                            $amount_after_settlement = 0;                                            
                        }else{

                        }
                    }
                 }
            }
        }
    }

    public function render()
    {
        $paginatedData = $this->CollectionData();
        return view('livewire.accounting.payment-collection-index', [
            'paymentData' => $paginatedData,
        ]);
    }
}
