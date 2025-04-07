<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\Collection;
use App\Models\Product;
use NumberToWords\NumberToWords;

class AddInvoice extends Component
{
    public $rows = []; 
    public $collections;
    public $totalAmount = 0;
    public $totalInWords = '';

    protected function rules()
    {
        $rules = [];

        foreach ($this->rows as $index => $row) {
            $rules["rows.$index.collection_id"] = 'required|exists:collections,id';
            $rules["rows.$index.product_id"] = 'required|exists:products,id';
            $rules["rows.$index.unit_price"] = 'required|numeric';
        }

        return $rules;
    }

    protected function messages()
    {
        $messages = [];

        foreach ($this->rows as $index => $row) {
            $messages["rows.$index.collection_id.required"] = "Collection is required.";
            $messages["rows.$index.collection_id.exists"]   = "Selected collection is invalid.";

            $messages["rows.$index.product_id.required"]    = "Product is required.";
            $messages["rows.$index.product_id.exists"]      = "Selected product is invalid.";

            $messages["rows.$index.unit_price.required"]    = "Unit price is required.";
            $messages["rows.$index.unit_price.numeric"]     = "Unit price must be a number.";
        }

        return $messages;
    }



    public function mount(){
        $this->collections = Collection::all();
        $this->rows = [
            [
                'collection_id' => '',
                'product_id' => '',
                'quantity' => 1,
                'unit_price' => 0,
                'total' => 0,
                'products' => [],
            ],
        ];
    }

    public function SelectedCollection($index, $collectionId){
        $products = Product::where('collection_id', $collectionId)->get();
        $this->rows[$index]['collection_id'] = $collectionId;
        $this->rows[$index]['products'] = $products->toArray();
        $this->rows[$index]['product_id'] = '';

    }

    public function addRow(){
        $this->validate();
        $this->rows[] = [
            'collection_id' => '',
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'total' => 0,
            'products' => [],
        ];
    }

    public function updatePrice($index)
    {
        $quantity = (int)($this->rows[$index]['quantity'] ?? 1);
        $unitPrice = (float)($this->rows[$index]['unit_price'] ?? 0);

        $this->rows[$index]['total'] = $quantity * $unitPrice;
        $this->calculateTotal();
    }


    public function updateQuantity($index, $type)
    {
        if ($type === 'increase') {
            $this->rows[$index]['quantity']++;
        } elseif ($type === 'decrease') {
            if ($this->rows[$index]['quantity'] > 1) {
                $this->rows[$index]['quantity']--;
            }
        }

        // Recalculate total
        $quantity = $this->rows[$index]['quantity'];
        $unitPrice = $this->rows[$index]['unit_price'] ?? 0;

        $this->rows[$index]['total'] = $quantity * $unitPrice;
        $this->calculateTotal(); 
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows); // Re-index the array
    }

    // public function getTotalAmountProperty()
    // {
    //     return collect($this->rows)->sum('total');
    // }

    public function updatedRows()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalAmount = collect($this->rows)->sum('total');
        $this->totalInWords = $this->convertNumberToWords($this->totalAmount);
    }

    public function convertNumberToWords($number)
    {
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
    
        return ucfirst($numberTransformer->toWords($number)) . ' only';
    }

    public function printInvoice()
    {
        $this->validate();

        // Dispatch event to trigger JavaScript print
        $this->dispatch('triggerPrint');
    }


    public function render()
    {
        return view('livewire.order.add-invoice');
    }
}
