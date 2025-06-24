<div class="container">
    <section class="admin__title">
        <h5>{{$payment_voucher_no?"Edit Payment Receipt":"Add Payment Receipt"}}</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="{{route('admin.accounting.payment_collection')}}">Payment Collection</a></li>
            <li>{{$payment_voucher_no?"Edit Payment Receipt":"Add Payment Receipt"}}</li>
            <li class="back-button">
                <a class="btn btn-sm btn-danger select-md text-light font-weight-bold mb-0"
                    href="{{route('admin.accounting.payment_collection')}}" role="button">
                    < Back </a>
            </li>
        </ul>
    </section>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form wire:submit.prevent="submitForm">
                        @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="" id="">Customer <span class="text-danger">*</span></label>

                                    <div class="position-relative">
                                        @if($new_customer)
                                        <input type="text" wire:model="customer_name"
                                            class="form-control form-control-sm border border-1 customer_input"
                                            placeholder="Please enter customer name">
                                        @if(isset($errorMessage['customer_name']))
                                        <div class="text-danger">{{ $errorMessage['customer_name'] }}</div>
                                        @endif
                                        {{-- Add email,mobile,address,company name --}}
                                        @if($new_customer)
                                        <div class="card mt-2">
                                            <div class="card-body p-2">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label for="phone" class="form-label">Phone Number <span
                                                                class="text-danger">*</span></label>
                                                        <div class="extention-group">
                                                            <!-- Country Select Dropdown for Phone -->
                                                            <select wire:model="selectedCountryPhone"
                                                                wire:change="GetCountryDetails($event.target.selectedOptions[0].getAttribute('data-length'), 'phone')"
                                                                class="form-control form-control-sm prefix_select flex-30">
                                                                <option value="" selected hidden>Code</option>
                                                                @foreach($countries as $country)
                                                                <option value="{{ $country->country_code }}"
                                                                    data-length="{{ $country->mobile_length }}">
                                                                    {{ $country->title }} ({{ $country->country_code }})
                                                                </option>
                                                                @endforeach
                                                            </select>

                                                            <!-- Phone Input Field -->
                                                            <input type="text" wire:model="phone" id="phone"
                                                                class="form-control form-control-sm border border-1 p-2 {{ $errorClass['phone'] ?? '' }}"
                                                                placeholder="Enter Phone Number"
                                                                maxlength="{{$mobileLengthPhone}}">

                                                            <!-- Error Message -->
                                                        </div>
                                                        @if(isset($errorMessage['phone']))
                                                        <div class="text-danger">{{ $errorMessage['phone']
                                                            }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <label>Email</label>
                                                            <input type="email" wire:model="customer_email"
                                                                class="form-control form-control-sm"
                                                                placeholder="Enter email">
                                                            @if(isset($errorMessage['customer_email']))
                                                            <div class="text-danger">{{ $errorMessage['customer_email']
                                                                }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <label>Company Name</label>
                                                            <input type="text" wire:model="customer_company"
                                                                class="form-control form-control-sm"
                                                                placeholder="Enter company name">
                                                            @if(isset($errorMessage['customer_company']))
                                                            <div class="text-danger">{{
                                                                $errorMessage['customer_company'] }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group mb-3">
                                                            <label>Address</label>
                                                            <input type="text" wire:model="customer_address"
                                                                class="form-control form-control-sm"
                                                                placeholder="Enter address">
                                                            @if(isset($errorMessage['customer_address']))
                                                            <div class="text-danger">{{
                                                                $errorMessage['customer_address'] }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @else
                                        <input type="text" wire:keyup="FindCustomer($event.target.value)"
                                            wire:model="customer"
                                            class="form-control form-control-sm border border-1 customer_input"
                                            placeholder="Search customer by name, mobile, order ID" {{$readonly}}>
                                        <input type="hidden" wire:model="customer_id" value="">
                                        @if(isset($errorMessage['customer_id']))
                                        <div class="text-danger">{{ $errorMessage['customer_id'] }}</div>
                                        @endif
                                        @if(!empty($searchResults))
                                        <div id="fetch_customer_details" class="dropdown-menu show w-100"
                                            style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($searchResults as $customer)
                                            <button class="dropdown-item" type="button"
                                                wire:click="selectCustomer({{ $customer->id }})">
                                                <img src="{{ $customer->profile_image ? asset($customer->profile_image) : asset('assets/img/user.png') }}"
                                                    alt=""> {{ ucfirst($customer->prefix . " ".$customer->name) }} ({{
                                                $customer->phone }})
                                            </button>
                                            @endforeach
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                    <div class="is-filled form-check-label-group ">
                                        <input type="checkbox" id="new_customer" wire:model="new_customer"
                                            wire:change="changeNewCustomer">
                                        <label for="new_customer" class="mt-0 text-primary cursor-pointer ms-1">New
                                            Customer</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="" id="">Collected By <span class="text-danger">*</span></label>
                                    @if ($my_designation == 1)
                                    <select wire:model="staff_id" class="form-control form-control-sm">
                                        <option value="">Choose an user</option>
                                        @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}">{{ucwords($staff->name)}}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $staffs->first()->name }}" disabled>
                                    <input type="hidden" wire:model="staff_id">
                                    @endif
                                    @if(isset($errorMessage['staff_id']))
                                    <div class="text-danger">{{ $errorMessage['staff_id'] }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="">Amount <span class="text-danger">*</span></label>
                                    <input type="text" value="" maxlength="20" wire:model="amount"
                                        oninput="validateNumber(this)" class="form-control form-control-sm">
                                    @if(isset($errorMessage['amount']))
                                    <div class="text-danger">{{ $errorMessage['amount'] }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="">Voucher No</label>
                                    <input type="text" wire:model="voucher_no" class="form-control form-control-sm"
                                        disabled {{$readonly}}>
                                    @if(isset($errorMessage['voucher_no']))
                                    <div class="text-danger">{{ $errorMessage['voucher_no'] }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="">Date <span class="text-danger">*</span></label>
                                    <input type="date" wire:model="payment_date" id="payment_date"
                                        max="{{date('Y-m-d')}}" class="form-control form-control-sm" value=""
                                        {{$readonly}}>
                                    @if(isset($errorMessage['payment_date']))
                                    <div class="text-danger">{{ $errorMessage['payment_date'] }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">

                                <div class="form-group mb-3">
                                    <label for="">Mode of Payment <span class="text-danger">*</span></label>
                                    <select wire:model="payment_mode" class="form-control form-control-sm"
                                        id="payment_mode" @if($readonly) @else
                                        wire:change="ChangePaymentMode($event.target.value)" @endif {{$readonly}}>
                                        @if($readonly)
                                        <option value="cheque" {{$payment_mode=="cheque" ?"selected":"hidden"}}>Cheque
                                        </option>
                                        <option value="neft" {{$payment_mode=="neft" ?"selected":"hidden"}}>NEFT
                                        </option>
                                        <option value="cash" {{$payment_mode=="cash" ?"selected":"hidden"}}>Cash
                                        </option>
                                        @else
                                        <option value="" selected="" hidden="">Select Payment Method</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="neft">NEFT</option>
                                        <option value="cash">Cash</option>
                                        @endif
                                    </select>
                                    @if(isset($errorMessage['payment_mode']))
                                    <div class="text-danger">{{ $errorMessage['payment_mode'] }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($activePayementMode!=="cash")
                        <div class="row" id="noncash_sec">
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="">Cheque No / UTR No </label>
                                    <input type="text" value="" wire:model="chq_utr_no"
                                        class="form-control form-control-sm" maxlength="100" {{$readonly}}>
                                    @if(isset($errorMessage['chq_utr_no']))
                                    <div class="text-danger">{{ $errorMessage['chq_utr_no'] }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="">Bank Name </label>
                                    <div id="bank_search">
                                        <input type="text" id="" placeholder="Search Bank" wire:model="bank_name"
                                            value="" class="form-control form-control-sm bank_name" maxlength="200"
                                            {{$readonly}}>
                                        @if(isset($errorMessage['bank_name']))
                                        <div class="text-danger">{{ $errorMessage['bank_name'] }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="form-group text-end">
                                <button type="submit" id="submit_btn"
                                    class="btn btn-sm btn-success select-md">{{$payment_voucher_no?"Update Receipt":"Add
                                    Receipt"}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="loader-container" wire:loading>
        <div class="loader"></div>
    </div>
</div>
@push('js')
<script>
    function validateNumber(input) {
        // Remove any characters that are not digits or a single decimal point
        input.value = input.value.replace(/[^0-9.]/g, '');
        
        // Ensure only one decimal point is allowed
        const parts = input.value.split('.');
        if (parts.length > 2) {
        input.value = parts[0] + '.' + parts[1];
        }
    }
</script>
@endpush