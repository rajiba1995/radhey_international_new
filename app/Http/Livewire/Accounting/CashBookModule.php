<?php

namespace App\Http\Livewire\Accounting;

use Livewire\Component;
use App\Models\PaymentCollection;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Journal;
use App\Models\Ledger;
use App\Models\Payment;
use App\Models\PaymentRevoke;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;


class CashBookModule extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $totalCollections = 0;
    public $totalExpenses = 0;
    public $totalWallet = 0;
    public $paymentCollections = [];
    public $paymentExpenses = [];

    public $start_date;
    public $end_date;
    protected $listeners = ['revoke-payment-confirmed' => 'revokePayment'];

    public function mount()
    {
        // Default to current month
        $this->start_date = Carbon::now()->toDateString();
        $this->end_date = Carbon::now()->toDateString();
    }
    
    public function AddStartDate($date){
        $this->start_date = $date;
    }

    public function AddEndDate($date){
        $this->end_date = $date;
    }
    
    public function resetForm(){
        $this->reset([
            'start_date',
            'end_date',
        ]);
    }

    public function revokePayment($id)
    {
         $payment_collections = PaymentCollection::find($id);

        if (!$payment_collections) {
            session()->flash('error', 'Payment not found.');
            return;
        }

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
            'created_at' => now()
        );

        PaymentRevoke::insert($paymentRevoke);

        # Reset invoices
        $invoiceIds = Invoice::where('customer_id', $customer_id)->pluck('id')->toArray();
        Invoice::whereIn('id', $invoiceIds)->update([
            'required_payment_amount' => \DB::raw('net_price'),
            'payment_status' => 0,
            'is_paid' => 0
        ]);

        # Delete invoice payments
        InvoicePayment::whereIn('invoice_id', $invoiceIds)->delete();

        # Delete ledger, journal, and payment
        Ledger::where('payment_id', $payment_id)->delete();
        Journal::where('payment_id', $payment_id)->delete();
        Payment::where('id', $payment_id)->delete();

        # Finally delete collection itself
        PaymentCollection::where('id', $id)->delete();

        session()->flash('success', 'Payment revoked successfully.');
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
                            'required_payment_amount'=>0,
                            'payment_status' => 2,
                            'is_paid'=>1
                        ]);
                        InvoicePayment::insert([
                            'invoice_id' => $inv->id,
                            'payment_collection_id' => $payment_collection_id,
                            'invoice_no' => $inv->invoice_no,
                            'voucher_no' => $payments['voucher_no'],
                            'invoice_amount' => $inv->net_price,
                            'vouchar_amount' => $payment_amount,
                            'paid_amount' => $amount,
                            'rest_amount' => 0,
                            'created_at' => $payments['created_at'],
                            'updated_at' => $payments['created_at']
                        ]);
                        $amount_after_settlement = 0;
                    }else{
                        // die('Not Full Covered');
                        if($amount_after_settlement>$amount && $amount_after_settlement>0){
                            $amount_after_settlement=$amount_after_settlement-$amount;
                            Invoice::where('id',$inv->id)->update([
                                'required_payment_amount'=>0,
                                'payment_status' => 2,
                                'is_paid'=>1
                            ]);    
                            InvoicePayment::insert([
                                'invoice_id' => $inv->id,
                                'payment_collection_id' => $payment_collection_id,
                                'invoice_no' => $inv->invoice_no,
                                'voucher_no' => $payments['voucher_no'],
                                'invoice_amount' => $inv->net_price,
                                'vouchar_amount' => $payment_amount,
                                'paid_amount' => $amount,
                                'rest_amount' => 0,
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
                                'voucher_no' => $payments['voucher_no'],
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

    public function downloadInvoice($payment_id)
    {
        $invoice_payments = [];
        $data = PaymentCollection::with(['customer', 'user'])
                    ->where('id', $payment_id)
                    ->firstOrFail();
        if($data){
            $invoice_payments = InvoicePayment::with('invoice')->where('voucher_no','=',$data->voucher_no)->get();
        }
        // Generate PDF
        $pdf = PDF::loadView('invoice.pdf', compact('data','invoice_payments'));
    
        // Download the PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        },  $data->voucher_no . '.pdf');
    } 
    

   public function render()
    {
         $user = Auth::guard('admin')->user();

        // Get earliest transaction date (start point)
        $firstCollectionDate = PaymentCollection::where('is_approve', 1)->orderBy('created_at')->value('created_at');
        $firstExpenseDate = Journal::where('is_debit', 1)->orderBy('created_at')->value('created_at');
        
        $openingDate = min($firstCollectionDate, $firstExpenseDate);
    
        // Opening Balance (till day before selected start date)
        $pastCollections = PaymentCollection::where('is_approve', 1)
            ->whereDate('created_at', '<', $this->start_date)
            ->sum('collection_amount');
    
        $pastExpenses = Journal::where('is_debit', 1)
            ->whereDate('created_at', '<', $this->start_date)
            ->sum('transaction_amount');
    
        $openingBalance = $pastCollections - $pastExpenses;
    
        // Today's Collections
        $collectionQuery = PaymentCollection::where('is_approve', 1);
        if ($this->start_date && $this->end_date) {
            $collectionQuery->whereDate('created_at', '>=', $this->start_date)
                            ->whereDate('created_at', '<=', $this->end_date);
        }
        $this->totalCollections = $collectionQuery->sum('collection_amount');
    
        // Today's Expenses
        $expenseQuery = Journal::where('is_debit', 1);
        if ($this->start_date && $this->end_date) {
            $expenseQuery->whereDate('created_at', '>=', $this->start_date)
                         ->whereDate('created_at', '<=', $this->end_date);
        }
        $this->totalExpenses = $expenseQuery->sum('transaction_amount');
    
        // Final Wallet: Opening + Today’s Net Movement
        $this->totalWallet = $openingBalance + ($this->totalCollections - $this->totalExpenses);
        
        // payment collection table data 
        $paymentQuery = PaymentCollection::where('is_approve', 1);
        
        // Add user filter if not super admin
        if (!$user->is_super_admin) {
            $paymentQuery->where('user_id', $user->id);
        }

        if($this->start_date && $this->end_date) {
            $paymentQuery->whereDate('created_at', '>=', $this->start_date)
                         ->whereDate('created_at', '<=', $this->end_date);
        }
        $this->paymentCollections = $paymentQuery->orderBy('created_at', 'desc')->get();

        // Payment table data for expense
        $paymentExpenseQuery = Payment::where('payment_for','debit');
        
         // Add user filter if not super admin
        if (!$user->is_super_admin) {
            $paymentExpenseQuery->where('stuff_id', $user->id);
        }

        if($this->start_date && $this->end_date) {
            $paymentExpenseQuery->whereDate('created_at', '>=', $this->start_date)
                         ->whereDate('created_at', '<=', $this->end_date);
        }
        $this->paymentExpenses = $paymentExpenseQuery->orderBy('created_at', 'desc')->get();

        return view('livewire.accounting.cash-book-module');
    }


}
