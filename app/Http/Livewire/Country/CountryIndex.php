<?php

namespace App\Http\Livewire\Country;

use Livewire\Component;
use App\Models\Country;
use Livewire\WithPagination;


class CountryIndex extends Component
{
    // public $country;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

   
    public function toggleStatus($id){
        $country_status = Country::find($id);
        $country_status->status = !$country_status->status;
        $country_status->save();
        session()->flash('message','Country status saved successfully!');
    }

    public function render()
    {
        return view('livewire.country.country-index',[
            'country'=> Country::paginate(10)
        ]);
    }
}
