<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Catalogue;
use App\Models\Page;

class CataloguePages extends Component
{
    public $pages;
    public $cataloguePageId;
    public $catalogue_id;
    public $catalogue_name;
    public $page_number;

    public function mount($catalogue_id){
        $catalogue = Catalogue::with('catalogueTitle')->findOrFail($catalogue_id);
        $this->catalogue_id = $catalogue->id;
        
        $this->pages = Page::with('catalogue')->where('catalogue_id',$catalogue_id)->get();

    }

    public function setCatalogueAndPage($catalogue_id, $page_number){
        $catalogue = Catalogue::find($catalogue_id);
        // $this->catalogue_id = $catalogue_id;
        if($catalogue){
            $catalogue_name  = $catalogue->catalogueTitle->title ?? 'Unknown';
        }
        $this->page_number = $page_number;
    }
    public function render()
    {
        return view('livewire.product.catalogue-pages');
    }
}
