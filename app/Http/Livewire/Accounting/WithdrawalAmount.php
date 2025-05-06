<?php

namespace App\Http\Livewire\Accounting;

use Livewire\Component;

class WithdrawalAmount extends Component
{
    public $payment_mode,$chq_utr_no,$bank_name,$na;

    public function changePaymentMode($value){
        $this->payment_mode = $value;
    }
    public function render()
    {
        return view('livewire.accounting.withdrawal-amount');
    }
}
