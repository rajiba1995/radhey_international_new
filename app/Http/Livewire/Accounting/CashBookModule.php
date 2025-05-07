<?php

namespace App\Http\Livewire\Accounting;

use Livewire\Component;
use App\Models\PaymentCollection;
use App\Models\Journal;
use Carbon\Carbon;

class CashBookModule extends Component
{
    public $totalCollections = 0;
    public $totalExpenses = 0;
    public $totalWallet = 0;

    public $start_date;
    public $end_date;
    
    public function mount()
    {
        // Default to current month
        $this->start_date = Carbon::now()->startOfMonth()->toDateString();
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

    public function render()
    {
        // Total Collection from payment collection
        $collectionQuery = PaymentCollection::where('is_approve', 1);
        if($this->start_date && $this->end_date){
            $collectionQuery->whereDate('created_at', '>=', $this->start_date)
                             ->whereDate('created_at', '<=', $this->end_date);
        }
        $this->totalCollections = $collectionQuery->sum('collection_amount');
        // Total Expenses from journals where is_debit = 1
        $expenseQuery = Journal::where('is_debit', 1);
        if($this->start_date && $this->end_date){
            $expenseQuery->whereDate('created_at', '>=', $this->start_date)
                         ->whereDate('created_at', '<=', $this->end_date);
        }
        $this->totalExpenses = $expenseQuery->sum('transaction_amount');

        // Calculate total wallet
        $this->totalWallet = $this->totalCollections - $this->totalExpenses;

        return view('livewire.accounting.cash-book-module');
    }
}
