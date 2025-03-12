<div class="container">
    <section class="admin__title">
        <h5>Place Order</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li>Sales Management</li>
            <li><a href="{{route('admin.order.new')}}">Place Order</a></li>
            <li class="back-button">
                @if($activeTab==1)
                <a class="btn btn-sm btn-danger select-md text-light font-weight-bold mb-0"
                    href="{{route('admin.order.index')}}" role="button">
                    <i class="material-icons text-white" style="font-size: 15px;">chevron_left</i>
                    <span class="ms-1">Back</span>
                </a>
                @endif
            </li>
        </ul>
    </section>
    <div class="card my-4">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between align-items-center mb-2">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                {{-- @if ($activeTab==1 && $salesmanBill == null)
                <div class="badge bg-primary">
                    <a href="{{ route('salesman.index') }}"> <strong>Error:</strong> Please add a bill for this user
                        before placing the order.</a>
                </div>
                @endif --}}
            </div>
        </div>

        <div class="card-body" id="sales_order_data">
            <form wire:submit.prevent="save">
                <div class="{{$activeTab==1?" d-block":"d-none"}}" id="tab1">
                    <div class="row align-items-center mb-3">
                        {{-- Display Order by and order number --}}
                          <!-- Ordered By Section -->
                           
                        <div class="col-md-4">
                            <label class="form-label"><strong>Ordered By</strong></label>
                            <select
                                class="form-control border border-2 p-2 form-control-sm @error('salesman') border-danger  @enderror"
                                wire:change="changeSalesman($event.target.value)" wire:model="salesman">
                                <option value="" selected hidden>Choose one..</option>
                                <!-- Set authenticated user as default -->

                                <option value="{{auth()->guard('admin')->user()->id}}" selected>
                                    {{auth()->guard('admin')->user()->name}}
                                </option>
                                <!-- Fetch all salesme  n from the database -->
                                @foreach ($salesmen as $salesmans)
                                @if($salesmans->id != auth()->guard('admin')->user()->id)
                                <option value="{{$salesmans->id}}">{{$salesmans->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            @if(isset($errorMessage['salesman']))
                            <div class="text-danger">{{ $errorMessage['salesman'] }}</div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><strong>Bill Number</strong></label>
                            <!-- Remaining Amount -->
                            <input type="text" class="form-control form-control-sm text-center border border-1" disabled
                                wire:model="order_number" value="{{$order_number}}">
                            @if(isset($errorMessage['order_number']))
                            <div class="text-danger">{{ $errorMessage['order_number'] }}</div>
                            @endif
                            {{-- @error('order_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror --}}
                        </div>

                        <!-- Search Label and Select2 -->
                        <div class="col-md-4 mt-2">
                            <div class="d-flex justify-content-between">
                                <!-- Search Label -->
                                <label for="searchCustomer" class="form-label mb-0">Customer</label>
                            </div>

                            <div class="position-relative">
                                <input type="text" wire:keyup="FindCustomer($event.target.value)"
                                    wire:model.debounce.500ms="searchTerm"
                                    class="form-control form-control-sm border border-1 customer_input"
                                    placeholder="Search by customer details or order ID">

                                @if(!empty($searchResults))
                                <div id="fetch_customer_details" class="dropdown-menu show w-100"
                                    style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($searchResults as $customer)
                                    <button class="dropdown-item" type="button"
                                        wire:click="selectCustomer({{ $customer->id }})">
                                        <img src="{{ $customer->profile_image ? asset($customer->profile_image) : asset('assets/img/user.png') }}"
                                            alt=""> {{$customer->prefix . " ". $customer->name }} ({{ $customer->phone
                                        }})
                                    </button>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <!-- Search Label -->
                                <label for="searchCustomer" class="form-label mb-0">Country</label>
                            </div>
                            <div class="position-relative">
                                <input type="text" wire:keyup="FindCountry($event.target.value)"
                                    wire:model.debounce.500ms="search"
                                    class="form-control form-control-sm border border-1 customer_input"
                                    placeholder="Search By Country">
                                @if(isset($errorMessage['search']))
                                <div class="text-danger">{{ $errorMessage['search'] }}</div>
                                @endif
                                @if(!empty($filteredCountries))
                                <div id="fetch_customer_details" class="dropdown-menu show w-100"
                                    style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($filteredCountries as $countries)
                                    <button class="dropdown-item" type="button"
                                        wire:click="selectCountry({{ $countries->id }})">
                                        {{$countries->title}}({{$countries->country_code}})
                                    </button>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <!-- Search Label -->
                                <label for="searchCustomer" class="form-label mb-0">Business Type</label>
                            </div>
                            <select wire:model="selectedBusinessType" class="form-select me-2 form-control form-control-sm border border-1 customer_input"
                                aria-label="Default select example">
                                <option selected hidden>Select Domain</option>
                                @foreach ($Business_type as $domain)
                                <option value="{{$domain->id}}">{{$domain->title}}</option>
                                @endforeach
                            </select>
                            @if(isset($errorMessage['selectedBusinessType']))
                            <div class="text-danger">{{ $errorMessage['selectedBusinessType'] }}</div>
                            @endif
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
                    <h6 class="mb-3">Previous Order Details</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>Order Number</th>
                                <th>Customer Name</th>
                                <th>Billing Amount</th>
                                <th>Billing Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr class="text-center">
                                <td>{{ $order->order_number }}</td>
                                <td>
                                    {{ $order->customer ? $order->customer->prefix ." ".$order->customer->name : "" }}
                                </td>
                                <td>{{ $order->total_amount }}</td>
                                <td>{{ $order->last_payment_date }}</td>
                                <td>
                                    <a href="{{ route('admin.order.invoice', $order->id) }}"
                                        class="btn btn-outline-primary btn-sm" target="_blank">
                                        Invoice
                                    </a>
                                </td>
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
                        <div class="mb-2 col-md-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select wire:model="prefix" class="form-control form-control-sm border border-1"
                                    style="max-width: 60px;">
                                    <option value="" selected hidden>Prefix</option>
                                    @foreach (App\Helpers\Helper::getNamePrefixes() as $prefixOption)
                                    <option value="{{$prefixOption}}">{{ $prefixOption }}</option>
                                    @endforeach
                                </select>
                                <input type="text" wire:model="name" id="name"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['name'] ?? '' }}"
                                    placeholder="Enter customer name">
                            </div>
                            @if(isset($errorMessage['prefix']))
                            <div class="text-danger">{{ $errorMessage['prefix'] }}</div>
                            @endif
                            @if(isset($errorMessage['name']))
                            <div class="text-danger">{{ $errorMessage['name'] }}</div>
                            @endif
                        </div>

                        <div class="mb-2 col-md-4">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" wire:model="company_name" id="company_name"
                                class="form-control form-control-sm border border-1 p-2"
                                placeholder="Enter company name">
                        </div>
                        <div class="mb-2 col-md-2">
                            <label for="employee_rank" class="form-label"> Rank</label>
                            <input type="text" wire:model="employee_rank" id="employee_rank"
                                class="form-control form-control-sm border border-1 p-2" placeholder="Enter rank">
                        </div>

                        <div class="mb-2 col-md-3">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" wire:model="email" id="email"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['email'] ?? '' }}"
                                placeholder="Enter email">
                            @if(isset($errorMessage['email']))
                            <div class="text-danger">{{ $errorMessage['email'] }}</div>
                            @endif
                        </div>

                        <div class="mb-2 col-md-3">
                            <label for="dob" class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                            <input type="date" autocomplete="bday" wire:model="dob" id="dob"
                                max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['dob'] ?? '' }}">
                            @if(isset($errorMessage['dob']))
                            <div class="text-danger">{{ $errorMessage['dob'] }}</div>
                            @endif
                        </div>
                        <div class="mb-2 col-md-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <div class="extention-group">
                                <input class="input__prefix form-control form-control-sm border border-1"
                                    wire:model="country_code" type="text" name="country_code" id="country_code"
                                    readonly>
                                <input type="text" wire:model="phone" id="phone"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['phone'] ?? '' }}"
                                    placeholder="Enter phone number" maxLength={{ $mobileLength }}>
                            </div>
                            @if(isset($errorMessage['phone']))
                            <div class="text-danger">{{ $errorMessage['phone'] }}</div>
                            @endif
                        </div>

                        <div class="mb-2 col-md-3">
                            <label for="whatsapp_no" class="form-label">WhatsApp Number <span
                                    class="text-danger">*</span></label>
                            <div class="extention-group">
                                <input class="input__prefix form-control form-control-sm border border-1"
                                    wire:model="country_code" type="text" name="country_code" id="country_code"
                                    readonly>
                                <input type="text" wire:model="whatsapp_no" id="whatsapp_no"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['whatsapp_no'] ?? '' }}"
                                    placeholder="Enter whatsapp number" @if($whatsapp_no)disabled @endif maxLength={{
                                    $mobileLength }}>
                            </div>
                            @if(isset($errorMessage['whatsapp_no']))
                            <div class="text-danger">{{ $errorMessage['whatsapp_no'] }}</div>
                            @endif
                            <div class="form-check ps-0">
                                <input type="checkbox" id="is_wa_same" wire:change="SameAsMobile"
                                    class="form-check-input" value="0" wire:model="is_wa_same" @if($is_wa_same) checked
                                    @endif>
                                <label for="is_wa_same" class="form-check-label font-sm text-danger"><small>Same as
                                        Phone Number</small></label>
                            </div>

                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="mobile" class="form-label">alternative phone number 1 </label>
                            <div class="extention-group">
                                <input class="input__prefix form-control form-control-sm border border-1"
                                    wire:model="country_code" type="text" name="country_code" id="country_code"
                                    readonly>
                                <input type="text" wire:model="alternative_phone_number_1"
                                    class="form-control form-control-sm border border-1 p-2"
                                    placeholder="Alternative Phone No" maxLength={{ $mobileLength }}>
                            </div>
                            @if(isset($errorMessage['alternative_phone_number_1']))
                            <div class="text-danger">{{ $errorMessage['alternative_phone_number_1'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="mobile" class="form-label">alternative phone number 2 </label>
                            <div class="extention-group">
                                <input class="input__prefix form-control form-control-sm border border-1"
                                    wire:model="country_code" type="text" name="country_code" id="country_code"
                                    readonly>
                                <input type="text" wire:model="alternative_phone_number_2"
                                    class="form-control form-control-sm border border-1 p-2"
                                    placeholder="Alternative Phone No" maxLength={{ $mobileLength }}>
                            </div>
                            @if(isset($errorMessage['alternative_phone_number_2']))
                            <div class="text-danger">{{ $errorMessage['alternative_phone_number_2'] }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="">
                        <div class="">
                            <h6 class="badge bg-danger custom_danger_badge">Address</h6>
                        </div>
                        <div class="pt-0">
                            <div class="admin__content">
                                <aside>
                                    <nav class="text-uppercase font-weight-bold">Billing Address</nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Address <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="billing_addr" class="form-control form-control-sm"
                                                wire:model="billing_address" value="">
                                            @if(isset($errorMessage['billing_address']))
                                            <div class="text-danger">{{ $errorMessage['billing_address'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Landmark</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="billing_landmark"
                                                class="form-control form-control-sm" wire:model="billing_landmark"
                                                value="">
                                            @if(isset($errorMessage['billing_landmark']))
                                            <div class="text-danger">{{ $errorMessage['billing_landmark'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">City <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="billing_city" class="form-control form-control-sm"
                                                wire:model="billing_city" value="">
                                            @if(isset($errorMessage['billing_city']))
                                            <div class="text-danger">{{ $errorMessage['billing_city'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Country <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="billing_country" class="form-control form-control-sm"
                                                wire:model="billing_country" value="">
                                            @if(isset($errorMessage['billing_country']))
                                            <div class="text-danger">{{ $errorMessage['billing_country'] }}</div>
                                            @endif
                                        </div>
                                        <div class="col-3 text-end">
                                            <label for="" class="col-form-label">Pincode</label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="billing_pin" class="form-control form-control-sm"
                                                wire:model="billing_pin" value="">
                                            @if(isset($errorMessage['billing_pin']))
                                            <div class="text-danger">{{ $errorMessage['billing_pin'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </content>
                            </div>
                            <div class="admin__content">
                                <aside>

                                </aside>
                                <content class="p-0">
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-auto">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    wire:model="is_billing_shipping_same" id="checkSameBilling"
                                                    wire:change="toggleShippingAddress" @if ($is_billing_shipping_same)
                                                    checked @endif>
                                                <label class="form-check-label same_as_field" for="checkSameBilling">
                                                    Same as Billing Address
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </content>
                            </div>
                            <div class="admin__content">
                                <aside>
                                    <nav class="text-uppercase font-weight-bold">Shipping Address</nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Address <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="shipping_addr" class="form-control form-control-sm"
                                                wire:model="shipping_address" value="" @if ($shipping_address) disabled
                                                @endif>
                                            @if(isset($errorMessage['shipping_address']))
                                            <div class="text-danger">{{ $errorMessage['shipping_address'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Landmark</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="shipping_landmark"
                                                class="form-control form-control-sm" wire:model="shipping_landmark"
                                                value="" @if ($shipping_landmark) disabled @endif>
                                            @if(isset($errorMessage['shipping_landmark']))
                                            <div class="text-danger">{{ $errorMessage['shipping_landmark'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">City<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="shipping_city" class="form-control form-control-sm"
                                                wire:model="shipping_city" value="" @if ($shipping_city) disabled
                                                @endif>
                                            @if(isset($errorMessage['shipping_city']))
                                            <div class="text-danger">{{ $errorMessage['shipping_city'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Country <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="shipping_country"
                                                class="form-control form-control-sm" wire:model="shipping_country"
                                                value="" @if ($shipping_country) disabled @endif>
                                            @if(isset($errorMessage['shipping_country']))
                                            <div class="text-danger">{{ $errorMessage['shipping_country'] }}</div>
                                            @endif
                                        </div>
                                        <div class="col-3 text-end">
                                            <label for="" class="col-form-label">Pincode</label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="shipping_pin" class="form-control form-control-sm"
                                                wire:model="shipping_pin" value="" @if ($shipping_pin) disabled @endif>
                                            @if(isset($errorMessage['shipping_pin']))
                                            <div class="text-danger">{{ $errorMessage['shipping_pin'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </content>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="{{$activeTab==2?" d-block":"d-none"}}" id="tab2">
                    <div class="row">
                        <div class="col-12 col-md-12 mb-2 mb-md-0">
                            <h6 class="badge bg-danger custom_danger_badge">Product Information</h6>
                        </div>
                    </div>
                        @if ($errors->has('items'))
                            <div class="alert alert-danger">
                                {{ $errors->first('items') }}
                            </div>
                        @endif
                        {{-- Display Order by and order number --}}
                          <!-- Ordered By Section -->
                        <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Ordered By</strong></label>
                            <input type="text" 
                                class="form-control border border-2 p-2 form-control-sm @error('salesman') border-danger  @enderror"
                               value="{{$salesmans->name}}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Bill Number</strong></label>
                            <!-- Remaining Amount -->
                            <input type="text" class="form-control form-control-sm text-center border border-1" disabled
                                value="{{$order_number}}" readonly>
                        </div>
                        </div>

                        <!-- Loop through items -->
                        @foreach($items as $index => $item)
                            <div class="row align-items-center mt-3">
                            <!-- Collection  -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Collection </strong><span
                                        class="text-danger">*</span></label>
                                <select wire:model="items.{{ $index }}.collection"
                                    wire:change="GetCategory($event.target.value, {{ $index }})"
                                    class="form-control border border-2 p-2 form-control-sm @error('items.'.$index.'.collection') border-danger @enderror">
                                    <option value="" selected hidden>Select collection</option>
                                    @foreach($collections as $citems)
                                    <option value="{{ $citems->id }}">{{ ucwords($citems->title) }}
                                        @if($citems->short_code)({{ $citems->short_code }})@endif</option>
                                    @endforeach
                                </select>
                                @error("items.".$index.".collection")
                                <div class='text-danger'>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Category</strong> <span
                                        class="text-danger">*</span></label>
                                <select wire:model="items.{{ $index }}.category"
                                    class="form-select form-control-sm border border-1 @error('items.'.$index.'.category') border-danger @enderror"
                                    wire:change="CategoryWiseProduct($event.target.value, {{ $index }})">
                                    <option value="" selected hidden>Select Category</option>
                                    @if (isset($items[$index]['categories']) && count($items[$index]['categories']) > 0)
                                    @foreach ($items[$index]['categories'] as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['title'] }}</option>
                                    @endforeach
                                    @else
                                    <option value="" disabled>No categories available</option>
                                    @endif
                                </select>
                                @error("items.".$index.".category")
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
                                    <input type="text" wire:keyup="FindProduct($event.target.value, {{ $index }})"
                                        wire:model="items.{{ $index }}.searchproduct"
                                        class="form-control form-control-sm border border-1 customer_input @error('items.'.$index.'.searchproduct') border-danger @enderror"
                                        placeholder="Enter product name">
                                    @if (session()->has('errorProduct.' . $index))
                                    <p class="text-danger">{{ session('errorProduct.' . $index) }}</p>
                                    @endif
                                    @if(isset($items[$index]['products']) && count($items[$index]['products']) > 0)
                                    <div id="fetch_customer_details" class="dropdown-menu show w-25"
                                        style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($items[$index]['products'] as $product)
                                        <button class="dropdown-item" type="button"
                                            wire:click='selectProduct({{ $index }}, "{{ $product->name }}", {{ $product->id }})'>
                                            <img src="{{ $product->product_image ? asset($product->product_image) : asset('assets/img/cubes.png') }}"
                                                alt=""> {{ $product->name }}({{ $product->product_code }})
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
                                    <select wire:model="items.{{ $index }}.selectedCatalogue"
                                        class="form-control form-control-sm border border-1 @error('items.'.$index.'.selectedCatalogue') border-danger @enderror"
                                        wire:change="SelectedCatalogue($event.target.value, {{ $index }})">
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
                                    <input type="number" wire:model="items.{{$index}}.page_number"
                                        wire:keyup="validatePageNumber({{ $index }})" id="page_number"
                                        class="form-control form-control-sm border border-2 @error('items.'.$index.'.page_number') border-danger @enderror"
                                        min="1"
                                        max="{{ isset($items[$index]['selectedCatalogue']) && isset($maxPages[$index][$items[$index]['selectedCatalogue']]) ? $maxPages[$index][$items[$index]['selectedCatalogue']] : '' }}">
                                    @error("items.".$index.".page_number")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @endif
                                <!-- Catalogue end -->
                            </div>
                            {{-- Append Measurements data --}}
                            @if(isset($this->items[$index]['product_id']) && $items[$index]['collection'] == 1)
                            <div class="row">
                                <div class="col-12 col-md-6 mb-2 mb-md-0 measurement_div">
                                    <h6 class="badge bg-danger custom_success_badge">Measurements</h6>
                                    <div class="row">
                                        @if(isset($items[$index]['measurements']) &&
                                        count($items[$index]['measurements']) > 0)
                                        @foreach ($items[$index]['measurements'] as $measurement)
                                        <div class="col-md-3">
                                            {{-- {{dd($measurement)}} --}}
                                            <label>{{ $measurement['title'] }}
                                                <strong>[{{$measurement['short_code']}}]</strong></label>
                                            <input type="hidden"
                                                wire:model="items.{{ $index }}.get_measurements.{{ $measurement['id'] }}.title"
                                                value="{{ $measurement['title'] }}">
                                            <input type="text"
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
                                <div class="col-12 col-md-2">
                                    <label class="form-label"><strong>Fabric</strong></label>
                                    <input type="text" wire:model="items.{{ $index }}.searchTerm"
                                        wire:keyup="searchFabrics({{ $index }})" class="form-control form-control-sm"
                                        placeholder="Search by fabric name" id="searchFabric_{{ $index }}">
                                    @error("items.". $index .".searchTerm")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    @if(!empty($items[$index]['searchResults']))
                                    <div class="dropdown-menu show w-100" style="max-height: 187px; overflow-y: auto;">
                                        @foreach ($items[$index]['searchResults'] as $fabric)
                                        <button class="dropdown-item fabric_dropdown_item" type="button"
                                            wire:click="selectFabric({{ $fabric->id }}, {{ $index }})">
                                            {{ $fabric->title }}
                                        </button>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="col-12 col-md-2"></div>
                                <div class="col-12 col-md-2">
                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                        <!-- Price Input -->
                                        <div>
                                            <label class="form-label"><strong>Price</strong></label>
                                            <input type="text"
                                                wire:keyup="checkproductPrice($event.target.value, {{ $index }})"
                                                wire:model="items.{{ $index }}.price"
                                                class="form-control form-control-sm border border-1 customer_input text-center 
                                                                @if(session()->has('errorPrice.' . $index)) border-danger @endif 
                                                                @error('items.' . $index . '.price') border-danger  @enderror" placeholder="Enter Price">
                                        </div>
                                        <div>
                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger btn-sm danger_btn"
                                                wire:click="removeItem({{ $index }})">
                                                <span class="material-icons">delete</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Error Messages -->
                                    @if(session()->has('errorPrice.' . $index))
                                    <div class="text-danger">{{ session('errorPrice.' . $index) }}</div>
                                    @endif

                                    @error('items.' . $index . '.price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @else
                            <div class="col-12 col-md-2 offset-md-10 mb-2">
                                <div class="d-flex align-items-center gap-2 justify-content-end">
                                    <div>
                                        <!-- Price Input -->
                                        <label class="form-label"><strong>Price</strong></label>
                                        <input type="text" wire:keyup="checkproductPrice($event.target.value, {{ $index }})"
                                            wire:model="items.{{ $index }}.price" class="form-control form-control-sm border border-1 customer_input text-center 
                                                        @if(session()->has('errorPrice.' . $index)) border-danger @endif 
                                                        @error('items.' . $index . '.price') border-danger  @enderror"
                                            placeholder="Enter Price">
                                    </div>
                                    <div>
                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm danger_btn"
                                            wire:click="removeItem({{ $index }})"><span class="material-icons">delete</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Error Messages -->
                                @if(session()->has('errorPrice.' . $index))
                                <div class="text-danger">{{ session('errorPrice.' . $index) }}</div>
                                @endif

                                @error('items.' . $index . '.price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                        @endforeach
                        <!-- Add Item Button -->
                        <div class="row align-items-end my-4">
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
                                                            <button type="button" class="btn btn-cta btn-sm"
                                                                wire:click="addItem">
                                                                <i class="material-icons text-white"
                                                                    style="font-size: 15px;">add</i>
                                                                Add Item
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-70"><label class="form-label"><strong>Total Amount</strong></label>
                                        </td>
                                        <td>
                                            <!-- Sub Total -->
                                            <input type="text" class="form-control form-control-sm text-center"
                                                wire:model="billing_amount" disabled
                                                value="{{ number_format($billing_amount, 2) }}">
                                        </td>
                                    </tr>

                                    {{-- <tr>
                                        <td><label class="form-label"><strong>Ordered By</strong></label></td>
                                        <td>
                                            <select
                                                class="form-control border border-2 p-2 form-control-sm @error('salesman') border-danger  @enderror"
                                                wire:change="changeSalesman($event.target.value)" wire:model="salesman">
                                                <option value="" selected hidden>Choose one..</option>
                                                <!-- Set authenticated user as default -->

                                                <option value="{{auth()->guard('admin')->user()->id}}" selected>
                                                    {{auth()->guard('admin')->user()->name}}
                                                </option>
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
                                        <td class="w-70"><label class="form-label"><strong>Bill Number</strong></label>
                                        </td>
                                        <td>
                                            <!-- Remaining Amount -->
                                            <input type="text"
                                                class="form-control form-control-sm text-center border border-1"
                                                disabled wire:model="order_number" value="{{$order_number}}">
                                        </td>
                                    </tr>
                                    @error('order_number')
                                    <tr>
                                        <td colspan="2">
                                            <div class="text-danger">{{ $message }}</div>
                                        </td>
                                    </tr>
                                    @enderror --}}
                                </table>
                            </div>
                            <div class="col-md-4 col-12"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center mb-3">
                        @if($activeTab>1)
                        <button type="button" class="btn btn-dark mx-2 btn-sm"
                            wire:click="TabChange({{$activeTab-1}})"><i
                                class="material-icons text-white">chevron_left</i>Previous</button>
                        <button type="submit" class="btn btn-primary mx-2 btn-sm"><i
                                class="material-icons text-white">add</i>Generate Order</button>
                        @endif
                        @if($activeTab==1)
                        <button type="button" class="btn btn-sm btn-cta mx-2"
                            wire:click="TabChange({{$activeTab+1}})">Next<i
                                class="material-icons text-white">chevron_right</i></button>
                        @endif

                    </div>
            </form>
            <!-- Tabs content -->
        </div>
    </div>
    {{-- <div class="loader-container" wire:target="!FindCustomer" wire:loading>
        <div class="loader"></div>
    </div> --}}

</div>