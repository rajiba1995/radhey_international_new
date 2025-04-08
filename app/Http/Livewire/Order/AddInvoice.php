<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\Product;
use NumberToWords\NumberToWords;

class AddInvoice extends Component
{
    public $rows = []; 
    public $collections;
    public $totalAmount = 0;
    public $totalInWords = '';
    public $products;
    
    protected function rules()
    {
        $rules = [];

        foreach ($this->rows as $index => $row) {
            $rules["rows.$index.product_id"] = 'required|exists:products,id';
            $rules["rows.$index.unit_price"] = 'required|numeric';
        }

        return $rules;
    }

    protected function messages()
    {
        $messages = [];

        foreach ($this->rows as $index => $row) {

            $messages["rows.$index.product_id.required"]    = "Product is required.";
            $messages["rows.$index.product_id.exists"]      = "Selected product is invalid.";

            $messages["rows.$index.unit_price.required"]    = "Unit price is required.";
            $messages["rows.$index.unit_price.numeric"]     = "Unit price must be a number.";
        }

        return $messages;
    }



    public function mount(){
        $this->products = Product::all();
        $this->rows = [
            [
                'product_id' => '',
                'quantity' => 1,
                'unit_price' => '',
                'total' => '',
                'products' => [],
            ],
        ];
    }

  

    public function addRow(){
        $this->rows[] = [
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => '',
            'total' => '',
            'products' => [],
        ];
    }

    public function updatePrice($index)
    {
        $quantity = (int)($this->rows[$index]['quantity'] ?? 1);
        $unitPrice = is_numeric($this->rows[$index]['unit_price']) ? (float) $this->rows[$index]['unit_price'] : 0;

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

    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function updatedRows()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        // $this->totalAmount = collect($this->rows)->sum('total');
        $this->totalAmount = collect($this->rows)
        ->pluck('total')
        ->filter(fn($val) => is_numeric($val)) // only keep numeric values
        ->sum();
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
