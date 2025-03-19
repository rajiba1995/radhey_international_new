<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Catalogue;
use App\Models\Page;
use App\Models\CataloguePageItem;

class CataloguePages extends Component
{
    public $pages;
    public $editing = false;
    public $editingPageId; 
    public $cataloguePageId;
    public $catalogue_id;
    public $catalogue_name;
    public $page_number;
    public $catalog_items = [''];

    public function mount($catalogue_id){
        $catalogue = Catalogue::with('catalogueTitle')->findOrFail($catalogue_id);
        $this->catalogue_id = $catalogue->id;
        $this->catalogue_name = $catalogue->catalogueTitle->title ?? 'Unknwon';
        $this->pages = Page::with(['catalogue','cataloguePageItems'])->where('catalogue_id',$catalogue_id)->get();
    }

    public function setCatalogueAndPage($catalogue_id, $page_number){
        $catalogue = Catalogue::find($catalogue_id);
        // $this->catalogue_id = $catalogue_id;
        if($catalogue){
            $catalogue_name  = $catalogue->catalogueTitle->title ?? 'Unknown';
        }
        $this->page_number = $page_number;
        $this->cataloguePageId = null; // Reset to null for create mode
        $this->catalog_items = ['']; // Reset items
    }

    public function editCatalogueAndPage($catalogue_id, $page_number){
        $this->catalogue_id = $catalogue_id;
        $this->page_number = $page_number;
    
        // Fetch catalogue details
        $catalogue = Catalogue::find($catalogue_id);
        if ($catalogue) {
            $this->catalogue_name = $catalogue->catalogueTitle->title ?? 'Unknown';
        }
    
        // Fetch the selected page items
        $page = Page::with('cataloguePageItems')->where('catalogue_id', $catalogue_id)
            ->where('page_number', $page_number)
            ->first();
    
        if ($page) {
            $this->cataloguePageId = $page->id;
            // Populate catalog_items with existing values
            $this->catalog_items = $page->cataloguePageItems->pluck('catalog_item')->toArray();
        } else {
            $this->cataloguePageId = null;
            $this->catalog_items = [''];
        }
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

    // public function storeOrUpdate(){
    //     $this->validate([
    //         'page_number'    => 'required',
    //         'catalog_items.*'  => 'required'
    //     ],[
    //         'page_number.required'    => 'Page number is required.',
    //         'catalog_items.*.required' => 'Page Item is required.',
    //     ]);
    //     // Find the correct page_id using page_number
    //     $page = Page::where('catalogue_id', $this->catalogue_id)
    //                     ->where('page_number', $this->page_number)
    //                     ->first();

    //     foreach($this->catalog_items as $item){
    //         CataloguePageItem::create([
    //             'catalogue_id' => $this->catalogue_id,
    //             'page_id'      => $page->id,
    //             'catalog_item' => $item
    //         ]);
    //     }

    //     $this->pages = Page::with(['catalogue', 'cataloguePageItems'])
    //     ->where('catalogue_id', $this->catalogue_id)
    //     ->get();
    //     session()->flash('message','Catalogue Page Items added successfully!');
    //     $this->resetForm();
    // }

    // public function storeOrUpdate() {
    //     $this->validate([
    //         'page_number'    => 'required',
    //         'catalog_items.*'  => 'required'
    //     ],[
    //         'page_number.required'    => 'Page number is required.',
    //         'catalog_items.*.required' => 'Page Item is required.',
    //     ]);
    
    //     // Find the correct page_id using page_number
    //     $page = Page::where('catalogue_id', $this->catalogue_id)
    //                 ->where('page_number', $this->page_number)
    //                 ->first();
    
    //     if (!$page) {
    //         session()->flash('error', 'Page not found.');
    //         return;
    //     }
    
    //     // Fetch existing items from the database
    //     $existingItems = CataloguePageItem::where('catalogue_id', $this->catalogue_id)
    //                                       ->where('page_id', $page->id)
    //                                       ->pluck('catalog_item', 'id');
    
    //     // Store new and updated items
    //     $newItems = [];
    //     foreach ($this->catalog_items as $item) {
    //         // Check if the item already exists, update if needed
    //         if (($key = $existingItems->search($item)) !== false) {
    //             unset($existingItems[$key]); // Remove from deletion list
    //         } else {
    //             $newItems[] = [
    //                 'catalogue_id' => $this->catalogue_id,
    //                 'page_id'      => $page->id,
    //                 'catalog_item' => $item
    //             ];
    //         }
    //     }
    
    //     // Insert new items
    //     if (!empty($newItems)) {
    //         CataloguePageItem::insert($newItems);
    //     }
    
    //     // Delete removed items
    //     if ($existingItems->isNotEmpty()) {
    //         CataloguePageItem::whereIn('id', $existingItems->keys())->delete();
    //     }
    
    //     // Refresh the pages list
    //     $this->pages = Page::with(['catalogue', 'cataloguePageItems'])
    //         ->where('catalogue_id', $this->catalogue_id)
    //         ->get();
    
    //     session()->flash('message', 'Catalogue Page Items updated successfully!');
    //     $this->resetForm();
       
    // }

    // public function storeOrUpdate() {
    //     $this->validate([
    //         'page_number'    => 'required',
    //         'catalog_items.*'  => 'required'
    //     ],[
    //         'page_number.required'    => 'Page number is required.',
    //         'catalog_items.*.required' => 'Page Item is required.',
    //     ]);
    
    //     // Find or create the page
    //     $page = Page::firstOrCreate([
    //         'catalogue_id' => $this->catalogue_id,
    //         'page_number' => $this->page_number
    //     ]);
    
    //     // Fetch existing items from the database (id => catalog_item)
    //     $existingItems = CataloguePageItem::where('catalogue_id', $this->catalogue_id)
    //                                       ->where('page_id', $page->id)
    //                                       ->get()
    //                                       ->keyBy('catalog_item'); // Store by 'catalog_item' for easy lookup
    
    //     $processedItems = [];
    
    //     foreach ($this->catalog_items as $item) {
    //         if (isset($existingItems[$item])) {
    //             // If item already exists, update if necessary
    //             $existingItem = $existingItems[$item];
    //             if ($existingItem->catalog_item !== $item) {
    //                 $existingItem->update(['catalog_item' => $item]);
    //             }
    //             $processedItems[] = $existingItem->id;
    //         } else {
    //             // Insert new item
    //             $newItem = CataloguePageItem::create([
    //                 'catalogue_id' => $this->catalogue_id,
    //                 'page_id'      => $page->id,
    //                 'catalog_item' => $item
    //             ]);
    //             $processedItems[] = $newItem->id;
    //         }
    //     }
    
    //     // Delete items that were removed
    //     CataloguePageItem::where('catalogue_id', $this->catalogue_id)
    //         ->where('page_id', $page->id)
    //         ->whereNotIn('id', $processedItems)
    //         ->delete();
    
    //     // Refresh the pages list
    //     $this->pages = Page::with(['catalogue', 'cataloguePageItems'])
    //         ->where('catalogue_id', $this->catalogue_id)
    //         ->get();
    
    //     session()->flash('message', 'Catalogue Page Items updated successfully!');
    //     $this->resetForm();
    // }
    
    // public function storeOrUpdate() {
    //     $this->validate([
    //         'page_number'    => 'required',
    //         'catalog_items.*'  => 'required'
    //     ],[
    //         'page_number.required'    => 'Page number is required.',
    //         'catalog_items.*.required' => 'Page Item is required.',
    //     ]);
    
    //     // Find or create the page
    //     $page = Page::firstOrCreate([
    //         'catalogue_id' => $this->catalogue_id,
    //         'page_number' => $this->page_number
    //     ]);
    
    //     // Fetch existing items (only values)
    //      $existingItems = CataloguePageItem::where('catalogue_id', $this->catalogue_id)
    //                 ->where('page_id', $page->id)
    //                 ->pluck('catalog_item')
    //                 ->toArray(); // Convert to array for easy comparison
    
       
    //         foreach ($this->catalog_items as $item) {
    //             if (!in_array($item, $existingItems)) {
    //                 // Insert only if the item doesn't already exist
    //                 CataloguePageItem::create([
    //                     'catalogue_id' => $this->catalogue_id,
    //                     'page_id'      => $page->id,
    //                     'catalog_item' => $item
    //                 ]);
    //             }
    //         }
       
    //         // **Update Mode**: Modify existing items without deleting all
    //         $processedItems = [];
    
    //         foreach ($this->catalog_items as $item) {
    //             if (isset($existingItems[$item])) {
    //                 // Existing item, keep it
    //                 $processedItems[] = $existingItems[$item];
    //             } else {
    //                 // Insert new item
    //                 $newItem = CataloguePageItem::create([
    //                     'catalogue_id' => $this->catalogue_id,
    //                     'page_id'      => $page->id,
    //                     'catalog_item' => $item
    //                 ]);
    //                 $processedItems[] = $newItem->id;
    //             }
    //         }
    
    //         // Delete items that were removed
    //         CataloguePageItem::where('catalogue_id', $this->catalogue_id)
    //             ->where('page_id', $page->id)
    //             ->whereNotIn('id', $processedItems)
    //             ->delete();
        
    
    //     // Refresh the pages list
    //     $this->pages = Page::with(['catalogue', 'cataloguePageItems'])
    //         ->where('catalogue_id', $this->catalogue_id)
    //         ->get();
    
    //     session()->flash('message', 'Catalogue Page Items updated successfully!');
    //     $this->resetForm();
    // }
    
    public function storeOrUpdate() {
        $this->validate([
            'page_number'    => 'required',
            'catalog_items.*'  => 'required'
        ],[
            'page_number.required'    => 'Page number is required.',
            'catalog_items.*.required' => 'Page Item is required.',
        ]);
    
        // Find or create the page
        $page = Page::firstOrCreate([
            'catalogue_id' => $this->catalogue_id,
            'page_number' => $this->page_number
        ]);
    
        // Fetch existing items (only values)
        $existingItems = CataloguePageItem::where('catalogue_id', $this->catalogue_id)
                    ->where('page_id', $page->id)
                    ->pluck('catalog_item')
                    ->toArray(); // Convert to array for easy comparison
    
        foreach ($this->catalog_items as $item) {
            if (!in_array($item, $existingItems)) {
                // Insert only if the item doesn't already exist
                CataloguePageItem::create([
                    'catalogue_id' => $this->catalogue_id,
                    'page_id'      => $page->id,
                    'catalog_item' => $item
                ]);
            }
        }

        
    
    
        // Refresh the pages list
        $this->pages = Page::with(['catalogue', 'cataloguePageItems'])
            ->where('catalogue_id', $this->catalogue_id)
            ->get();
    
        session()->flash('message', 'Catalogue Page Items stored successfully!');
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
