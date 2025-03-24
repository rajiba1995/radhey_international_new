<?php

namespace App\Http\Livewire\Fabric;


use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Models\Fabric;
use App\Models\Product;
use Illuminate\Http\Request;


class FabricsIndex extends Component
{
    use WithPagination;

    public $fabrics;
    public  $title,$product_id, $status = 1, $fabricId,$image;
    public $search = '';
    protected $paginationTheme = 'bootstrap'; 


    public function mount($product_id)
    {
        // $this->product_id = $product_id; // Initialize with the passed product
        // $this->fabrics = Fabric::with('products')->get();


        $this->product = Product::with('fabrics')->findOrFail($product_id);
        $this->fabrics = $this->product->fabrics;
        // dd($this->fabrics);
    }
    // Render Method with Search and Pagination
    public function render()
    {
        $subCat = Product::select('name')->find($this->product_id);
        $productFabrics = Fabric::where('title', 'like', "%{$this->search}%")
            // ->orWhere('short_code', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('livewire.fabric.fabrics-index', compact('productFabrics'));
        
    }
}