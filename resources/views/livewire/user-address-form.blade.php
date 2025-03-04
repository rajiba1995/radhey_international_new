<div class="container-fluid px-2 px-md-4">
    <section class="admin__title">
        <h5>Create Customer</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="{{url('admin/customers')}}">Customers</a></li>
            <li>Create Customer</li>
            <li class="back-button">
              <a class="btn btn-dark btn-sm text-decoration-none text-light font-weight-bold mb-0" href="{{ route('customers.index') }}" role="button">
                <i class="material-icons text-white" style="font-size: 15px;">chevron_left</i>
                <span class="ms-1">Back</span>
              </a>
            </li>
          </ul>
    </section>
    <div class="card card-body">
        <!-- <h4 class="m-0">Create Customer</h4> -->
        <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    {{-- Customer Details --}}
                    <div class="col-md-8 d-flex align-items-center">
                        <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                    </div>

                </div>
            </div>
            
            <div class="card-body p-3">
                <form wire:submit.prevent="save">
                    <div class="row mb-3">
                        <!-- Customer Details -->
                        <div class="mb-3 col-md-4">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="name" id="name" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Customer Name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" wire:model="company_name" id="company_name" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Company Name">
                            @error('company_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="employee_rank" class="form-label"> Rank</label>
                            <input type="text" wire:model="employee_rank" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Rank">
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
                            <input type="date" wire:model="dob" id="dob" class="form-control form-control-sm border border-1 p-2">
                            
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="phone" class="form-label">Phone Number<span class="text-danger">*</span></label>
                            <input type="text" wire:model="phone" id="phone" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Phone Number">
                            
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="whatsapp_no" class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                            <input type="text" wire:model="whatsapp_no" id="whatsapp_no" class="form-control form-control-sm border border-1 p-2" @if($is_wa_same) disabled @endif placeholder="Enter Whatsapp Number">

                            <input type="checkbox" id="is_wa_same" wire:change="SameAsMobile" value="0" @if($is_wa_same) checked @endif>
                            <label for="is_wa_same" class="form-check-label ms-2">Same as Phone Number</label>
                            @error('whatsapp_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="image" class="form-label">Profile Image </label>
                            <input type="file" wire:model="image" id="image" class="form-control form-control-sm border border-1 p-2">
                            @if($tempImageUrl)
                               <img src="{{ $tempImageUrl }}" class="img-thumbnail mt-2" width="100">
                            @endif
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="verified_video" class="form-label">Verified Video</label>
                            <input type="file" wire:model="verified_video" id="verified_video" class="form-control form-control-sm border border-1 p-2">
                            
                            @error('verified_video')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <h6 class="badge bg-danger custom_danger_badge">Billing Address</h6>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="billing_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_address" id="billing_address" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Billing Address">
                            @error('billing_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_landmark" class="form-label"> Landmark</label>
                            <input type="text" wire:model="billing_landmark" id="billing_landmark" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Landmark">
                            @error('billing_landmark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_city" class="form-label"> City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_city" id="billing_city" class="form-control form-control-sm border border-1 p-2" placeholder="Enter City">
                            @error('billing_city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_state" class="form-label"> State </label>
                            <input type="text" wire:model="billing_state" id="billing_state" class="form-control form-control-sm border border-1 p-2" placeholder="Enter State">
                            @error('billing_state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_country" class="form-label"> Country <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_country" id="billing_country" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Country">
                            @error('billing_country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_pin" class="form-label">Zip Code</label>
                            <input type="number" wire:model="billing_pin" id="billing_pin" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Zip Code">
                            @error('billing_pin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class=" d-flex justify-content-between mt-4">
                        <h6 class="badge bg-danger custom_danger_badge mb-3">Shipping Address</h6>
                      <div class="d-flex align-item-center">
                        <input type="checkbox"  wire:change="toggleShippingAddress" wire:model="is_billing_shipping_same" id="isBillingShippingSame" class="form-check-input border border-1" @if ($is_billing_shipping_same) checked @endif>
                        <label for="isBillingShippingSame" class="form-check-label"><span class="badge bg-secondary">Shipping Address Same As Billing</span></label>
                      </div>
                    </div>
                    
                    <!-- Shipping Address -->
                    <div class="row mb-4">
                        <div class="mb-3 col-md-4">
                            <label for="shipping_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_address" id="shipping_address" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Shipping Address" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_landmark" class="form-label"> Landmark </label>
                            <input type="text" wire:model="shipping_landmark" id="shipping_landmark" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Landmark" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_landmark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_city" class="form-label"> City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_city" id="shipping_city" class="form-control form-control-sm border border-1 p-2" placeholder="Enter City" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_state" class="form-label"> State </label>
                            <input type="text" wire:model="shipping_state" id="shipping_state" class="form-control form-control-sm border border-1 p-2" placeholder="Enter State" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_country" class="form-label"> Country <span class="text-danger">*</span></label>
                            <input type="text" wire:model="shipping_country" id="shipping_country" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Country" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="shipping_pin" class="form-label"> Zip Code</label>
                            <input type="text" wire:model="shipping_pin" id="shipping_pin" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Zip Code" @if($is_billing_shipping_same) disabled @endif>
                            @error('shipping_pin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- <h6 class="badge bg-danger custom_danger_badge mb-3">Account Information</h6>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="gst_number" class="form-label">GST Number</label>
                            <input type="text" wire:model="gst_number" id="gst_number" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Gst Number">
                            @error('gst_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="gst_certificate_image" class="form-label">GST Certificate Image</label>
                            <input type="file" wire:model="gst_certificate_image" id="gst_certificate_image" class="form-control form-control-sm border border-1 p-2">
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
                    <button type="submit"class="btn btn-sm btn-success"><i class="material-icons text-white" style="font-size: 15px;">add</i>Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
