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
    public $search = '';

    public function FindCountry($keyword){
        $this->search = $keyword;
    }
    public function toggleStatus($id){
        $country_status = Country::find($id);
        $country_status->status = !$country_status->status;
        $country_status->save();
        session()->flash('message','Country status saved successfully!');
    }

    public function render()
    {
        $countries = Country::where('title' , 'like' , '%' . $this->search . '%')->paginate(10);
        return view('livewire.country.country-index',[
            'country'=> $countries
        ]);
    }
}
