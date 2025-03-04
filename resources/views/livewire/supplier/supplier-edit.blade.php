<div class="container">
    <section class="admin__title">
        <h5>Update Supplier</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="{{ route('suppliers.index') }}">Supplier List</a></li>
            <li>Edit Customer</li>
            <li class="back-button">
              <a class="btn btn-sm btn-danger select-md text-light font-weight-bold mb-0" href="{{ route('suppliers.index') }}" role="button">
                <i class="material-icons text-white" style="font-size: 15px;">chevron_left</i>
                <span class="ms-1">Back</span>
              </a>
            </li>
          </ul>
    </section>
    <div class="card card-body">
        <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
                <div class="row mt-2">
                     {{-- Supplier Information --}}
                     <div class="col-md-8 d-flex align-items-center">
                        <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                    </div>
                    
                </div>
            </div>
            
            <div class="card-body p-3">
                <form wire:submit.prevent="updateSupplier">
                    <div class="row mb-2">
                        <!-- Supplier Details -->
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="name" id="name" class="form-control form-control-sm border border-2 p-2" placeholder="Enter supplier name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" wire:model="email" id="email" class="form-control form-control-sm border border-2 p-2" placeholder="Enter email address">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="mobile" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" id="mobile" wire:model="mobile" class="form-control form-control-sm border border-2 p-2" placeholder="Enter mobile number">
                            @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="is_wa_same" class="form-label">WhatsApp number <span class="text-danger">*</span></label>
                                <div class="align-items-center">
                                <input type="text" wire:model="whatsapp_no" id="whatsapp_no" class="form-control form-control-sm border border-2 p-2 me-2" placeholder="Enter WhatsApp number" @if ($is_wa_same) disabled @endif>

                                <div class="custon-input-group">
                                    <input type="checkbox" id="is_wa_same" wire:change="SameAsMobile" value="0" @if ($is_wa_same) checked @endif>
                                    <label for="is_wa_same" class="form-check-label ms-2" >Same as Mobile</label>
                                </div>
                            </div>
                            @error('whatsapp_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="col-md-8 mb-2 d-flex align-items-center">
                        <h6 class="badge bg-danger custom_danger_badge">Address Information</h6>
                    </div>
                    <div class="row mb-3">
                        <div class="mb-3 col-md-4">
                            <label for="billing_address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_address" id="billing_address" class="form-control form-control-sm border border-2 p-2" placeholder="Enter billing address">
                            @error('billing_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_landmark" class="form-label">Landmark</label>
                            <input type="text" wire:model="billing_landmark" id="billing_landmark" class="form-control form-control-sm border border-2 p-2" placeholder="Enter landmark">
                            @error('billing_landmark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_city" id="billing_city" class="form-control form-control-sm border border-2 p-2" placeholder="Enter city">
                            @error('billing_city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_state" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_state" id="billing_state" class="form-control form-control-sm border border-2 p-2" placeholder="Enter state">
                            @error('billing_state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" wire:model="billing_country" id="billing_country" class="form-control form-control-sm border border-2 p-2" placeholder="Enter country">
                            @error('billing_country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="billing_pin" class="form-label">Zip Code</label>
                            <input type="text" wire:model="billing_pin" id="billing_pin" class="form-control form-control-sm border border-2 p-2" placeholder="Enter PIN">
                            @error('billing_pin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- Account Information --}}
                    <div class="col-md-8 mb-2 d-flex align-items-center">
                        <h6 class="badge bg-danger custom_danger_badge">Account Information</h6>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="gst_number" class="form-label">GST Number</label>
                            <input type="text" wire:model="gst_number" id="gst_number" class="form-control form-control-sm border border-2 p-2" placeholder="Enter GST number">
                            @error('gst_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="gst_file" class="form-label">GST File</label>
                            <input type="file" wire:model="gst_file" id="gst_file" class="form-control form-control-sm border border-2 p-2">
                            @if ($this->existingGstFile)
                            <div class="mt-2">
                                <img src="{{ asset($this->existingGstFile) }}" alt="gst Image" class="img-thumbnail" style="max-width: 100px;">
                            </div>
                            @endif
                            @error('gst_file')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="credit_limit" class="form-label">Credit Limit</label>
                            <input type="number" wire:model="credit_limit" id="credit_limit" class="form-control form-control-sm border border-2 p-2" placeholder="Enter credit limit">
                            @error('credit_limit')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="credit_days" class="form-label">Credit Days</label>
                            <input type="number" wire:model="credit_days" id="credit_days" class="form-control form-control-sm border border-2 p-2" placeholder="Enter credit days">
                            @error('credit_days')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-success select-md"><i class="material-icons me-1">update</i>Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
