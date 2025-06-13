<?php

namespace App\Http\Livewire\Country;

use Livewire\Component;
use App\Models\Country;
use Livewire\WithPagination;


class CountryIndex extends Component
{
    // public $country;
    public $selectedCountry = '';
    public $title,$country_code,$mobile_length;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

     public function updatingSearch()
    {
        $this->resetPage(); 
    }
    
    public function FindCountry($keyword){
        $this->search = $keyword;
    }
    public function toggleStatus($id){
        $country_status = Country::find($id);
        $country_status->status = !$country_status->status;
        $country_status->save();
        session()->flash('message','Country status saved successfully!');
    }

    public function editCountry($id){
        $this->selectedCountry = Country::find($id);
        $this->title = $this->selectedCountry->title;
        $this->country_code = $this->selectedCountry->country_code;
        $this->mobile_length = $this->selectedCountry->mobile_length;
    }
    public function resetForm(){
        $this->selectedCountry = '';
        $this->title = '';
        $this->country_code = '';
        $this->mobile_length = '';
    }

    public function updateCountry(){
        // dd($this->all());
        $this->validate([
            'title' => 'required',
            'country_code' => 'required',
            'mobile_length' => 'required',
        ]);
        $this->selectedCountry->title = $this->title;
        $this->selectedCountry->country_code = $this->country_code;
        $this->selectedCountry->mobile_length = $this->mobile_length;
        $this->selectedCountry->save();
        session()->flash('message','Country updated successfully!');
        $this->resetForm();
    }

    public function render()
    {
        $countries = Country::where('title' , 'like' , '%' . $this->search . '%')->paginate(10);
        return view('livewire.country.country-index',[
            'country'=> $countries
        ]);
    }
}
