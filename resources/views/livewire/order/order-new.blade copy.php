
<div class="container-fluid px-2 px-md-4">
    <div class="card my-4">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="m-0">Place Order</h4>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($activeTab==1 && $salesmanBill == null)
                    <div class="badge bg-primary">
                        <a href="{{ route('salesman.index') }}"> <strong>Error:</strong> Please add a bill for this user before placing the order.</a>
                    </div>
                @endif
                @if($activeTab==1)
                <a href="{{route('admin.order.index')}}" class="btn btn-cta"> <i class="material-icons text-white">chevron_left</i> 
                    Back 
                </a>
                @endif
            </div>
        </div>

        <div class="card-body" id="sales_order_data">
            <form wire:submit.prevent="save">
                <div class="{{$activeTab==1?"d-block":"d-none"}}" id="tab1">
                    <div class="row d-flex justify-content-end align-items-center mb-3">
                        <!-- Search Label and Select2 -->
                        <div class="col-12 col-md-6">
                            <div class="d-flex justify-content-between">
                                <!-- Search Label -->
                                <label for="searchCustomer" class="form-label mb-0">Search By Order Id</label>
                            </div>
        
                            <div class="position-relative">
                                <input type="text" wire:keyup="FindCustomer($event.target.value)" 
                                    wire:model="searchTerm" 
                                    class="form-control form-control-sm border border-1 customer_input" 
                                    placeholder="Search by customer details">
                                
                                @if(!empty($searchResults))
                                    <div id="fetch_customer_details" class="dropdown-menu show w-100" style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($searchResults as $customer)
                                            <button class="dropdown-item" type="button" wire:click="selectCustomer({{ $customer->id }})">
                                                <img src="{{ $customer->profile_image ? asset($customer->profile_image) : asset('assets/img/user.png') }}" alt=""> {{ $customer->name }}  ({{ $customer->phone }}) 
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                        
                     <!-- Order Customer Fields... -->
                    @if(session()->has('orders-found') && $orders->count() > 0)
                        <div class="alert alert-success mt-3">
                            {{ session('orders-found') }}
                        </div>
                    @endif

                    @if (session()->has('no-orders-found'))
                        <div class="alert alert-danger mt-3">
                            {{ session('no-orders-found') }}
                        </div>
                    @endif
                    @if(!empty($orders) && $orders->count())
                        <h5 class="mt-4">Previous Order Details</h5>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>Order Number</th>
                                    <th>Customer Name</th>
                                    <th>Billing Amount</th>
                                    <th>Remaining Amount</th>
                                    <th>Billing Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr class="text-center">
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->customer->name }}</td>
                                        <td>{{ $order->total_amount }}</td>
                                        <td>{{ $order->remaining_amount }}</td>
                                        <td>{{ $order->last_payment_date }}</td>
                                        <td><a href="{{route('admin.order.invoice',$order->id)}}" class="btn btn-sm btn-outline-info" target="_blank">Invoice</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                        
                    <!-- Customer Details -->
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                    </div>
                    <!-- Customer Details -->
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="name" id="name" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['name'] ?? '' }}" placeholder="Enter customer name">
                            @if(isset($errorMessage['name']))
                                <div class="text-danger">{{ $errorMessage['name'] }}</div>
                            @endif
                        </div>
    
                        <div class="mb-3 col-md-4">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" wire:model="company_name" id="company_name" class="form-control form-control-sm border border-1 p-2" placeholder="Enter company name">
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="employee_rank" class="form-label"> Rank</label>
                            <input type="text" wire:model="employee_rank" id="employee_rank" class="form-control form-control-sm border border-1 p-2" placeholder="Enter rank">
                        </div>
    
                        <div class="mb-3 col-md-3">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" wire:model="email" id="email" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['email'] ?? '' }}" placeholder="Enter email">
                            @if(isset($errorMessage['email']))
                                <div class="text-danger">{{ $errorMessage['email'] }}</div>
                            @endif
                        </div>
    
                        <div class="mb-3 col-md-3">
                            <label for="dob" class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                            <input type="date" wire:model="dob" id="dob" max="{{date('Y-m-d')}}" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['dob'] ?? '' }}">
                            @if(isset($errorMessage['dob']))
                                <div class="text-danger">{{ $errorMessage['dob'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" wire:model="phone" id="phone" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['phone'] ?? '' }}" placeholder="Enter phone number">
                            @if(isset($errorMessage['phone']))
                                <div class="text-danger">{{ $errorMessage['phone'] }}</div>
                            @endif
                        </div>
    
                        <div class="mb-3 col-md-3">
                            <label for="whatsapp_no" class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                            <input type="text" wire:model="whatsapp_no" id="whatsapp_no" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['whatsapp_no'] ?? '' }}" placeholder="Enter whatsapp number"  @if($whatsapp_no)disabled @endif>
                            @if(isset($errorMessage['whatsapp_no']))
                                <div class="text-danger">{{ $errorMessage['whatsapp_no'] }}</div>
                            @endif
                            <div class="form-check ps-0">
                                <input type="checkbox" id="is_wa_same" wire:change="SameAsMobile" class="form-check-input" value="0" @if($is_wa_same) checked @endif>
                                <label for="is_wa_same" class="form-check-label ms-2">Same as Phone Number</label>
                            </div>
                            
                        </div>
                    </div>
                    
                    {{-- Billing Address --}}
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <h6 class="badge bg-danger custom_danger_badge">Billing Address</h6>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="billing_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                            <textarea wire:model="billing_address" id="billing_address" cols="30" rows="3" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_address'] ?? '' }}" placeholder="Enter billing address" ></textarea>
                            @if(isset($errorMessage['billing_address']))
                                <div class="text-danger">{{ $errorMessage['billing_address'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_landmark" class="form-label">Landmark</label>
                            <input type="text" wire:model="billing_landmark" id="billing_landmark" class="form-control form-control-sm border border-1 p-2" placeholder="Enter landmark">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_city" id="billing_city" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_city'] ?? '' }}" placeholder="Enter city">
                            @if(isset($errorMessage['billing_city']))
                                <div class="text-danger">{{ $errorMessage['billing_city'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_state" class="form-label">State</label>
                            <input type="text" wire:model="billing_state" id="billing_state" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_state'] ?? '' }}" placeholder="Enter state">
                            @if(isset($errorMessage['billing_state']))
                                <div class="text-danger">{{ $errorMessage['billing_state'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_country" id="billing_country" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_country'] ?? '' }}" placeholder="Enter country">
                            @if(isset($errorMessage['billing_country']))
                                <div class="text-danger">{{ $errorMessage['billing_country'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_pin" class="form-label">Zip Code </label>
                            <input type="number" wire:model="billing_pin" id="billing_pin" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_pin'] ?? '' }}" placeholder="Enter PIN">
                            @if(isset($errorMessage['billing_pin']))
                                <div class="text-danger">{{ $errorMessage['billing_pin'] }}</div>
                            @endif
                        </div>
                    </div>
                   <div class="d-flex justify-content-between mt-4">
                        <h6 class="badge bg-danger custom_danger_badge">Shipping Address</h6>
                        <div class="form-check">
                            <input type="checkbox"  wire:change="toggleShippingAddress" wire:model="is_billing_shipping_same" id="isBillingShippingSame" class="form-check-input" @if ($is_billing_shipping_same) checked @endif>
                            <label for="isBillingShippingSame" class="form-check-label"><span class="badge bg-secondary">Shipping address same as billing</span></label>
                        </div>
                    </div>
                    
                    
                    {{-- Shipping Address Panel --}}
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="shipping_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                            <textarea  wire:model="shipping_address" id="shipping_address" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_address'] ?? '' }}" placeholder="Enter shipping address" @if ($shipping_address)
                                disabled
                            @endif></textarea>
                            @if(isset($errorMessage['shipping_address']))
                                <div class="text-danger">{{ $errorMessage['shipping_address'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_landmark" class="form-label">Landmark</label>
                            <input type="text" wire:model="shipping_landmark" id="shipping_landmark" class="form-control form-control-sm border border-1 p-2" placeholder="Enter landmark" @if ($shipping_landmark)
                                disabled
                            @endif>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_city" id="shipping_city" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_city'] ?? '' }}" placeholder="Enter city" @if ($shipping_city)
                                disabled
                            @endif>
                            @if(isset($errorMessage['shipping_city']))
                                <div class="text-danger">{{ $errorMessage['shipping_city'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_state" class="form-label">State </label>
                            <input type="text" wire:model="shipping_state" id="shipping_state" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_state'] ?? '' }}" placeholder="Enter state" @if ($shipping_state)
                                disabled
                            @endif>
                            @if(isset($errorMessage['shipping_state']))
                                <div class="text-danger">{{ $errorMessage['shipping_state'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_country" id="shipping_country" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_country'] ?? '' }}" placeholder="Enter country" @if ($shipping_country)
                                disabled
                            @endif>
                            @if(isset($errorMessage['shipping_country']))
                                <div class="text-danger">{{ $errorMessage['shipping_country'] }}</div>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_pin" class="form-label">Zip Code </label>
                            <input type="number" wire:model="shipping_pin" id="shipping_pin" class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_pin'] ?? '' }}" placeholder="Enter PIN" @if ($shipping_pin)
                                disabled
                            @endif>
                            @if(isset($errorMessage['shipping_pin']))
                                <div class="text-danger">{{ $errorMessage['shipping_pin'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="{{$activeTab==2?"d-block":"d-none"}}" id="tab2">
                    <div class="row">
                        <div class="col-12 col-md-12 mb-2 mb-md-0">
                            <h6 class="badge bg-danger custom_danger_badge">Product Information</h6>
                        </div>
                    </div>
                
                    <!-- Loop through items -->
                    {{-- {{dd($items)}} --}}
                    @foreach($items as $index => $item)
                        <div class="row align-items-center mt-3 mb-5">
                            <!-- Collection  -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Collection </strong><span class="text-danger">*</span></label>
                               <select wire:model="items.{{ $index }}.collection" wire:change="GetCategory($event.target.value, {{ $index }})" class="form-control border border-2 p-2 form-control-sm @error('items.'.$index.'.collection') border-danger @enderror">
                                    <option value="" selected hidden>Select collection</option>
                                    @foreach($collections as $citems)
                                        <option value="{{ $citems->id }}">{{ ucwords($citems->title) }} @if($citems->short_code)({{ $citems->short_code }})@endif</option>
                                    @endforeach
                                </select>
                                @error("items.$index.collection")
                                    <div class='text-danger'>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Category</strong> <span class="text-danger">*</span></label>
                                <select wire:model="items.{{ $index }}.category" class="form-select form-control-sm border border-1 @error('items.'.$index.'.category') border-danger @enderror" wire:change="CategoryWiseProduct($event.target.value, {{ $index }})">
                                    <option value="" selected hidden>Select Category</option>
                                    @if (isset($items[$index]['categories']) && count($items[$index]['categories']) > 0)
                                        @foreach ($items[$index]['categories'] as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['title'] }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No categories available</option>
                                    @endif
                                </select>
                                @error("items.$index.category")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product -->
                            @if(isset($items[$index]['collection']) && $items[$index]['collection'] == 1)
                                <div class="mb-3 col-md-4">
                            @else
                                <div class="mb-3 col-md-8">
                            @endif
                                <label class="form-label"><strong>Product</strong></label>
                                <input type="text" wire:keyup="FindProduct($event.target.value, {{ $index }})" wire:model="items.{{ $index }}.searchproduct" class="form-control form-control-sm border border-1 customer_input @error('items.'.$index.'.searchproduct') border-danger @enderror" placeholder="Enter product name">
                                @if (session()->has('errorProduct.' . $index)) 
                                    <p class="text-danger">{{ session('errorProduct.' . $index) }}</p>
                                @endif
                                @if(isset($items[$index]['products']) && count($items[$index]['products']) > 0)
                                    <div id="fetch_customer_details" class="dropdown-menu show w-25" style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($items[$index]['products'] as $product)
                                            <button class="dropdown-item" type="button" wire:click='selectProduct({{ $index }}, "{{ $product->name }}", {{ $product->id }})'>
                                                <img src="{{ $product->product_image ? asset($product->product_image) : asset('assets/img/cubes.png') }}" alt=""> {{ $product->name }}({{ $product->product_code }})
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                                @error("items.$index.searchproduct")
                                  <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Catalogue -->
                            @if(isset($items[$index]['collection']) && $items[$index]['collection'] == 1)
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Catalogue</strong></label>
                                <select wire:model="items.{{ $index }}.selectedCatalogue" class="form-control form-control-sm border border-1 @error('items.'.$index.'.selectedCatalogue') border-danger @enderror" wire:change="SelectedCatalogue($event.target.value, {{ $index }})">
                                    <option value="" selected hidden>Select Catalogue</option>
                                    @foreach($catalogues[$index] ?? [] as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}
                                            @if(isset($maxPages[$index][$id]))
                                              (1 - {{ $maxPages[$index][$id] }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error("items." .$index. ".selectedCatalogue") 
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror 
                            </div>
                            
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Page Number</strong></label>
                                <input type="number" wire:model="items.{{$index}}.page_number"  wire:keyup="validatePageNumber({{ $index }})" id="page_number" class="form-control form-control-sm border border-2 @error('items.'.$index.'.page_number') border-danger @enderror"  min="1" 
                                 max="{{ isset($items[$index]['selectedCatalogue']) && isset($maxPages[$index][$items[$index]['selectedCatalogue']]) ? $maxPages[$index][$items[$index]['selectedCatalogue']] : '' }}"
                                >
                                @error("items.$index.page_number") 
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            @endif
                            <!-- Catalogue end -->
                            {{-- Append Measurements data --}}
                            @if(isset($this->items[$index]['product_id']) && $items[$index]['collection'] == 1)
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2 mb-md-0 measurement_div">
                                        <h6 class="badge bg-danger custom_success_badge">Measurements</h6>
                                        <div class="row">
                                            @if(isset($items[$index]['measurements']) && count($items[$index]['measurements']) > 0)
                                                @foreach ($items[$index]['measurements'] as $measurement)
                                                    <div class="col-md-3">
                                                        {{-- {{dd($measurement)}} --}}
                                                        <label>{{ $measurement['title'] }} <strong>[{{$measurement['short_code']}}]</strong></label>
                                                        <input type="hidden"  wire:model="items.{{ $index }}.get_measurements.{{ $measurement['id'] }}.title" value="{{ $measurement['title'] }}">
                                                        <input 
                                                            type="text" 
                                                            class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                            wire:model="items.{{ $index }}.get_measurements.{{ $measurement['id'] }}.value">
                                                        @error('items.' . $index . '.get_measurements.' .$measurement['id']) 
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if (session()->has('measurements_error.' . $index)) 
                                                <div class="alert alert-danger">
                                                    {{ session('measurements_error.' . $index) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                                        <h6 class="badge bg-danger custom_success_badge dark-badge">Fabrics</h6>

                                        <div class="row mx-2 fabric-item">
                                            @if(isset($items[$index]['fabrics']) && count($items[$index]['fabrics']) > 0)
                                                <div class="col-lg-4 col-md-6 col-sm-12"> {{-- First column starts --}}
                                                    @foreach ($items[$index]['fabrics'] as $fabric)
                                                        @if ($loop->index % 12 == 0 && $loop->index != 0)
                                                            </div><div class="col-lg-4 col-md-6 col-sm-12"> {{-- Close previous column and start a new one --}}
                                                        @endif
                                                        <div class="radio">
                                                            <input 
                                                                type="radio" 
                                                                class="radio-input" 
                                                                name="fabric_{{ $index }}" 
                                                                id="fabric_{{ $index }}_{{ $fabric->id }}" 
                                                                wire:model="items.{{ $index }}.selected_fabric" 
                                                                value="{{ $fabric->id }}"
                                                            />
                                                            <label for="fabric_{{ $index }}_{{ $fabric->id }}" class="radio-label">
                                                                <span class="radio-border"></span> 
                                                                {{ $fabric->title }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div> {{-- Close the last column --}}
                                            @else
                                                <p>No fabrics available for this item.</p>
                                            @endif
                                        
                                            @if (session()->has('fabrics_error.' . $index)) 
                                                <div class="alert alert-danger">
                                                    {{ session('fabrics_error.' . $index) }}
                                                </div>
                                            @endif
                                        </div> {{-- Close the row --}}
                                    </div>
                                </div>
                            @endif
                            <div class="row justify-content-end">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label"><strong>Price</strong></label>
                                    <input type="text" wire:keyup="checkproductPrice($event.target.value, {{ $index }})" wire:model="items.{{ $index }}.price" class="form-control form-control-sm border border-1 customer_input text-center @if(session()->has('errorPrice.' . $index)) border-danger @endif @error('items.' . $index . '.price') border-danger  @enderror" placeholder="Enter Price">
                                     @if(session()->has('errorPrice.' . $index))
                                            <div class="text-danger">{{ session('errorPrice.' . $index) }}</div>
                                    @endif
                                        
                                    @error('items.' . $index . '.price') 
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror 
                                   
                                </div>
    
    
                                <!-- Delete Button -->
                                <div class="col-md-1" style="margin-top: 33px;">
                                    <button type="button" class="btn btn-danger btn-sm mb-0" wire:click="removeItem({{ $index }})">
                                        <span class="material-icons">delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                
                    <!-- Add Item Button -->

                    <div class="row align-items-end mb-4">
                        <div class="col-md-8 col-12"></div>
                        <div class="col-md-4 col-12">
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <table style="width:100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        @if (session()->has('errorAmount')) 
                                                            <div class="alert alert-danger">
                                                                {{ session('errorAmount') }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: end;">
                                                        <button type="button" class="btn btn-cta btn-sm" wire:click="addItem">
                                                            <i class="material-icons text-white" style="font-size: 15px;">add</i>
                                                            Add Item
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-70"><label class="form-label"><strong>Total Amount</strong></label></td>
                                    <td>
                                        <!-- Sub Total -->
                                        <input type="text" class="form-control form-control-sm text-center" wire:model="billing_amount" disabled value="{{ number_format($billing_amount, 2) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-70"><label class="form-label"><strong>Paid Amount</strong></label></td>
                                    <td>
                                        <!-- Amount Paid -->
                                        <input type="text" class="form-control border border-2 p-2 form-control-sm text-center @error('paid_amount') border-danger  @enderror" wire:keyup="GetRemainingAmount($event.target.value)" 
                                        wire:model="paid_amount" placeholder="0" value="{{ number_format($paid_amount, 2) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-70"><label class="form-label"><strong>Remaining Amount</strong></label></td>
                                    <td>
                                        <!-- Remaining Amount -->
                                        <input type="text" class="form-control form-control-sm remaining_amount text-center" name="remaining_amount" disabled value="{{ number_format($remaining_amount, 2) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="form-label"><strong>Payment Mode</strong></label></td>
                                    <td>
                                         <select class="form-control border border-2 p-2 form-control-sm @error('payment_mode') border-danger  @enderror" wire:model="payment_mode">
                                            <option value="" selected hidden>Choose one..</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Online">Online</option>
                                         </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="form-label"><strong>Ordered By</strong></label></td>
                                    <td>
                                         <select class="form-control border border-2 p-2 form-control-sm @error('salesman') border-danger  @enderror" wire:change="changeSalesman($event.target.value)" wire:model="salesman">
                                            <option value="" selected hidden>Choose one..</option>
                                            <!-- Set authenticated user as default -->
                                            
                                            <option value="{{auth()->id()}}" selected>{{auth()->user()->name}}</option>
                                            <!-- Fetch all salesme  n from the database -->
                                            @foreach ($salesmen as $salesmans)
                                             @if($salesmans->id != auth()->guard('admin')->user()->id)
                                                 <option value="{{$salesmans->id}}">{{$salesmans->name}}</option> 
                                             @endif
                                            @endforeach
                                         </select>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="w-70"><label class="form-label"><strong>Bill Number</strong></label></td>
                                    <td>
                                        <!-- Remaining Amount -->
                                        <input type="text" class="form-control form-control-sm text-center border border-1" disabled wire:model="order_number" value="{{$order_number}}" >
                                      
                                    </td>
                                </tr> 
                                @error('order_number') 
                                <tr>
                                    <td colspan="2">
                                        <div class="text-danger">{{ $message }}</div>
                                    </td>    
                                </tr>  
                                @enderror 
                            </table>
                           
                        </div>
                        <div class="col-md-4 col-12"></div>
                    </div>
                </div>
                
                
                <div class="d-flex justify-content-end align-items-center mb-3">
                    @if($activeTab>1)
                    <button type="button" class="btn btn-black mx-2" wire:click="TabChange({{$activeTab-1}})"><i class="material-icons text-white">chevron_left</i>Previous</button>
                    <button type="submit" class="btn btn-cta mx-2"><i class="material-icons text-white">add</i>Generate Order</button>
                    @endif
                    @if($activeTab==1)
                        <button type="button" class="btn btn-cta mx-2" wire:click="TabChange({{$activeTab+1}})">Next<i class="material-icons text-white">chevron_right</i></button>
                    @endif
                   
                </div>
            </form>
            <!-- Tabs content -->
               
        </div>
    </div>
</div>


