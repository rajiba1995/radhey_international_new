<?php

namespace App\Http\Livewire\Staff;

use Livewire\Component;
use App\Models\User;

class StaffIndex extends Component
{
    public $staff,$user_id;
    public function mount(){
    // Fetch all users with their bank and address information
        $this->staff = User::with(['bank','address','designationDetails'])->orderBy('name', 'ASC')->where('designation', '!=', 1)->where('user_type',0)->get();
    }

    public function toggleStatus($user_id){
        $staff = User::find($user_id);
        if($staff){
            $staff->status  = !$staff->status;
            $staff->save();
            session()->flash('message', 'Staff status updated successfully!');
        }

    }
    public function render()
    {
        return view('livewire.staff.staff-index',['staff'=>$this->staff]);
    }
}
