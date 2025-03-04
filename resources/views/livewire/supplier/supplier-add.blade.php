<div class="container">
    <section class="admin__title">
        <h5>Create Supplier</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="{{ route('suppliers.index') }}">Supplier List</a></li>
            <li>Create Customer</li>
            <li class="back-button">
              <a class="btn btn-dark btn-sm text-decoration-none text-light font-weight-bold mb-0" href="{{ route('suppliers.index') }}" role="button">
                <i class="material-icons text-white" style="font-size: 15px;">chevron_left</i>
                <span class="ms-1">Back</span>
              </a>
            </li>
        </ul>
    </section>
    <div class="card card-body">
        <!-- <h4 class="m-0">Create Supplier</h4> -->
        <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    {{-- Supplier Information --}}
                    <div class="col-md-8 d-flex align-items-center">
                        <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-3">
                <form wire:submit.prevent="save">
                    <div class="row">
                        <!-- Supplier Details -->
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="name" id="name" class="form-control form-control-sm border border-1 p-2" placeholder="Enter supplier name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" wire:model="email" id="email" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Email Address">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-md-6">
                            <label for="mobile" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" id="mobile" wire:model="mobile" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Phone Number">
                            @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-md-6">
                            <label for="is_wa_same" class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                                <div class="align-items-center">
                                <input type="text" wire:model="whatsapp_no" id="whatsapp_no" class="form-control form-control-sm border border-1 p-2 me-2" placeholder="Enter WhatsApp Number" @if ($is_wa_same) disabled @endif>
                                
                                <div class="custon-input-group">
                                    <input type="checkbox" id="is_wa_same" wire:change="SameAsMobile" value="0" @if ($is_wa_same) checked @endif>
                                    <label for="is_wa_same" class="form-check-label ms-2" >Same as Mobile</label>
                                </div>
                                <!-- <input type="checkbox" wire:model="is_wa_same" id="isWaSame" class="form-check-input">
                                <label for="isWaSame" class="form-check-label">WhatsApp number same as mobile</label> -->
                            </div>
                            @error('whatsapp_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror        
                        </div>
                        

                        <!-- Billing Address -->
                        <div class="col-md-8 mb-2 d-flex align-items-center">
                            <h6 class="badge bg-danger custom_danger_badge">Address Information</h6>
                        </div>
                    <div class="row mb-3">
                        <div class="mb-3 col-md-4">
                            <label for="billing_address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_address" id="billing_address" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Address">
                            @error('billing_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_landmark" class="form-label">Landmark</label>
                            <input type="text" wire:model="billing_landmark" id="billing_landmark" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Landmark">
                            @error('billing_landmark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_city" id="billing_city" class="form-control form-control-sm border border-1 p-2" placeholder="Enter City">
                            @error('billing_city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_state" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_state" id="billing_state" class="form-control form-control-sm border border-1 p-2" placeholder="Enter State">
                            @error('billing_state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_country" id="billing_country" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Country">
                            @error('billing_country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_pin" class="form-label">Zip Code </label>
                            <input type="text" wire:model="billing_pin" id="billing_pin" class="form-control form-control-sm border border-1 p-2" placeholder="Enter Zip Code">
                            @error('billing_pin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                   
                    <div class="col-md-8 mb-2 d-flex align-items-center">
                        <h6 class="badge bg-danger custom_danger_badge">Account Information</h6>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="gst_number" class="form-label">GST Number</label>
                            <input type="text" wire:model="gst_number" id="gst_number" class="form-control form-control-sm border border-1 p-2" placeholder="Enter GST Number">
                            @error('gst_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="gst_file" class="form-label">GST File</label>
                            <input type="file" wire:model="gst_file" id="gst_file" class="form-control form-control-sm border border-1 p-2">

                            @error('gst_file')
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
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-success select-md"><i class="material-icons me-1" >add</i>Add</button>
            </form>
        </div>
    </div>
</div>

