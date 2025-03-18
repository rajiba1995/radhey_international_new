<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Fabric;
use App\Models\CollectionType;
use App\Models\Measurement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ledger;
use App\Models\Catalogue;
use App\Models\SalesmanBilling;
use App\Models\OrderMeasurement;
use App\Models\Payment;
use App\Models\Country;
use App\Models\BusinessType;
use App\Models\UserWhatsapp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Illuminate\Validation\Rule;

class OrderNew extends Component
{
    public $searchTerm = '';
    public $prefix;
    public $searchResults = [];
    public $errorClass = [];
    public $existing_measurements = [];
    // public $collectionsType = [];
    public $collections = [];
    public $errorMessage = [];
    public $activeTab = 1;
    // public $items = [];
    public $FetchProduct = 1;

    public $customers = null;
    public $orders = null;
    public $name, $company_name,$employee_rank, $email, $dob, $customer_id, $whatsapp_no, $phone ,$alternative_phone_number_1,$alternative_phone_number_2;
    public $billing_address,$billing_landmark,$billing_city,$billing_state,$billing_country,$billing_pin;

    public $is_billing_shipping_same;

    public $shipping_address,$shipping_landmark,$shipping_city,$shipping_state,$shipping_country,$shipping_pin;

    //  product 
    public $categories,$subCategories = [], $products = [], $measurements = [];
    public $selectedCategory = null, $selectedSubCategory = null,$searchproduct, $product_id =null,$collection;
    public $paid_amount = 0;
    public $billing_amount = 0;
    public $remaining_amount = 0;
    public $payment_mode = null;
    public $order_number;
    public $bill_id;
    public $bill_book = [];

    // For Catalogue
    public $selectedCatalogue = [];
    public $cataloguePages = [];
    public $catalogues = [];
    public $maxPages = [];
    
    // For ordered by
    public $salesmen;
    public $salesman;

    // for checking salesman billing exists or not
    public $salesmanBill;
    public $selectedFabric = null;
    // public $filteredCountries = [];
    public $search;
    public $mobileLength;
    public $country_code;
    public $country_id;
    public $Business_type;
    public $selectedBusinessType;
    public $countries;

    public $selectedCountryPhone,$selectedCountryWhatsapp,$selectedCountryAlt1,$selectedCountryAlt2;
    public $isWhatsappPhone, $isWhatsappAlt1, $isWhatsappAlt2;
    public $mobileLengthPhone,$mobileLengthWhatsapp,$mobileLengthAlt1,$mobileLengthAlt2;
    public $items = [
        // Example item structure
        // ['measurements' => [['id' => 1, 'title' => 'Measurement 1', 'value' => '']]],
    ];

    public function mount()
{
    $user_id = request()->query('user_id');

    if ($user_id) {
        $customer = User::with(['billingAddress', 'shippingAddress'])
            ->where([
                ['id', $user_id],
                ['user_type', 1],
                ['status', 1]
            ])
            ->first();

        if ($customer) {
            $this->customer_id = $customer->id;
            $this->name = $customer->name;
            $this->company_name = $customer->company_name;
            $this->employee_rank = $customer->employee_rank;
            $this->email = $customer->email;
            $this->dob = $customer->dob;
            $this->phone = $customer->phone;
            $this->whatsapp_no = $customer->whatsapp_no;
            

            // Assign Billing Address (if exists)
            if ($billing = $customer->billingAddress) {
                $this->billing_address = $billing->address;
                $this->billing_landmark = $billing->landmark;
                $this->billing_city = $billing->city;
                $this->billing_state = $billing->state;
                $this->billing_country = $billing->country;
                $this->billing_pin = $billing->zip_code;
            }

            // Assign Shipping Address (if exists)
            if ($shipping = $customer->shippingAddress) {
                $this->shipping_address = $shipping->address;
                $this->shipping_landmark = $shipping->landmark;
                $this->shipping_city = $shipping->city;
                $this->shipping_state = $shipping->state;
                $this->shipping_country = $shipping->country;
                $this->shipping_pin = $shipping->zip_code;
            }

            // Fetch latest order
            $this->orders = Order::with(['customer:id,prefix,name'])
                ->where('customer_id', $customer->id)
                ->latest()
                ->take(1)
                ->get();
        }
    }

    // Load common dropdowns
    $this->customers = User::where([
        ['user_type', 1],
        ['status', 1]
    ])->orderBy('name')->get();

    $this->categories = Category::where('status', 1)->orderBy('title')->get();
    $this->collections = Collection::whereIn('id', [1, 2])->orderBy('title')->get();
    $this->salesmen = User::where([
        ['user_type', 0],
        ['designation', 2]
    ])->get();

    // Auto-select the logged-in Salesman
    $this->salesman = auth()->guard('admin')->user()->id ?? null;

    // Auto-fetch bill book number for the salesman
    if ($this->salesman) {
        $this->changeSalesman($this->salesman);
    }

    // Fetch Salesman Billing if exists
    if (auth()->guard('admin')->check()) {
        $this->salesmanBill = SalesmanBilling::where('salesman_id', auth()->guard('admin')->user()->id)->first();
    }

    // Add initial order item
    $this->addItem();

    foreach ($this->items as $index => $item) {
        if (isset($item['measurements'])) {
            foreach ($item['measurements'] as $measurement) {
                foreach ($this->existing_measurements as $existing) {
                    if (trim($existing['short_code']) === trim($measurement['short_code'])) {
                        $this->items[$index]['get_measurements'][$measurement['id']]['value'] = $existing['value'];
                    }
                }
            }
        }
    }

    $this->Business_type = BusinessType::all();
    $this->selectedBusinessType = null;
    $this->countries = Country::where('status',1)->get();
}

    public function GetCountryDetails($mobileLength, $field)
    {
        switch($field){
            case 'phone':
                $this->mobileLengthPhone = $mobileLength;
                break;

            case 'whatsapp':
                $this->mobileLengthWhatsapp = $mobileLength;
                break;

            case 'alt_phone_1':
                $this->mobileLengthAlt1 = $mobileLength;
                break;
            
            case 'alt_phone_2':
                $this->mobileLengthAlt2 = $mobileLength;
                break;
        }
    }


    public function searchFabrics($index)
    {
    
        // Perform the fabric search
        $productId = $this->items[$index]['product_id'] ?? null;
        $searchTerm = $this->items[$index]['searchTerm'] ?? '';
        
        if (!empty($searchTerm) && !is_null($productId)) {
            $this->items[$index]['searchResults'] = Fabric::join('product_fabrics', 'fabrics.id', '=', 'product_fabrics.fabric_id')
                ->where('product_fabrics.product_id', $productId)
                ->where('fabrics.status', 1)
                ->where('fabrics.title', 'LIKE', "%{$searchTerm}%")
                ->select('fabrics.id', 'fabrics.title')
                ->distinct()
                ->limit(10)
                ->get();
        } else {
            $this->items[$index]['searchResults'] = [];
        }
    
        // After fabric search, restore measurements to avoid overwriting
        //$this->items[$index]['get_measurements'] = $currentMeasurements;
    }
    

    
    public function selectFabric($fabricId, $index)
    {
        // Get the selected fabric details
        $fabric = Fabric::find($fabricId);

        if (!$fabric) {
            return;
        }

        // Set the exact selected fabric name
        $this->items[$index]['searchTerm'] = $fabric->title; 
        $this->items[$index]['selected_fabric'] = $fabric->id;
        
        // Clear search results to hide the dropdown after selection
        $this->items[$index]['searchResults'] = [];
    }

    // Define rules for validation
    public function rules(){
        return[
            'items' => 'required|min:1',     
            'items.*.collection' => 'required|string',
            'items.*.category' => 'required|string',
            'items.*.searchproduct' => 'required|string',
            'items.*.product_id' => 'required|integer',
            'items.*.price' => 'required|numeric|min:1',  
            'items.*.searchTerm' => 'required_if:items.*.collection,1|nullable',
            'order_number' => 'required|string|not_in:000|unique:orders,order_number',
            'items.*.selectedCatalogue' => 'required_if:items.*.collection,1|nullable',
            'items.*.page_number' => 'required_if:items.*.collection,1|nullable'
        ];
    }
   

    public function messages(){
        return [
            'items.required' => 'Please add at least one item to the order.',
             'items.*.category.required' => 'Please select a category for the item.',
             'items.*.searchproduct.required' => 'Please select a product for the item.',
             'items.*.selectedCatalogue.required_if' => 'Please select a catalogue for the item.',
             'items.*.page_number.required_if' => 'Please select a page for the item.',
             'items.*.price.required'  => 'Please enter a price for the item.',
             'items.*.collection.required' =>  'Please enter a collection for the item.',
             'items.*.searchTerm.required_if' =>  'Please enter a Fabric for the item.',
             'order_number.required' => 'Order number is required.',
             'order_number.not_in' => 'Order number "000" is not allowed.',
             'order_number.unique' => 'Order number already exists, please try again.',
             'items.*.get_measurements.*.value.required' => 'Each measurement value is required.',
        ];
    }

    public function FindCustomer($term)
    {
        $this->searchTerm = $term;
        $this->reset('searchResults');

        if (!empty($this->searchTerm)) {
            // Fetch users based on search term
            $users = User::where('user_type', 1)
                ->where('status', 1)
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('phone', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('whatsapp_no', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
                })
                ->take(20)
                ->get();

            // Fetch orders based on search term
            $orders = Order::where('order_number', 'like', '%' . $this->searchTerm . '%')
                ->orWhereHas('customer', function ($query) {
                    $query->where('name', 'like', '%' . $this->searchTerm . '%');
                })
                ->latest()
                ->take(1)
                ->get();

            if ($orders->count()) {
                // Store orders in the class property
                $this->orders = $orders;

                // Extract customer from the first order
                $customerFromOrder = $orders->first()->customer;
                if ($customerFromOrder) {
                    $this->prefix = $customerFromOrder->prefix ?? '';
                    $this->selectedBusinessType = $customerFromOrder->business_type;

                    // Fetch country details using the customer's country_id
                    $country = Country::find($customerFromOrder->country_id);
                    if ($country) {
                        // Append the country information
                        $this->search = $country->title;
                        $this->country_code = $country->country_code;
                        // $this->mobileLength = $country->mobile_length;

                        // Optionally, if you need to display the country code and other country-related data
                        // in the customer form, you can also bind them to the input fields.
                        $this->selectedCountryPhone = $country->country_code;
                    }
                }

                // Add the customer to search results
                $users->prepend($customerFromOrder);
                session()->flash('orders-found', 'Orders found for this customer.');
            } else {
                $this->orders = collect(); // No orders found
                session()->flash('no-orders-found', 'No orders found for this customer.');
            }

            // Remove duplicate users by `id`
            $this->searchResults = $users->unique('id')->values();
        } else {
            // Reset results when the search term is empty
            $this->searchResults = [];
            $this->orders = collect();
            $this->prefix = '';
            $this->search = '';
            $this->country_code = '';
            $this->selectedBusinessType = '';
            $this->mobileLength = '';
        }
    }



    public function addItem()
    {
        $this->items[] = [
            'collection' => '',
            'category' => '',
            'sub_category' => '',
            'searchproduct' => '',
            'selected_fabric' => null,
            'measurements' => [],
            'products' => [],
            'product_id' => null,
            'price' => '',
            'selectedCatalogue' => '',
            'page_number' => '',
            'searchTerm' => '', // Ensure search field is empty
            // 'searchResults' => [], // Clear previous search results
        ];
    }
    


    // updateSalesman
    public function changeSalesman($value){
        $this->bill_book = Helper::generateInvoiceBill($value);
        $this->order_number = $this->bill_book['number'];
        $this->bill_id = $this->bill_book['bill_id'] ?? null;
    }
    



    

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->updateBillingAmount();  // Update billing amount after checking price
    }

    public function GetCategory($value,$index)
    {
        // Reset products, and product_id for the selected item
        $this->items[$index]['product_id'] = null;
        $this->items[$index]['measurements'] = [];
        $this->items[$index]['fabrics'] = [];
        $this->items[$index]['selectedCatalogue'] = null; // Reset catalogue
        // $this->items[$index]['selectedPage'] = null; 
      
            // Fetch categories and products based on the selected collection 
            $this->items[$index]['categories'] = Category::orderBy('title', 'ASC')->where('collection_id', $value)->get();
            $this->items[$index]['products'] = Product::orderBy('name', 'ASC')->where('collection_id', $value)->get();
       
            if ($value == 1) {
                $catalogues = Catalogue::with('catalogueTitle')->get();
                $this->catalogues[$index] = $catalogues->pluck('catalogueTitle.title', 'catalogue_title_id');
        // dd($this->catalogues[$index]);
                // Fetch max page numbers per catalogue
                $this->maxPages[$index] = [];
                foreach ($catalogues as $catalogue) {
                    $this->maxPages[$index][$catalogue->catalogue_title_id] = $catalogue->page_number;
                }
            } else {
                $this->catalogues[$index] = [];
                $this->maxPages[$index] = [];
            }
    }

    public function SelectedCatalogue($catalogueId, $index)
    {
        $this->items[$index]['page_number'] = null; // Reset page number
        $this->maxPages[$index] = []; // Reset max page number

        // Fetch max page number from database
        $maxPage = Catalogue::where('catalogue_title_id', $catalogueId)->value('page_number');

        if ($maxPage) {
            $this->maxPages[$index][$catalogueId] = $maxPage;
        }
    }

    public function validatePageNumber($index)
    {
        if (!isset($this->items[$index]['page_number']) || !isset($this->items[$index]['selectedCatalogue'])) {
            return;
        }
    
        $pageNumber = (int) $this->items[$index]['page_number'];
        $selectedCatalogue = $this->items[$index]['selectedCatalogue'];
    
        // Ensure we get the correct max page for the selected catalogue
        $maxPage = $this->maxPages[$index][$selectedCatalogue] ?? null;
    
        if ($maxPage === null) {
            return; // No catalogue selected, or no max page found
        }
    
        if ($pageNumber < 1 || $pageNumber > $maxPage) {
            $this->addError("items.$index.page_number", "Page number must be between 1 to $maxPage.");
        } else {
            $this->resetErrorBag("items.$index.page_number");
        }
    }
    


    // public function SelectedPage($value , $index){
    //     $this->items[$index]['selectedPage'] = $value;
    //     $this->selectedImage[$index] = Catalogue::where('catalogue_title_id',$this->items[$index]['selectedCatalogue'])
    //                                             ->where('page_number',$value)
    //                                             ->value('image');
    // }
    


    public function CategoryWiseProduct($categoryId, $index)
    {
        // Reset products for the selected item
        $this->items[$index]['products'] = [];
        $this->items[$index]['product_id'] = null;

        if ($categoryId) {
            // Fetch products based on the selected category and collection
            $this->items[$index]['products'] = Product::where('category_id', $categoryId)
                ->where('collection_id', $this->items[$index]['collection']) // Ensure the selected collection is considered
                ->get();
        }
    }



    public function FindProduct($term, $index)
    {
        $collection = $this->items[$index]['collection'];
        $category = $this->items[$index]['category']; 

        if (empty($collection)) {
            session()->flash('errorProduct.' . $index, '🚨 Please select a collection before searching for a product.');
            return;
        }

        if (empty($category)) {
            session()->flash('errorProduct.' . $index, '🚨 Please select a category before searching for a product.');
            return;
        }
    
        // Clear previous products in the current index
        $this->items[$index]['products'] = [];
    
        if (!empty($term)) {
            // Search for products within the specified collection and matching the term
            $this->items[$index]['products'] = Product::where('collection_id', $collection)
                ->where('category_id', $category)
                ->where(function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%')
                          ->orWhere('product_code', 'like', '%' . $term . '%');
                })
                ->get();
        }
    
    }

   

    public function checkproductPrice($value, $index)
    {
        $selectedFabricId = $this->items[$index]['selected_fabric'] ?? null;
        // dd($selectedFabricId);
        if ($selectedFabricId) {
            $fabricData = Fabric::find($selectedFabricId);
            if ($fabricData && floatval($value) < floatval($fabricData->threshold_price)) {
                // Show an error message for threshold price violation
                session()->flash('errorPrice.' . $index, 
                    "🚨 The price for fabric '{$fabricData->title}' cannot be less than its threshold price of {$fabricData->threshold_price}.");
                return;
            }
        }

        // Sanitize and validate input value
        $formattedValue = preg_replace('/[^0-9.]/', '', $value);
        if (is_numeric($formattedValue)) {
            // If valid, format to two decimal places and update
            $this->items[$index]['price'] =$formattedValue;
            session()->forget('errorPrice.' . $index);
        } else {
            // Reset price and show error for invalid input
            $this->items[$index]['price'] = 0;
            session()->flash('errorPrice.' . $index, '🚨 Please enter a valid price.');
        }

        $this->updateBillingAmount(); // Update billing after validation
    }

    public function updateBillingAmount()
    {
        // Recalculate the total billing amount
        $this->billing_amount = array_sum(array_column($this->items, 'price'));
        $this->paid_amount = $this->billing_amount;
        $this->GetRemainingAmount($this->paid_amount);
        return;
    }
    public function GetRemainingAmount($paid_amount)
    {
       // Remove leading zeros if present in the paid amount
        
        // Ensure the values are numeric before performing subtraction
        $billingAmount = floatval($this->billing_amount);
        $paidAmount = floatval($paid_amount);
        $paidAmount = $paidAmount;
        if ($billingAmount > 0) {
            if(empty($paid_amount)){
                $this->paid_amount = 0;
                $this->remaining_amount = $billingAmount;
                return;
            }
            $this->paid_amount = $paidAmount;
            $this->remaining_amount = $billingAmount - $this->paid_amount;
        
            // Check if the remaining amount is negative
            if ($this->remaining_amount < 0) {
                $this->remaining_amount = 0;
                $this->paid_amount = $this->billing_amount;
                session()->flash('errorAmount', '🚨 The paid amount exceeds the billing amount.');
            }
        } else {
            $this->paid_amount = 0;
           
            session()->flash('errorAmount', '🚨 Please add item amount first.');
        }
    }
    
    public function selectProduct($index, $name, $id)
    {
        // Set product details
        $this->items[$index]['searchproduct'] = $name;
        $this->items[$index]['product_id'] = $id;
        $this->items[$index]['products'] = [];

        // Get the measurements available for the selected product
        $this->items[$index]['measurements'] = Measurement::where('product_id', $id)
                                                        ->where('status', 1)
                                                        ->orderBy('position', 'ASC')
                                                        ->get()
                                                        ->toArray();
        
        // Get previous measurements if user ordered this product before
        $this->populatePreviousOrderMeasurements($index, $id);
        // dd($this->populatePreviousOrderMeasurements($index, $id));
        // Clear measurement error message if it was previously set
        session()->forget('measurements_error.' . $index);

        // If no measurements exist, show an error message
        if (empty($this->items[$index]['measurements'])) {
            session()->flash('measurements_error.' . $index, '🚨 Oops! Measurement data not added for this product.');
        }
    }
 


    public function populatePreviousOrderMeasurements($index, $productId)
    {
        $previousOrderItem = OrderItem::where('product_id', $productId)
                                    ->whereHas('order', function ($query) {
                                        $query->where('customer_id', $this->customer_id); // Ensure the same customer
                                    })
                                    ->latest()
                                    ->first(); // Get the most recent order for the product

        if ($previousOrderItem) {
            // Get the measurements related to this previous order's product
            $previousMeasurements = OrderMeasurement::where('order_item_id', $previousOrderItem->id)->get();

            foreach ($previousMeasurements as $previousMeasurement) {
                // Query the Measurement model using the 'measurement_name' field from OrderMeasurement
                $measurement = Measurement::where('title', $previousMeasurement->measurement_name)->first();

                if ($measurement) {
                    // Auto-populate measurement values
                    $this->existing_measurements[] = [
                        // 'short_code' => trim($previousMeasurement->measurement_title_prefix),
                        // 'value' => trim($previousMeasurement->measurement_value)
                        'short_code' => $previousMeasurement->measurement_title_prefix,
                        'value' => $previousMeasurement->measurement_value
                    ];
                }
            }

            // Ensure values are appended into `items[$index]['get_measurements']`
            foreach ($this->items[$index]['measurements'] as &$measurement) {
                foreach ($this->existing_measurements as $existing) {
                    if ($existing['short_code'] == $measurement['short_code']) {
                        // Ensure `get_measurements` array exists
                        if (!isset($this->items[$index]['get_measurements'])) {
                            $this->items[$index]['get_measurements'] = [];
                        }
                        $this->items[$index]['get_measurements'][$measurement['id']]['value'] = $existing['value'];
                    }
                }
            }
        } else {
            // If no previous measurements exist, set empty values
            $this->items[$index]['existing_measurements'] = [];
        }
    }
    public function copyMeasurements($index){
        if ($index > 0) {
            if (!empty($this->items[$index]['copy_previous_measurements'])) {
                // If checkbox is checked, copy measurements from the previous item
                if (!empty($this->items[$index - 1]['get_measurements'])) {
                    $this->items[$index]['get_measurements'] = $this->items[$index - 1]['get_measurements'];
                }
            } else {
                // If checkbox is unchecked, clear measurements
                $this->items[$index]['get_measurements'] = [];
            }
        }
    }

    public function save()
    {   
        // dd($this->all());
        DB::beginTransaction(); // Begin transaction
        
        try{ 
            $this->validate();
            
            // Calculate the total amount
            $total_amount = array_sum(array_column($this->items, 'price'));
            if ($this->paid_amount > $total_amount) {
                session()->flash('error', '🚨 The paid amount cannot exceed the total billing amount.');
                return;
            }
            $this->remaining_amount = $total_amount - $this->paid_amount;

            // Retrieve user details
            $user = User::find($this->customer_id);
             // If customer does not exist, create a new user
            if (!$user) {
                $user = User::create([
                    'prefix' => $this->prefix,
                    'name' => $this->name,
                    'business_type' => $this->selectedBusinessType,
                    'company_name' => $this->company_name,
                    'employee_rank' => $this->employee_rank,
                    'email' => $this->email,
                    'dob' => $this->dob,
                    'country_id' => $this->country_id,
                    'country_code_phone' => $this->selectedCountryPhone,
                    'phone' => $this->phone,
                    'country_code_whatsapp' => $this->selectedCountryWhatsapp,
                    'whatsapp_no' => $this->whatsapp_no,
                    // 'country_code' => $this->country_code,
                    'country_code_alt_1'  => $this->selectedCountryAlt1,
                    'alternative_phone_number_1' => $this->alternative_phone_number_1,
                    'country_code_alt_2'  => $this->selectedCountryAlt2,
                    'alternative_phone_number_2' => $this->alternative_phone_number_2,
                    'user_type' => 1, // Customer
                ]);
             } 
                // Store Billing Address for the new user
             $billingAddress = $user->address()->where('address_type', 1)->first();
             if (!$billingAddress) {
                 $user->address()->create([
                     'address_type' => 1, // Billing address
                     'state' => $this->billing_state,
                     'city' => $this->billing_city,
                     'address' => $this->billing_address,
                     'landmark' => $this->billing_landmark,
                     'country' => $this->billing_country,
                     'zip_code' => $this->billing_pin,
                 ]);
             }
                // Store Shipping Address if applicable
                if (!$this->is_billing_shipping_same) {
                    $shippingAddress = $user->address()->where('address_type', 2)->first();
                    if (!$shippingAddress) {
                        $user->address()->create([
                            'address_type' => 2, // Shipping address
                            'state' => $this->shipping_state,
                            'city' => $this->shipping_city,
                            'address' => $this->shipping_address,
                            'landmark' => $this->shipping_landmark,
                            'country' => $this->shipping_country,
                            'zip_code' => $this->shipping_pin,
                        ]);
                    }
                }


            if ($user) {

                $user->update([
                    'prefix' => $this->prefix,
                    'name' => $this->name,
                    'business_type' => $this->selectedBusinessType,
                    'company_name' => $this->company_name,
                    'employee_rank' => $this->employee_rank,
                    'email' => $this->email,
                    'dob' => $this->dob,
                    'country_id' => $this->country_id,
                    'country_code_phone' => $this->selectedCountryPhone,
                    'phone' => $this->phone,
                    'country_code_whatsapp' => $this->selectedCountryWhatsapp,
                    'whatsapp_no' => $this->whatsapp_no,
                    'country_code_alt_1'  => $this->selectedCountryAlt1,
                    'alternative_phone_number_1' => $this->alternative_phone_number_1,
                    'country_code_alt_2'  => $this->selectedCountryAlt2,
                    'alternative_phone_number_2' => $this->alternative_phone_number_2,
                    'user_type' => 1, // Customer
                ]);
                // Retrieve existing billing address
                $existingBillingAddress = $user->address()->where('address_type', 1)->first();
                // dd($existingBillingAddress);
                // Check and update billing address if needed
                $billingAddressUpdated = false;
                if ($existingBillingAddress) {
                    if (
                        $existingBillingAddress->state !== $this->billing_state ||
                        $existingBillingAddress->city !== $this->billing_city ||
                        $existingBillingAddress->address !== $this->billing_address
                    ) {
                        $existingBillingAddress->update([
                            'state' => $this->billing_state,
                            'city' => $this->billing_city,
                            'address' => $this->billing_address,
                            'landmark' => $this->billing_landmark,
                            'country' => $this->billing_country,
                            'zip_code' => $this->billing_pin,
                        ]);
                        $billingAddressUpdated = true;
                    }
                } else {
                    // Create new billing address if none exists
                    $user->address()->create([
                        'address_type' => 1, // Billing address
                        'state' => $this->billing_state,
                        'city' => $this->billing_city,
                        'address' => $this->billing_address,
                        'landmark' => $this->billing_landmark,
                        'country' => $this->billing_country,
                        'zip_code' => $this->billing_pin,
                    ]);
                    $billingAddressUpdated = true;
                }

                // Perform similar logic for shipping address
                $existingShippingAddress = $user->address()->where('address_type', 2)->first();
                if ($this->is_billing_shipping_same) {
                    if ($existingShippingAddress) {
                        $existingShippingAddress->update([
                            'state' => $this->billing_state,
                            'city' => $this->billing_city,
                            'address' => $this->billing_address,
                            'landmark' => $this->billing_landmark,
                            'country' => $this->billing_country,
                            'zip_code' => $this->billing_pin,
                        ]);
                    } else {
                        $user->address()->create([
                            'address_type' => 2, // Shipping address
                            'state' => $this->billing_state,
                            'city' => $this->billing_city,
                            'address' => $this->billing_address,
                            'landmark' => $this->billing_landmark,
                            'country' => $this->billing_country,
                            'zip_code' => $this->billing_pin,
                        ]);
                    }
                } else {
                    if ($existingShippingAddress) {
                        if (
                            $existingShippingAddress->state !== $this->shipping_state ||
                            $existingShippingAddress->city !== $this->shipping_city ||
                            $existingShippingAddress->address !== $this->shipping_address
                        ) {
                            $existingShippingAddress->update([
                                'state' => $this->shipping_state,
                                'city' => $this->shipping_city,
                                'address' => $this->shipping_address,
                                'landmark' => $this->shipping_landmark,
                                'country' => $this->shipping_country,
                                'zip_code' => $this->shipping_pin,
                            ]);
                        }
                    } else {
                        $user->address()->create([
                            'address_type' => 2, // Shipping address
                            'state' => $this->shipping_state,
                            'city' => $this->shipping_city,
                            'address' => $this->shipping_address,
                            'landmark' => $this->shipping_landmark,
                            'country' => $this->shipping_country,
                            'zip_code' => $this->shipping_pin,
                        ]);
                    }
                }
            }
            
            
            if (!empty($this->order_number)) {
                $order_number = $this->order_number;
            } else {
                $invoiceData = Helper::generateInvoiceBill();
                $order_number =  $invoiceData['number'];
            }

            // Create the order
            $order = new Order();
            $order->order_number = $order_number;
            $order->customer_id = $user->id;
            $order->prefix = $this->prefix;
            $order->customer_name = $this->name;
            $order->customer_email = $this->email;
            $order->billing_address = $this->billing_address . ', ' . $this->billing_landmark . ', ' . $this->billing_city . ', ' . $this->billing_state . ', ' . $this->billing_country . ' - ' . $this->billing_pin;

            if ($this->is_billing_shipping_same) {
                $order->shipping_address = $order->billing_address;
            } else {
                $order->shipping_address = $this->shipping_address . ', ' . $this->shipping_landmark . ', ' . $this->shipping_city . ', ' . $this->shipping_state . ', ' . $this->shipping_country . ' - ' . $this->shipping_pin;
            }

            $order->total_amount = $total_amount;
            $order->last_payment_date = date('Y-m-d H:i:s');
            $order->created_by = (int) $this->salesman; // Explicitly cast to integer

            $order->save();

            $update_bill_book = SalesmanBilling::where('id',$this->bill_id)->first();
            if($update_bill_book){
                $update_bill_book->no_of_used = $update_bill_book->no_of_used +1;
                $update_bill_book->save();
            }

            // Save order items and measurements
            foreach ($this->items as $k => $item) {
                $collection_data = Collection::find($item['collection']);
                $category_data = Category::find($item['category']);
                $sub_category_data = SubCategory::find($item['sub_category']);
                $fabric_data = Fabric::find($item['selected_fabric']);

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->catalogue_id = $item['selectedCatalogue'] ?? null;
                $orderItem->cat_page_number = $item['page_number'] ?? null;
                $orderItem->product_id = $item['product_id'];
                $orderItem->collection = $collection_data ? $collection_data->id : "";
                $orderItem->category = $category_data ? $category_data->id : "";
                // $orderItem->sub_category = $sub_category_data ? $sub_category_data->title : "";
                $orderItem->product_name = $item['searchproduct'];
                $orderItem->total_price = $item['price'];
                $orderItem->piece_price = $item['price'];
                $orderItem->quantity = 1;
                $orderItem->fabrics = $fabric_data ? $fabric_data->id : "";
                $orderItem->save();
                if (isset($item['get_measurements']) && count($item['get_measurements']) > 0) {
                    $get_all_measurment_field = [];
                    $get_all_field_measurment_id = [];
                    foreach ($item['get_measurements'] as $mindex => $measurement) {
                        $get_all_field_measurment_id[]= $mindex;
                        $measurement_data = Measurement::find($mindex);
                        $get_all_measurment_field = Measurement::where('product_id', $measurement_data->product_id)->pluck('id')->toArray();
                        $orderMeasurement = new OrderMeasurement();
                        $orderMeasurement->order_item_id = $orderItem->id;
                        $orderMeasurement->measurement_name = $measurement_data ? $measurement_data->title : "";
                        $orderMeasurement->measurement_title_prefix = $measurement_data ? $measurement_data->short_code : "";
                        $orderMeasurement->measurement_value = $measurement['value'];
                        $orderMeasurement->save();
                    }
                    $missing_measurements = array_diff($get_all_measurment_field, $get_all_field_measurment_id);

                    if (!empty($missing_measurements)) {
                        session()->flash('measurements_error.' . $k, '🚨 Oops! All measurement data should be mandatory, or all fields should be filled with 0.');
                        return;
                    }
                    
                }else{
                    session()->flash('measurements_error.' . $k, '🚨 Oops! All measurement data should be mandatory, or all fields should be filled with 0.');
                    return;
                }
            }

            // Store WhatsApp details if the flags are set
                if ($this->isWhatsappPhone) {
                    UserWhatsapp::create([
                        'user_id' => $user->id,
                        'country_code' => $this->selectedCountryPhone,
                        'whatsapp_number' => $this->phone,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                if ($this->isWhatsappAlt1) {
                    UserWhatsapp::create([
                        'user_id' => $user->id,
                        'country_code' => $this->selectedCountryAlt1,
                        'whatsapp_number' => $this->alternative_phone_number_1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                if ($this->isWhatsappAlt2) {
                    UserWhatsapp::create([
                        'user_id' => $user->id,
                        'country_code' => $this->selectedCountryAlt2,
                        'whatsapp_number' => $this->alternative_phone_number_2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

            DB::commit();

            session()->flash('success', 'Order has been generated successfully.');
            return redirect()->route('admin.order.index');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            \Log::error('Error saving order: ' . $e->getMessage());
            dd($e->getMessage());
            session()->flash('error', '🚨 Something went wrong. The operation has been rolled back.');
        }
    }


    public function resetForm()
    {
        // Reset all the form properties
        $this->reset([
            'name',
            'company_name',
            'employee_rank',
            'email',
            'dob',
            'phone',
            'whatsapp_no',
           
        ]);
    }

    public function selectCustomer($customerId)
    {
        $this->resetForm(); // Reset form to default values

        $customer = User::find($customerId);
        // dd($customer);
        if ($customer) {
            // Populate customer details
            $this->customer_id = $customer->id;
            $this->prefix = $customer->prefix;
            $this->name = $customer->name;
            $this->company_name = $customer->company_name;
            $this->employee_rank = $customer->employee_rank;
            $this->email = $customer->email;
            $this->dob = $customer->dob;
            $this->phone = $customer->phone;
            $this->whatsapp_no = $customer->whatsapp_no;

            // Fetch billing address (address_type = 1)
            $billingAddress = $customer->address()->where('address_type', 1)->first();
            $this->populateAddress('billing', $billingAddress);

            // Fetch shipping address (address_type = 2)
            $shippingAddress = $customer->address()->where('address_type', 2)->first();
            $this->populateAddress('shipping', $shippingAddress);
        }

        // Clear search results after selection
        $this->searchResults = [];
        $this->searchTerm = '';
    }
   
    public function toggleShippingAddress()
    {
        // When the checkbox is checked
        if ($this->is_billing_shipping_same) {
            // Copy billing address to shipping address
            $this->shipping_address = $this->billing_address;
            $this->shipping_landmark = $this->billing_landmark;
            $this->shipping_city = $this->billing_city;
            $this->shipping_state = $this->billing_state;
            $this->shipping_country = $this->billing_country;
            $this->shipping_pin = $this->billing_pin;
        } else {
            // Reset shipping address fields
            $this->shipping_address = '';
            $this->shipping_landmark = '';
            $this->shipping_city = '';
            $this->shipping_state = '';
            $this->shipping_country = '';
            $this->shipping_pin = '';
        }
        $this->TabChange($this->activeTab);
    }

    public function TabChange($value)
    {
        // dd($this->all());
        // dd($this->errorClass, $this->errorMessage);

        // Initialize or reset error classes and messages
        $this->errorClass = [];
        $this->errorMessage = [];
        if ($value== 1) {
            $this->activeTab = $value;
        }
        if ($value > 1) {

            // Validate Business type
            if(empty($this->selectedBusinessType)){
                $this->errorClass['selectedBusinessType'] = 'border-danger';
                $this->errorMessage['selectedBusinessType'] = 'Please select your business type';

            }else{
                $this->errorClass['selectedBusinessType'] = null;
                $this->errorMessage['selectedBusinessType'] = null;
            }

            // validate country
            // if(empty($this->search)){
            //     $this->errorClass['search'] = 'border-danger';
            //     $this->errorMessage['search'] = 'Please Search a country first';
            // }else{
            //     $this->errorClass['search']  = null;
            //     $this->errorMessage['search']  = null;
            // }

            // validate Salesman
            if(empty($this->salesman)){
                $this->errorClass['salesman'] = 'border-danger';
                $this->errorMessage['salesman'] = 'Please select a salesman first';
            }else{
                $this->errorClass['salesman']  = null;
                $this->errorMessage['salesman']  = null;
            }

            // validate order number
            if(($this->order_number == 000)){
                $this->errorClass['order_number'] = 'border-danger';
                $this->errorMessage['order_number'] = 'Please Choose a another salesman';
            }else{
                $this->errorClass['order_number']  = null;
                $this->errorMessage['order_number']  = null;
            }

            // Validate prefix
            if (empty($this->prefix)) {
                $this->errorClass['prefix'] = 'border-danger';
                $this->errorMessage['prefix'] = 'Please choose a prefix';
            } else {
                $this->errorClass['prefix'] = null;
                $this->errorMessage['prefix'] = null;
            }

            //validate name
            if (empty($this->name)) {
                $this->errorClass['name'] = 'border-danger';
                $this->errorMessage['name'] = 'Please enter customer name';
            } else {
                $this->errorClass['name'] = null;
                $this->errorMessage['name'] = null;
            }
    
            // Validate Email
           
    
            // Validate Date of Birth
            if (empty($this->dob)) {
                $this->errorClass['dob'] = 'border-danger';
                $this->errorMessage['dob'] = 'Please enter customer date of birth';
            } else {
                $this->errorClass['dob'] = null;
                $this->errorMessage['dob'] = null;
            }
    
           // Validate Phone Number
            if (empty($this->phone)) {
                $this->errorClass['phone'] = 'border-danger';
                $this->errorMessage['phone'] = 'Please enter customer phone number';
            } elseif (!preg_match('/^\d{'. $this->mobileLengthPhone .'}$/', $this->phone)) {
                $this->errorClass['phone'] = 'border-danger';
                $this->errorMessage['phone'] = "Phone number must be exactly ".$this->mobileLengthPhone." digits";
            } else {
                $this->errorClass['phone'] = null;
                $this->errorMessage['phone'] = null;
            }

            // Validate WhatsApp Number
            if (empty($this->whatsapp_no)) {
                $this->errorClass['whatsapp_no'] = 'border-danger';
                $this->errorMessage['whatsapp_no'] = 'Please enter WhatsApp number';
            } elseif (!preg_match('/^\d{'. $this->mobileLengthWhatsapp .'}$/', $this->whatsapp_no)) {
                $this->errorClass['whatsapp_no'] = 'border-danger';
                $this->errorMessage['whatsapp_no'] = 'WhatsApp number must be exactly ' . $this->mobileLengthWhatsapp . ' digits';
            } else {
                $this->errorClass['whatsapp_no'] = null;
                $this->errorMessage['whatsapp_no'] = null;
            }

            // Validate Alternative Phone Number 1
            if (!empty($this->alternative_phone_number_1)) {
                if (!preg_match('/^\d{'. $this->mobileLengthAlt1 .'}$/', $this->alternative_phone_number_1)) {
                    $this->errorClass['alternative_phone_number_1'] = 'border-danger';
                    $this->errorMessage['alternative_phone_number_1'] = 'Alternative number 1 must be exactly ' . $this->mobileLengthAlt1 . ' digits';
                } else {
                    $this->errorClass['alternative_phone_number_1'] = null;
                    $this->errorMessage['alternative_phone_number_1'] = null;
                }
            }

            // Validate Alternative Phone Number 2
            if (!empty($this->alternative_phone_number_2)) {
                if (!preg_match('/^\d{'. $this->mobileLengthAlt2 .'}$/', $this->alternative_phone_number_2)) {
                    $this->errorClass['alternative_phone_number_2'] = 'border-danger';
                    $this->errorMessage['alternative_phone_number_2'] = 'Alternative number 2 must be exactly ' . $this->mobileLengthAlt2 . ' digits';
                } else {
                    $this->errorClass['alternative_phone_number_2'] = null;
                    $this->errorMessage['alternative_phone_number_2'] = null;
                }
            }

    
            // Validate Billing Information
            if (empty($this->billing_address)) {
                $this->errorClass['billing_address'] = 'border-danger';
                $this->errorMessage['billing_address'] = 'Please enter billing address';
            } else {
                $this->errorClass['billing_address'] = null;
                $this->errorMessage['billing_address'] = null;
            }
    
            if (empty($this->billing_city)) {
                $this->errorClass['billing_city'] = 'border-danger';
                $this->errorMessage['billing_city'] = 'Please enter billing city';
            } else {
                $this->errorClass['billing_city'] = null;
                $this->errorMessage['billing_city'] = null;
            }
    
           
    
            if (empty($this->billing_country)) {
                $this->errorClass['billing_country'] = 'border-danger';
                $this->errorMessage['billing_country'] = 'Please enter billing country';
            } else {
                $this->errorClass['billing_country'] = null;
                $this->errorMessage['billing_country'] = null;
            }
            
            
            // Validate Shipping Information
            if (empty($this->shipping_address)) {
                $this->errorClass['shipping_address'] = 'border-danger';
                $this->errorMessage['shipping_address'] = 'Please enter shipping address';
            } else {
                $this->errorClass['shipping_address'] = null;
                $this->errorMessage['shipping_address'] = null;
            }
    
            if (empty($this->shipping_city)) {
                $this->errorClass['shipping_city'] = 'border-danger';
                $this->errorMessage['shipping_city'] = 'Please enter shipping city';
            } else {
                $this->errorClass['shipping_city'] = null;
                $this->errorMessage['shipping_city'] = null;
            }
    
    
            if (empty($this->shipping_country)) {
                $this->errorClass['shipping_country'] = 'border-danger';
                $this->errorMessage['shipping_country'] = 'Please enter shipping country';
            } else {
                $this->errorClass['shipping_country'] = null;
                $this->errorMessage['shipping_country'] = null;
            }
    
        
            
    
           
            // Check if both errorClass and errorMessage arrays are empty

            $errorClassNull = empty(array_filter($this->errorClass, function($val) {
                return !is_null($val);
            }));
            // If all values are null, set activeTab to the value passed
            if ($errorClassNull) {
                $this->activeTab = $value;
            }
             // Return the error classes and messages
            return [$this->errorClass, $this->errorMessage];
        }
       
    }
    private function populateAddress($type, $address)
    {
        // dd($address);
        if ($address) {
            $this->{$type . '_address'} = $address->address;
            $this->{$type . '_landmark'} = $address->landmark;
            $this->{$type . '_city'} = $address->city;
            $this->{$type . '_state'} = $address->state;
            $this->{$type . '_country'} = $address->country;
            $this->{$type . '_pin'} = $address->zip_code;
        } else {
            $this->{$type . '_address'} = null;
            $this->{$type . '_landmark'} = null;
            $this->{$type . '_city'} = null;
            $this->{$type . '_state'} = null;
            $this->{$type . '_country'} = null;
            $this->{$type . '_pin'} = null;
        }
    }


    public function render()
    {
     
        return view('livewire.order.order-new', [
            'categories' => $this->categories,
        ]);
    }
    
}
