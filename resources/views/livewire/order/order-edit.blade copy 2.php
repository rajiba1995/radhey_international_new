
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
              
                @if($activeTab==1)
                <a href="{{route('admin.order.index')}}" class="btn btn-dark"> <i
                        class="material-icons text-white">chevron_left</i>
                    Back </a>
                @endif
            </div>
        </div>

        <div class="card-body" id="sales_order_data">
            <form wire:submit.prevent="update">
                <div class="{{$activeTab==1?"d-block":"d-none"}}" id="tab1">
                   
                    <!-- Customer Details -->
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                    </div>
                    <!-- Customer Details -->
                    <div class="container">
                        <!-- Customer Details -->
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <input type="hidden" name="customer_id" wire:model="customer_id">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="name" id="name"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['name'] ?? '' }}"
                                    placeholder="Enter Customer Name">
                                @if(isset($errorMessage['name']))
                                <div class="text-danger">{{ $errorMessage['name'] }}</div>
                                @endif
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" wire:model="company_name" id="company_name"
                                    class="form-control form-control-sm border border-1 p-2"
                                    placeholder="Enter Company Name">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="employee_rank" class="form-label"> Rank</label>
                                <input type="text" wire:model="employee_rank" id="employee_rank"
                                    class="form-control form-control-sm border border-1 p-2" placeholder="Enter Rank">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" wire:model="email" id="email"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['email'] ?? '' }}"
                                    placeholder="Enter Email">
                                @if(isset($errorMessage['email']))
                                  <div class="text-danger">{{ $errorMessage['email'] }}</div>
                                @endif
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="dob" class="form-label">Date Of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="date" wire:model="dob" id="dob" max="{{date('Y-m-d')}}"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['dob'] ?? '' }}">
                                @if(isset($errorMessage['dob']))
                                <div class="text-danger">{{ $errorMessage['dob'] }}</div>
                                @endif
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="phone" class="form-label">Phone Number<span class="text-danger">*</span></label>
                                <input type="text" wire:model="phone" id="phone"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['phone'] ?? '' }}"
                                    placeholder="Enter Phone Number">
                                @if(isset($errorMessage['phone']))
                                <div class="text-danger">{{ $errorMessage['phone'] }}</div>
                                @endif
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="whatsapp_no" class="form-label">WhatsApp Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" wire:model="whatsapp_no" id="whatsapp_no"
                                    class="form-control form-control-sm border border-1 p-2 {{ $errorClass['whatsapp_no'] ?? '' }}"
                                    placeholder="Enter WhatsApp Number" @if($whatsapp_no)disabled @endif>
                                @if(isset($errorMessage['whatsapp_no']))
                                <div class="text-danger">{{ $errorMessage['whatsapp_no'] }}</div>
                                @endif
                                <input type="checkbox" id="is_wa_same" wire:change="SameAsMobile" value="0"
                                    @if($is_wa_same) checked @endif>
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
                            <label for="billing_address" class="form-label">Street Address <span
                                    class="text-danger">*</span></label>
                            <textarea wire:model="billing_address" id="billing_address" cols="30" rows="3"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_address'] ?? '' }}"
                                placeholder="Enter billing address"></textarea>
                            @if(isset($errorMessage['billing_address']))
                            <div class="text-danger">{{ $errorMessage['billing_address'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="billing_landmark" class="form-label">Landmark</label>
                            <input type="text" wire:model="billing_landmark" id="billing_landmark"
                                class="form-control form-control-sm border border-1 p-2" placeholder="Enter landmark">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="billing_city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_city" id="billing_city"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_city'] ?? '' }}"
                                placeholder="Enter city">
                            @if(isset($errorMessage['billing_city']))
                            <div class="text-danger">{{ $errorMessage['billing_city'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="billing_state" class="form-label">State </label>
                            <input type="text" wire:model="billing_state" id="billing_state"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_state'] ?? '' }}"
                                placeholder="Enter state">
                            @if(isset($errorMessage['billing_state']))
                            <div class="text-danger">{{ $errorMessage['billing_state'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="billing_country" class="form-label">Country <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_country" id="billing_country"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_country'] ?? '' }}"
                                placeholder="Enter country">
                            @if(isset($errorMessage['billing_country']))
                            <div class="text-danger">{{ $errorMessage['billing_country'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="billing_pin" class="form-label">Zip Code <span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model="billing_pin" id="billing_pin"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['billing_pin'] ?? '' }}"
                                placeholder="Enter PIN">
                            @if(isset($errorMessage['billing_pin']))
                            <div class="text-danger">{{ $errorMessage['billing_pin'] }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <h6 class="badge bg-danger custom_danger_badge">Shipping Address</h6>
                        <div class="form-check">
                            <input type="checkbox" wire:change="toggleShippingAddress"
                                wire:model="is_billing_shipping_same" id="isBillingShippingSame"
                                class="form-check-input" @if ($is_billing_shipping_same) checked @endif>
                            <label for="isBillingShippingSame" class="form-check-label"><span
                                    class="badge bg-secondary">Shipping address same as billing</span></label>
                        </div>
                    </div>

                    {{-- Shipping Address Panel --}}
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="shipping_address" class="form-label">Street Address <span
                                    class="text-danger">*</span></label>
                            <textarea wire:model="shipping_address" id="shipping_address"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_address'] ?? '' }}"
                                placeholder="Enter shipping address" @if ($shipping_address)
                                    disabled
                                @endif></textarea>
                            @if(isset($errorMessage['shipping_address']))
                            <div class="text-danger">{{ $errorMessage['shipping_address'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="shipping_landmark" class="form-label">Landmark</label>
                            <input type="text" wire:model="shipping_landmark" id="shipping_landmark"
                                class="form-control form-control-sm border border-1 p-2" placeholder="Enter landmark">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="shipping_city" class="form-label">City <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_city" id="shipping_city"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_city'] ?? '' }}"
                                placeholder="Enter city" @if ($shipping_city)
                                    disabled
                                @endif>
                            @if(isset($errorMessage['shipping_city']))
                            <div class="text-danger">{{ $errorMessage['shipping_city'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="shipping_state" class="form-label">State </label>
                            <input type="text" wire:model="shipping_state" id="shipping_state"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_state'] ?? '' }}"
                                placeholder="Enter state" @if ($shipping_state)
                                    disabled
                                @endif>
                            @if(isset($errorMessage['shipping_state']))
                            <div class="text-danger">{{ $errorMessage['shipping_state'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="shipping_country" class="form-label">Country <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_country" id="shipping_country"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_country'] ?? '' }}"
                                placeholder="Enter country" @if ($shipping_country)
                                    disabled
                                @endif>
                            @if(isset($errorMessage['shipping_country']))
                            <div class="text-danger">{{ $errorMessage['shipping_country'] }}</div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="shipping_pin" class="form-label">Zip Code <span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model="shipping_pin" id="shipping_pin"
                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['shipping_pin'] ?? '' }}"
                                placeholder="Enter PIN" @if ($shipping_pin)
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
                    @foreach($items as $index => $item)
                        <div class="row align-items-center my-5">
                            <!-- Collection -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Collection </strong><span class="text-danger">*</span></label>
                                <select wire:model="items.{{ $index }}.selected_collection"
                                    wire:change="GetCategory($event.target.value, {{ $index }})"
                                    class="form-control border border-2 p-2 form-control-sm">
                                    <option value="" selected hidden>Select collection</option>
                                    @foreach($collections as $citems)
                                        <option value="{{ $citems->id }}" {{ $item['selected_collection'] == $citems->title ? 'selected' : '' }}>
                                            {{ ucwords($citems->title) }}
                                            @if($citems->short_code)
                                                ({{ $citems->short_code }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error("items.$index.selected_collection")
                                    <p class='text-danger inputerror'>{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Category -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Category</strong></label>
                                <select wire:model="items.{{ $index }}.selected_category"
                                    class="form-select form-control-sm border border-1"
                                    wire:change="CategoryWiseProduct($event.target.value, {{ $index }})">
                                    @foreach ($item['categories'] as $category)
                                        <option value="{{ $category->id }}" {{ $item['selected_category'] == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("items.$index.selected_category")
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Product -->
                            <div class="mb-3 col-md-{{ isset($item['selected_collection']) && $item['selected_collection'] == 1 ? '4' : '8' }}">
                                <label class="form-label"><strong>Product</strong></label>
                                <input type="text" wire:keyup="FindProduct($event.target.value, {{ $index }})"
                                    wire:model="items.{{ $index }}.searchproduct"
                                    class="form-control form-control-sm border border-1 customer_input"
                                    placeholder="Enter product name">
                                @if (session()->has('errorProduct.' . $index))
                                    <p class="text-danger">{{ session('errorProduct.' . $index) }}</p>
                                @endif
                                @if(isset($items[$index]['products']) && count($items[$index]['products']) > 0)
                                    <div id="fetch_customer_details" class="dropdown-menu show w-25" style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($items[$index]['products'] as $product)
                                            <button class="dropdown-item" type="button"
                                                wire:click='selectProduct({{ $index }}, "{{ $product->name }}", {{ $product->id }})'>
                                                <img src="{{ $product->product_image ? asset($product->product_image) : asset('assets/img/cubes.png') }}" alt="">
                                                {{ $product->name }} ({{ $product->product_code }})
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Catalogue and Page Number -->
                            @if(isset($item['selected_collection']) && $item['selected_collection'] == 1)
                                <div class="mb-3 col-md-2">
                                    <label class="form-label"><strong>Catalogue</strong></label>
                                    <select wire:model="items.{{ $index }}.selectedCatalogue" class="form-control form-control-sm border border-1"
                                        wire:change="SelectedCatalogue($event.target.value, {{ $index }})">
                                        <option value="" selected hidden>Select Catalogue</option>
                                        @foreach($item['catalogues'] ?? [] as $id => $cat_log)
                                            @if($cat_log['catalogue_title'])
                                                <option value="{{ $cat_log['id'] }}">
                                                    {{ $cat_log['catalogue_title']['title'] }}
                                                    @if(isset($maxPages[$index][$id]))
                                                        (1 - {{ $maxPages[$index][$id] }})
                                                    @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error("items.{$index}.selectedCatalogue")
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror 
                                </div>
                                
                                <div class="mb-3 col-md-2">
                                    <label class="form-label"><strong>Page Number</strong></label>
                                    <input type="number" wire:model="items.{{$index}}.page_number" wire:keyup="validatePageNumber({{ $index }})"
                                        class="form-control form-control-sm border border-2"
                                        min="1" max="{{ isset($item['selectedCatalogue']) && isset($maxPages[$index][$item['selectedCatalogue']]) ? $maxPages[$index][$item['selectedCatalogue']] : '' }}">
                                    @error("items.$index.page_number") 
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            
                            <!-- Price -->
                            <div class="mb-3 col-md-1">
                                <label class="form-label"><strong>Price</strong></label>
                                <input type="text" wire:keyup="checkproductPrice($event.target.value, {{ $index }})"
                                    wire:model="items.{{ $index }}.price"
                                    class="form-control form-control-sm border border-1 customer_input text-center">
                                @if(session()->has('errorPrice.' . $index))
                                    <div class="text-danger">{{ session('errorPrice.' . $index) }}</div>
                                @endif
                                @error('items.' . $index . '.price') 
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Delete Button -->
                            <div class="mb-3 col-md-1" style="margin-top: 19px;">
                                <button type="button" class="btn btn-danger btn-sm" wire:click="removeItem({{ $index }})">
                                    <span class="material-icons">delete</span>
                                </button>
                            </div>
                        </div>
                    @endforeach



                
                    <!-- Add Item Button -->

                    <div class="row align-items-end mb-4" style="justify-content: end;">

                        <div class="col-md-3" style="text-align: -webkit-center;">
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
                                        <button type="button" class="btn btn-success btn-sm" wire:click="addItem">Add Item</button>
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
                            </table>
                           
                        </div>
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


