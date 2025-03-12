<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Catalogue;
use App\Models\Page;
use App\Models\CataloguePageItem;

class CataloguePages extends Component
{
    public $pages;
    public $cataloguePageId;
    public $catalogue_id;
    public $catalogue_name;
    public $page_number;
    public $catalog_items = [''];

    public function mount($catalogue_id){
        $catalogue = Catalogue::with('catalogueTitle')->findOrFail($catalogue_id);
        $this->catalogue_id = $catalogue->id;
        $this->catalogue_name = $catalogue->catalogueTitle->title ?? 'Unknwon';
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

    public function addItem(){
        $this->catalog_items[] = '';
    }

    public function removeItem($index){
        if(count($this->catalog_items) > 1){
            unset($this->catalog_items[$index]);
            $this->catalog_items = array_values($this->catalog_items);
        }
    }

    public function store(){
        $this->validate([
            'page_number'    => 'required',
            'catalog_items.*'  => 'required'
        ],[
            'page_number.required'    => 'Page number is required.',
            'catalog_items.*.required' => 'Page Item is required.',
        ]);

        foreach($this->catalog_items as $item){
            CataloguePageItem::create([
                'catalogue_id' => $this->catalogue_id,
                'page_id'      => Page::where('catalogue_id',$this->catalogue_id)->value('id'),
                'catalog_item' => $item
            ]);
        }

        session()->flash('message','Catalogue Page Items added successfully!');
        $this->resetForm();
    }

    public function resetForm(){
        $this->reset([
          'catalog_items',
          'page_number'
        ]);
    }


    public function render()
    {
        return view('livewire.product.catalogue-pages');
    }
}
