<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class Profile extends Component
{
    public $user;
    public function mount(){
        $this->user = Auth::guard('admin')->user();
    }
    public function render()
    {
        return view('livewire.profile');
    }
}
