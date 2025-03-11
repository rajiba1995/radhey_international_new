<div class="container">
    <section class="admin__title">
        <h5>Update Order <span class="badge bg-success custom_success_badge">{{env('ORDER_PREFIX') .
                $order_number}}</span></h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li>Sales Management</li>
            <li><a href="{{route('admin.order.edit',$orders->id)}}">Update Order</a></li>
            <li class="back-button">
                @if($activeTab==1)
                <a class="btn btn-dark btn-sm text-decoration-none text-light font-weight-bold mb-0"
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if($activeTab==1 && $salesmanBill == null)
                <div class="badge bg-primary">
                    <a href="{{ route('salesman.index') }}"> <strong>Error:</strong> Please add a bill for this user
                        before placing the order.</a>
                </div>
                @endif
            </div>
        </div>
        <div class="card-body" id="sales_order_data">
            <form wire:submit.prevent="update">
                <div class="{{$activeTab==1?" d-block":"d-none"}}" id="tab1">
                    <div class="row d-flex justify-content-between align-items-center mb-2">
                        <!-- Customer Information Badge -->
                        <div class="col-md-4">
                            <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                        </div>
                        <div class="col-md-8 d-flex justify-content-end gap-3">
                            <div>
                                <!-- Search Label -->
                                <label for="searchCustomer" class="form-label mb-0">Country</label>
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
                            <div>
                                <!-- Search Label -->
                                <label for="searchCustomer" class="form-label mb-0">Business Type</label>
                                <select wire:model="selectedBusinessType" class="form-select me-2 form-control"
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
                    </div>
                    <!-- Customer Details -->
                    <div class="container">
                        <!-- Customer Details -->
                        <div class="row">
                            <div class="mb-2 col-md-6">
                                <input type="hidden" name="customer_id" wire:model="customer_id">
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
                                        placeholder="Enter Customer Name">
                                </div>
                                @if(isset($errorMessage['name']))
                                <div class="text-danger">{{ $errorMessage['name'] }}</div>
                                @endif
                            </div>

                            <div class="mb-2 col-md-4">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" wire:model="company_name" id="company_name"
                                    class="form-control form-control-sm border border-1 p-2"
                                    placeholder="Enter Company Name">
                            </div>

                            <div class="mb-2 col-md-2">
                                <label for="employee_rank" class="form-label"> Rank</label>
                                <input type="text" wire:model="employee_rank" id="employee_rank"
                                    class="form-control form-control-sm border border-1 p-2" placeholder="Enter Rank">
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" wire:model="email" id="email"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['email'] ?? '' }}"
                                    placeholder="Enter Email">
                                @if(isset($errorMessage['email']))
                                <div class="text-danger">{{ $errorMessage['email'] }}</div>
                                @endif
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="dob" class="form-label">Date Of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="date" wire:model="dob" id="dob" max="{{date('Y-m-d')}}"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['dob'] ?? '' }}">
                                @if(isset($errorMessage['dob']))
                                <div class="text-danger">{{ $errorMessage['dob'] }}</div>
                                @endif
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="phone" class="form-label">Phone Number<span
                                        class="text-danger">*</span></label>
                                <div class="extention-group">
                                    <input class="input__prefix form-control form-control-sm border border-1"
                                        wire:model="country_code" type="text" name="country_code" id="country_code"
                                        readonly>
                                    <input type="text" wire:model="phone" id="phone"
                                        class="form-control form-control-sm border border-1 p-2 {{ $errorClass['phone'] ?? '' }}"
                                        placeholder="Enter Phone Number">
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
                                        placeholder="Enter WhatsApp Number" @if($whatsapp_no)disabled @endif>
                                </div>
                                @if(isset($errorMessage['whatsapp_no']))
                                <div class="text-danger">{{ $errorMessage['whatsapp_no'] }}</div>
                                @endif
                                <input type="checkbox" id="is_wa_same" class="form-check-input border border-1"
                                    wire:change="SameAsMobile" value="0" @if($is_wa_same) checked @endif>
                                <label for="is_wa_same" class="form-check-label ms-2 font-sm text-danger"><small>Same as
                                        Phone Number</small></label>
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

                    </div>

                    <div class="">
                        <div class="">
                            <h6 class="badge bg-danger custom_danger_badge">Address</h6>
                        </div>
                        <div class="pt-0">

                            <div class="admin__content">
                                {{-- Billing Address --}}
                                <aside>
                                    <nav class="text-uppercase font-weight-bold">Billing Address</nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="billing_address" class="col-form-label"> Address <span
                                                    class="text-danger">*</span>
                                            </label>
                                        </div>
                                        <div class="col-9">
                                            <input wire:model="billing_address" id="billing_address" cols="30" rows="3"
                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_address'] ?? '' }}"
                                                placeholder="Enter billing address">
                                            @if(isset($errorMessage['billing_address']))
                                            <div class="text-danger">{{ $errorMessage['billing_address'] }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="billing_landmark" class="form-label">Landmark</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" wire:model="billing_landmark" id="billing_landmark"
                                                class="form-control form-control-sm border border-1 p-2"
                                                placeholder="Enter landmark">
                                        </div>
                                    </div>

                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="billing_city" class="form-label">City <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" wire:model="billing_city" id="billing_city"
                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_city'] ?? '' }}"
                                                placeholder="Enter city">
                                            @if(isset($errorMessage['billing_city']))
                                            <div class="text-danger">{{ $errorMessage['billing_city'] }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="billing_country" class="form-label">Country <span
                                                    class="text-danger">*</span>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" wire:model="billing_country" id="billing_country"
                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_country'] ?? '' }}"
                                                placeholder="Enter country">
                                            @if(isset($errorMessage['billing_country']))
                                            <div class="text-danger">{{ $errorMessage['billing_country'] }}</div>
                                            @endif
                                        </div>
                                        <div class="col-3 text-end">
                                            <label for="billing_pin" class="form-label">Pincode </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" wire:model="billing_pin" id="billing_pin"
                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_pin'] ?? '' }}"
                                                placeholder="Enter PIN">
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
                                                <input type="checkbox" wire:change="toggleShippingAddress"
                                                    wire:model="is_billing_shipping_same" id="isBillingShippingSame"
                                                    class="form-check-input" @if ($is_billing_shipping_same) checked
                                                    @endif>
                                                <label for="isBillingShippingSame"
                                                    class="form-check-label same_as_field"><span> Same as Billing
                                                        Address</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </content>
                            </div>
                            {{-- <div class="d-flex justify-content-between mt-4">
                                <h6 class="badge bg-danger custom_danger_badge">Shipping Address</h6>
                                <div class="form-check">
                                    <input type="checkbox" wire:change="toggleShippingAddress"
                                        wire:model="is_billing_shipping_same" id="isBillingShippingSame"
                                        class="form-check-input" @if ($is_billing_shipping_same) checked @endif>
                                    <label for="isBillingShippingSame" class="form-check-label"><span
                                            class="badge bg-secondary">Shipping address same as billing</span></label>
                                </div>
                            </div> --}}

                            {{-- Shipping Address Panel --}}
                            <div class="admin__content">
                                <aside>
                                    <nav class="text-uppercase font-weight-bold">Shipping Address</nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="shipping_address" class="form-label"> Address <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            <input wire:model="shipping_address" id="shipping_address"
                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_address'] ?? '' }}"
                                                placeholder="Enter shipping address" @if ($shipping_address) disabled
                                                @endif>
                                            @if(isset($errorMessage['shipping_address']))
                                            <div class="text-danger">{{ $errorMessage['shipping_address'] }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="shipping_landmark" class="form-label">Landmark</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" wire:model="shipping_landmark" id="shipping_landmark"
                                                class="form-control form-control-sm border border-1 p-2"
                                                placeholder="Enter landmark">
                                        </div>
                                    </div>

                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="shipping_city" class="form-label">City <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" wire:model="shipping_city" id="shipping_city"
                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_city'] ?? '' }}"
                                                placeholder="Enter city" @if ($shipping_city) disabled @endif>
                                            @if(isset($errorMessage['shipping_city']))
                                            <div class="text-danger">{{ $errorMessage['shipping_city'] }}</div>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="shipping_country" class="form-label">Country <span
                                                    class="text-danger">*</span>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" wire:model="shipping_country" id="shipping_country"
                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_country'] ?? '' }}"
                                                placeholder="Enter country" @if ($shipping_country) disabled @endif>
                                            @if(isset($errorMessage['shipping_country']))
                                            <div class="text-danger">{{ $errorMessage['shipping_country'] }}</div>
                                            @endif
                                        </div>
                                        <div class="col-3 text-end">
                                            <label for="shipping_pin" class="form-label">Pincode </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" wire:model="shipping_pin" id="shipping_pin"
                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_pin'] ?? '' }}"
                                                placeholder="Enter PIN" @if ($shipping_pin) disabled @endif>
                                            @if(isset($errorMessage['shipping_pin']))
                                            <div class="text-danger">{{ $errorMessage['shipping_pin'] }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- <div class="mb-3 col-md-4">
                                        <label for="shipping_pin" class="form-label">Zip Code <span
                                                class="text-danger">*</span></label>
                                        <input type="number" wire:model="shipping_pin" id="shipping_pin"
                                            class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_pin'] ?? '' }}"
                                            placeholder="Enter PIN" @if ($shipping_pin) disabled @endif>
                                        @if(isset($errorMessage['shipping_pin']))
                                        <div class="text-danger">{{ $errorMessage['shipping_pin'] }}</div>
                                        @endif
                                    </div> --}}
                                </content>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="{{ $activeTab == 2 ? 'd-block' : 'd-none' }}" id="tab2">
                    <div class="row">
                        <div class="col-12 col-md-12 mb-2">
                            <h6 class="badge bg-danger custom_danger_badge">Product Information</h6>
                        </div>
                    </div>
                    <!-- Loop through items -->
                    @foreach($items as $index => $item)
                    <div class="row align-items-center my-3">
                        <!-- Collection -->
                        <div class="mb-3 col-md-2">
                            <label class="form-label"><strong>Collection </strong><span
                                    class="text-danger">*</span></label>
                            <select wire:model="items.{{ $index }}.selected_collection"
                                wire:change="GetCategory($event.target.value, {{ $index }})"
                                class="form-control border border-2 p-2 form-control-sm">
                                <option value="" selected hidden>Select collection</option>
                                @foreach($collections as $citems)
                                <option value="{{ $citems->id }}" {{$item['selected_collection']==$citems->id ?
                                    "selected" : ""}}>{{ ucwords($citems->title) }}
                                    @if($citems->short_code)
                                    ({{ $citems->short_code }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            @error("items.".$index.".selected_collection")
                            <p class='text-danger inputerror'>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-3 col-md-2">
                            <label class="form-label"><strong>Category</strong></label>
                            <select wire:model="items.{{ $index }}.selected_category"
                                class="form-select form-control-sm border border-1"
                                wire:change="CategoryWiseProduct($event.target.value, {{ $index }})">
                                <option value="" selected hidden>Select Category</option>
                                @foreach ($item['categories'] as $category)
                                <option value="{{ $category->id }}" {{$item['selected_category']==$category->
                                    id?"selected":""}}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error("items.".$index.".selected_category")
                            <p class="text-danger inputerror">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Product -->
                        @if(isset($item['selected_collection']) && $item['selected_collection'] == 1)
                        <div class="mb-3 col-md-4">
                            @else
                            <div class="mb-3 col-md-8">
                                @endif
                                <label class="form-label"><strong>Product</strong></label>
                                <input type="text" wire:keyup="FindProduct($event.target.value, {{ $index }})"
                                    wire:model="items.{{ $index }}.searchproduct"
                                    class="form-control form-control-sm border border-1 customer_input"
                                    placeholder="Enter product name" value="{{ $item['searchproduct'] }}">

                                @error("items.".$index.".searchproduct")
                                <p class="text-danger inputerror">{{ $message }}</p>
                                @enderror

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
                            </div>
                            <!-- Catalogue -->
                            @if(isset($item['selected_collection']) && $item['selected_collection'] == 1)
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Catalogue</strong></label>
                                <select wire:model="items.{{ $index }}.selectedCatalogue"
                                    class="form-control form-control-sm border border-1 @error('items.'.$index.'.selectedCatalogue') border-danger @enderror"
                                    wire:change="SelectedCatalogue($event.target.value, {{ $index }})">
                                    <option value="" selected hidden>Select Catalogue</option>
                                    @foreach($item['catalogues'] ?? [] as $cat_log)
                                    <option value="{{ $cat_log['id'] }}" {{ (isset($item['selectedCatalogue']) &&
                                        $item['selectedCatalogue']==$cat_log['id']) ? 'selected' : '' }}>
                                        {{ $cat_log['catalogue_title']['title'] ?? 'No Title' }} (1 - {{
                                        $cat_log['page_number'] }})
                                    </option>
                                    @endforeach
                                </select>
                                @error("items." .$index. ".selectedCatalogue")
                                <div class="text-danger inputerror">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Page Number</strong></label>
                                <input type="number" wire:model="items.{{$index}}.page_number"
                                    wire:keyup="validatePageNumber({{ $index }})" id="page_number"
                                    class="form-control form-control-sm border border-2 @error('items.'.$index.'.page_number') border-danger @enderror"
                                    min="1"
                                    max="{{ isset($item['selectedCatalogue']) && isset($maxPages[$index][$item['selectedCatalogue']]) ? $maxPages[$index][$item['selectedCatalogue']] : '' }}">
                                @error("items.".$index.".page_number")
                                <div class="text-danger inputerror">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- </div> -->

                            @endif
                        </div>
                        <!-- Measurements -->
                        @if(isset($this->items[$index]['product_id']) && $items[$index]['selected_collection'] == 1)
                        <div class="row">
                            <div class="col-12 col-md-6 mb-2 mb-md-0 measurement_div">
                                <h6 class="badge bg-danger custom_success_badge">Measurements</h6>
                                <div class="row">

                                    @if(isset($items[$index]['measurements']) &&
                                    count($items[$index]['measurements']) > 0)
                                    @foreach ($items[$index]['measurements'] as $key => $measurement)
                                    <div class="col-md-3">
                                        <label>
                                            {{ isset($measurement['title']) ? $measurement['title'] : 'N/A' }}
                                            <strong>[{{ isset($measurement['short_code']) ?
                                                $measurement['short_code'] : '' }}]</strong>
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                            wire:model="items.{{ $index }}.measurements.{{ $key }}.value">
                                        @error("items.{$index}.measurements.{$key}.value")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <!-- Fabrics -->
                            <div class="col-12 col-md-2">
                                <label class="form-label"><strong>Fabric</strong></label>
                                <input type="text" wire:model="items.{{ $index }}.searchTerm"
                                    wire:keyup="searchFabrics({{ $index }})" class="form-control form-control-sm"
                                    placeholder="Search by fabric name" id="searchFabric_{{ $index }}"
                                    value="{{ optional(collect($items[$index]['fabrics'])->firstWhere('id', $items[$index]['selected_fabric']))->title }}">
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
                                        wire:model="items.{{ $index }}.price"
                                        class="form-control form-control-sm border border-1 customer_input text-center @if(session()->has('errorPrice.' . $index)) border-danger @endif @error('items.' . $index . '.price') border-danger @enderror"
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
                        <!-- Add Item Button and Payment Section -->
                        <div class="row align-items-end mb-4" style="justify-content: end;">
                            <div class="col-md-4" style="text-align: -webkit-center;">
                                <table>
                                    <tr>
                                        <td>
                                            @if (session()->has('errorAmount'))
                                            <div class="alert alert-danger">
                                                {{ session('errorAmount') }}
                                            </div>
                                            @endif
                                        </td>
                                        <td style="text-align: end;">
                                            <button type="button" class="btn btn-cta btn-sm" wire:click="addItem"><i
                                                    class="material-icons text-white"
                                                    style="font-size: 15px;">add</i>Add Item</button>
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
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        @if (session()->has('errro'))
                        <div class="alert alert-danger">
                            {{ session('errro') }}
                        </div>
                        @endif
                        @if($activeTab>1)
                        <button type="button" class="btn btn-dark mx-2 btn-sm"
                            wire:click="TabChange({{$activeTab-1}})"><i
                                class="material-icons text-white">chevron_left</i>Previous</button>
                        <button type="submit" class="btn btn-primary mx-2 btn-sm"><i
                                class="material-icons text-white">add</i>Update Order</button>
                        @endif
                        @if($activeTab==1)
                        <button type="button" class="btn btn-cta mx-2 btn-sm"
                            wire:click="TabChange({{$activeTab+1}})">Next<i
                                class="material-icons text-white">chevron_right</i></button>
                        @endif

                    </div>
            </form>
            <!-- Tabs content -->

        </div>
    </div>
</div>