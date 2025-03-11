<div class="container-fluid px-2 px-md-4">
    <section class="admin__title">
        <h5>Edit Customer</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="{{ route('customers.index') }}">Customers</a></li>
            <li>Edit Customer</li>
            <li class="back-button">
              <a class="btn btn-sm btn-danger select-md text-light font-weight-bold mb-0" href="{{ route('customers.index') }}" role="button">
                <i class="material-icons text-white" style="font-size: 15px;">chevron_left</i>
                <span class="ms-1">Back</span>
              </a>
            </li>
          </ul>
    </section>
    <div class="card card-body">
        <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
                <div class="row justify-content-between">
                    {{-- Customer Details --}}
                    <div class="col-md-8">
                        <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative ms-3">
                            <input type="text" wire:keyup="FindCountry($event.target.value)"
                                wire:model.debounce.500ms="searchTerm"
                                class="form-control form-control-sm border border-1 customer_input"
                                placeholder="Search By Country">
                            @error('searchTerm')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
                </div>
            </div>
            
            <div class="card-body p-3">
                
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Customer Details -->
                        <div class="mb-3 col-md-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select wire:model="prefix" class="form-control form-control-sm border border-1" style="max-width: 60px;">
                                    <option value="" selected hidden>Prefix</option>
                                    @foreach (App\Helpers\Helper::getNamePrefixes() as $prefix)
                                        <option value="{{$prefix}}">{{ $prefix }}</option>
                                    @endforeach
                                </select>
                                <input type="text" wire:model="name" id="name" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Customer Name">
                            </div>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" wire:model="company_name" id="company_name" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Company Name">
                            @error('company_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="employee_rank" class="form-label"> Rank </label>
                            <input type="text" wire:model="employee_rank" class="form-control form-control-sm border border-1 p-2" placeholder="Enter rank">
                            @error('employee_rank')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" wire:model="email" id="email" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Email">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="dob" class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                            <input type="date" wire:model="dob" id="dob" class="form-control form-control-sm border border-1 p-2" max="{{now()->format('Y-m-d')}}">
                            
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <div class="extention-group">
                                <input class="input__prefix form-control form-control-sm border border-1" wire:model="country_code" type="text" name="country_code" id="country_code"  readonly>
                                <input type="text" wire:model="phone" id="phone" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Phone Number" maxLength={{$mobileLength}}>
                            </div>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="whatsapp_no" class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                            <div class="extention-group">
                                <input class="input__prefix form-control form-control-sm border border-1" wire:model="country_code" type="text" name="country_code" id="country_code"  readonly>
                                <input type="text" wire:model="whatsapp_no" id="whatsapp_no" class="form-control form-control-sm border border-1 p-2" @if($is_wa_same) disabled @endif placeholder="Enter Whatsapp Number" maxLength={{$mobileLength}}>
                            </div>
                            <div class="custon-input-group">
                                <input type="checkbox" id="is_wa_same" wire:change="SameAsMobile" value="0" @if($is_wa_same) checked @endif>
                                <label for="is_wa_same" class="form-check-label ms-2">Same as Phone Number</label>
                            </div>
                            @error('whatsapp_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="mobile" class="form-label">alternative phone number 1 </label>
                            <div class="extention-group">
                                <input class="input__prefix form-control form-control-sm border border-1" wire:model="country_code" type="text" name="country_code" id="country_code"  readonly>
                                <input type="text" wire:model="alternative_phone_number_1" class="form-control form-control-sm border border-1 p-2" placeholder="Alternative Phone No" maxLength={{$mobileLength}}>
                            </div>
                            @error('alternative_phone_number_1')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="mobile" class="form-label">alternative phone number 2 </label>
                            <div class="extention-group">
                                <input class="input__prefix form-control form-control-sm border border-1" wire:model="country_code" type="text" name="country_code" id="country_code"  readonly>
                                <input type="text" wire:model="alternative_phone_number_2" class="form-control form-control-sm border border-1 p-2" placeholder="Alternative Phone No" maxLength={{$mobileLength}}>
                            </div>
                            @error('alternative_phone_number_2')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="image" class="form-label">Profile Image <span class="text-danger">*</span></label>
                            <input type="file" wire:model="image" id="image" class="form-control form-control-sm border border-1 p-2">
                            @if($this->image)
                                <div class="mt-2">
                                    <img src="{{ asset($this->image) }}" alt="Profile Image" class="img-thumbnail" style="max-width: 100px;">
                                </div>
                           @endif
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="verified_video" class="form-label">Verified Video</label>
                            <input type="file" wire:model="verified_video" id="verified_video" class="form-control form-control-sm border border-1 p-2">
                            @if($verified_video)
                                <div class="mt-2">
                                    <video controls width="200">
                                        <source src="{{ asset($verified_video) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endif
                            @error('verified_video')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <h6 class="badge bg-danger custom_danger_badge">Billing Address</h6>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="billing_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_address" id="billing_address" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Billing Address">
                            @error('billing_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="billing_landmark" class="form-label"> Landmark</label>
                            <input type="text" wire:model="billing_landmark" id="billing_landmark" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Landmark">
                            @error('billing_landmark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="billing_city" class="form-label"> City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_city" id="billing_city" class="form-control form-control-sm border border-1 p-2" placeholder="Enter city">
                            @error('billing_city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="billing_state" class="form-label"> State <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_state" id="billing_state" class="form-control form-control-sm border border-1 p-2" placeholder="Enter state">
                            @error('billing_state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="billing_country" class="form-label"> Country <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_country" id="billing_country" class="form-control form-control-sm border border-1 p-2" placeholder="Enter country">
                            @error('billing_country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="billing_pin" class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input type="number" wire:model="billing_pin" id="billing_pin" class="form-control form-control-sm border border-1 p-2" placeholder="Enter PIN">
                            @error('billing_pin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <h6 class="badge bg-danger custom_danger_badge mb-3">Shipping Address</h6>
                        <div class="d-flex align-items-center custom-checkbox">
                            <input type="checkbox"  wire:change="toggleShippingAddress" wire:model="is_billing_shipping_same" id="isBillingShippingSame" class="form-check-input border border-1" @if ($is_billing_shipping_same) checked @endif>
                            <i></i>
                            <label for="isBillingShippingSame" class="form-check-label">Shipping address same as billing</label>
                        </div>
                    </div>
                    <!-- Shipping Address -->
                  
                    <div class="row mb-3">
                        <div class="mb-3 col-md-6">
                            <label for="shipping_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_address" id="shipping_address" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Shipping Address" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="shipping_landmark" class="form-label"> Landmark</label>
                            <input type="text" wire:model="shipping_landmark" id="shipping_landmark" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Landmark" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_landmark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="shipping_city" class="form-label"> City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_city" id="shipping_city" class="form-control form-control-sm border border-1 p-2" placeholder="Enter City" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="shipping_state" class="form-label"> State <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_state" id="shipping_state" class="form-control form-control-sm border border-1 p-2" placeholder="Enter State" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="shipping_country" class="form-label"> Country <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_country" id="shipping_country" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Country" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="shipping_pin" class="form-label"> Zip Code <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_pin" id="shipping_pin" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Zip Code" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_pin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- Account Information --}}
                    {{-- <h6 class="badge bg-danger custom_danger_badge mb-3">Account information</h6>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="gst_number" class="form-label">GST Number</label>
                            <input type="text" wire:model="gst_number" id="gst_number" class="form-control form-control-sm border border-1 p-2" placeholder="Enter GST Number">
                            @error('gst_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="gst_certificate_image" class="form-label">GST Certificate Image</label>
                            <input type="file" wire:model="gst_certificate_image" id="gst_certificate_image" class="form-control form-control-sm border border-1 p-2">
                            @if ($this->gst_certificate_image)
                                <div class="mt-2">
                                    <img src="{{ asset($this->gst_certificate_image) }}" alt="Gst Certificate Image" class="img-thumbnail" style="max-width: 100px;">
                                </div>
                            @endif
                            @error('gst_certificate_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="credit_limit" class="form-label">Credit Limit</label>
                            <input type="number" wire:model="credit_limit" id="credit_limit" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Credit Limit">
                            @error('credit_limit')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="credit_days" class="form-label">Credit Days</label>
                            <input type="number" wire:model="credit_days" id="credit_days" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Credit Days">
                            @error('credit_days')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <button type="submit" class="btn btn-outline-success select-md"><i class="material-icons me-1" >update</i>Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
