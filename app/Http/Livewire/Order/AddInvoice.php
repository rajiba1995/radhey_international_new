<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use NumberToWords\NumberToWords;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;


class AddInvoice extends Component
{
    public $rows = []; 
    public $collections;
    public $totalAmount = 0;
    public $totalInWords = '';
    public $products;
    public $customer_name,$invoice_date,$due_date,$source,$reference,$due_amount;
    public $salesmen;
    public $salesman;
    public $bill_book = [];
    public $order_number;
    
    protected function rules()
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'invoice_date'  => 'required|date',
            'due_date'      => 'required|date|after_or_equal:invoice_date',
            'source'        => 'required|string|unique:orders,source|max:255',
            'reference'     => 'required|string|unique:orders,reference|max:255',
        ];


        foreach ($this->rows as $index => $row) {
            $rules["rows.$index.product_id"] = 'required|exists:products,id';
            $rules["rows.$index.unit_price"] = 'required|numeric';
        }

        return $rules;
    }

    public function changeSalesman($value){
        $this->bill_book = Helper::generateInvoiceBill($value);
        $this->order_number = $this->bill_book['number'];
        $this->bill_id = $this->bill_book['bill_id'] ?? null;
    }

    protected function messages()
    {
        $messages = [
            'customer_name.required' => 'Customer name is required.',
            'invoice_date.required'  => 'Invoice date is required.',
            'due_date.required'      => 'Due date is required.',
            'source.required'        => 'Source is required.',
            'reference.required'     => 'Reference is required.',
        ];

        foreach ($this->rows as $index => $row) {

            $messages["rows.$index.product_id.required"]    = "Product is required.";
            $messages["rows.$index.product_id.exists"]      = "Selected product is invalid.";

            $messages["rows.$index.unit_price.required"]    = "Unit price is required.";
            $messages["rows.$index.unit_price.numeric"]     = "Unit price must be a number.";
        }

        return $messages;
    }



    public function mount(){
        $this->salesmen = User::where([
            ['user_type',0],
            ['designation',2]
        ])->get();
        $this->salesman = auth()->guard('admin')->user()->id;
        $this->bill_book = Helper::generateInvoiceBill($this->salesman);
        $this->order_number = $this->bill_book['number'] ?? '';
        $this->products = Product::all();
        $this->invoice_date = Carbon::now()->format('Y-m-d');
        $this->due_date = Carbon::now()->format('Y-m-d');
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

    public function resetForm()
    {
        $this->customer_name = '';
        $this->invoice_date = Carbon::now()->format('Y-m-d');
        $this->due_date = '';
        $this->source = '';
        $this->reference = '';
        $this->due_amount = 0;
        $this->totalAmount = 0;
        $this->totalInWords = '';

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

    public function printInvoice(){
        // dd($this->all());
        $this->validate();
        DB::beginTransaction();

        try {
            $subtotal = collect($this->rows)->sum(fn($row) => floatval($row['total']));
            $tvaPercentage = floatval(env('TVA_PERCENTAGE'));
            $caPercentage  = floatval(env('CA_PERCENTAGE'));
            $tva = $subtotal * ($tvaPercentage /100);
            $ca = $tva * ($caPercentage /100);
            $ht_amount = $subtotal - ($tva + $ca);
            $due_amount = $subtotal;
             // Save manual_invoice
            $order = Order::create([
                'customer_name' => $this->customer_name,
                'order_number' => $this->order_number,
                'due_date' => $this->due_date,
                'invoice_date' => $this->invoice_date,
                'source' => $this->source,
                'reference' => $this->reference,
                'total_amount' => $subtotal,
                'ht_amount' => $ht_amount,
                'tva_amount' => $tva,
                'ca_amount' => $ca,
                'paid_amount' => 0,
                'due_amount' => $due_amount,
                'invoice_type' => 'manual',
                'status' => 'pending',
                'created_by' =>  $this->salesman
            ]);

             // Save manual_invoice_items
            foreach ($this->rows as $row) {
                OrderItem::create([
                    'order_id' =>  $order->id,
                    'product_id' => $row['product_id'],
                    'quantity' => $row['quantity'],
                    'piece_price' => $row['unit_price'],
                    'total_price' => $row['total'],
                ]);
            }

                DB::commit();
             // Dispatch event to trigger JavaScript print
             $this->dispatch('triggerPrint');
             $this->resetForm();

            }catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->addError('print', 'Failed to save invoice: ' . $e->getMessage());
        }
    }

    public function getPreviewInvoiceNoProperty()
    {
        $year = date('Y');

        $lastInvoice = Invoice::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $lastNumber = $lastInvoice 
            ? (int)substr($lastInvoice->invoice_no, strrpos($lastInvoice->invoice_no, '/') + 1)
            : 0;

        $nextNumber = $lastNumber + 1;

        return str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
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
        $quantity = (int)$this->rows[$index]['quantity'];
        $unitPrice = isset($this->rows[$index]['unit_price']) && is_numeric($this->rows[$index]['unit_price'])
                        ? (float) $this->rows[$index]['unit_price']
                        : 0;

        $this->rows[$index]['total'] = $quantity * $unitPrice;
        $this->calculateTotal(); 
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows); // Re-index the array
    }

    
    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }


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

    // public function printInvoice()
    // {
    //     $this->validate();

    //     // Dispatch event to trigger JavaScript print
    //     $this->dispatch('triggerPrint');
    // }


    public function render()
    {
        return view('livewire.order.add-invoice');
    }
}
