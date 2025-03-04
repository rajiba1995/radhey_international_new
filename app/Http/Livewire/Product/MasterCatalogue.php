<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Catalogue;
use App\Models\CatalogueTitle;
use Illuminate\Support\Facades\Storage; 

class MasterCatalogue extends Component
{
    use WithFileUploads;
    public $catalogueId;
    public $search;
    public $catalogue_title_id;
    public $page_number;
    public $image;
    public $catalogueTitle;
    public $catalogues;

    protected $rules = [
        'catalogue_title_id'=>'required|string|max:255|exists:catalogue_titles,id',
        'page_number'=> 'required|numeric',
        'image'=>'required|mimes:pdf',
    ];  

    protected $messages = [
        'catalogue_title_id.required' => 'The catalogue title is required.',
        'catalogue_title_id.string' => 'The catalogue title must be a valid string.',
        'catalogue_title_id.max' => 'The catalogue title cannot exceed 255 characters.',
        
        'page_number.required' => 'The page number is required.',
        'page_number.numeric' => 'The page number must be a number.',
    ];

    public function mount(){
        $this->catalogueTitle = CatalogueTitle::all();
        $this->reloadCatalogues();
    }

    public function reloadCatalogues()
    {
        $query = Catalogue::with('catalogueTitle');

        if ($this->catalogue_title_id) {
            $query->where('catalogue_title_id', $this->catalogue_title_id);
        }

        $this->catalogues = $query->get();  // Reload the catalogues
    }

    public function resetFields(){
        $this->catalogueId = null;
        $this->catalogue_title_id = '';
        $this->page_number = '';
        $this->image = null;
        
    }

    public function storeCatalogue(){
        $this->validate();
        // Check if the page number already exists for the selected catalogue title
        $existingCatalogue = Catalogue::where('catalogue_title_id',$this->catalogue_title_id)->where('page_number',$this->page_number)->first();
        if($existingCatalogue){
            session()->flash('error','Page Number ' . $this->page_number .' already exists for this catalogue title');
            return;
        }
        $pdfPath = null;
        if($this->image){
           $timeStamp = now()->timestamp;
            $extension = $this->image->getClientOriginalExtension();
            $pdfName = $timeStamp . '.' . $extension;
            $pdfPath =  $this->image->storeAs('catalogue_pdfs', $pdfName, 'public');
        }

        Catalogue::create([
            'catalogue_title_id' => $this->catalogue_title_id,
            'page_number' => $this->page_number,
            'image' => $pdfPath
        ]);

        session()->flash('message','Catalogue Created Successfully');
        $this->resetFields();
        $this->reloadCatalogues();
    }

    public function edit($id){
        $catalogue = Catalogue::findOrFail($id);
        $this->catalogueId = $catalogue->id;
        $this->catalogue_title_id = $catalogue->catalogue_title_id;
        $this->page_number = $catalogue->page_number;
        $this->image = $catalogue->image;
    }

    public function updateCatalogue(){
        $catalogue = Catalogue::findOrFail($this->catalogueId);
        $existingCatalogue = Catalogue::where('catalogue_title_id',$this->catalogue_title_id)->where('page_number',$this->page_number)->where('id','!=',$this->catalogueId)->first();
        if($existingCatalogue){
            session()->flash('error','Page Number ' . $this->page_number .' already exists for this catalogue title');
            return;
        }

        if ($this->image instanceof \Illuminate\Http\UploadedFile) {
            $timeStamp = now()->timestamp;
            $extension = $this->image->getClientOriginalExtension();
            $pdfName = $timeStamp . '.' . $extension;
            $pdfPath = $this->image->storeAs('catalogue_pdfs', $pdfName, 'public');
    
            if ($catalogue->image) {
                Storage::disk('public')->delete($catalogue->image);
            }
        } else {
            $pdfPath = $catalogue->image; 
        }

        $catalogue->update([
            'catalogue_title_id' => $this->catalogue_title_id,
            'page_number' => $this->page_number,
            'image' => $pdfPath,
        ]);

        session()->flash('message', 'Catalogue Updated Successfully');
        $this->resetFields();
        $this->reloadCatalogues();
    }

    public function destroy($id){
        $catalogue = Catalogue::findOrFail($id);
        if($catalogue->image){
            Storage::disk('public')->delete($catalogue->image);
        }

        $catalogue->delete();
        session()->flash('message','Catalogue deleted successfully');
        $this->reloadCatalogues();
    }

    public function render()
    { 
        return view('livewire.product.master-catalogue');
    }
}
