<div class="container">
    <section class="admin__title">                
        <h5>Add Slip</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="{{route('admin.order.index')}}">Orders</a></li>
            <li>Order No:- <span>#{{$order->order_number}}</span></li>
            <li class="back-button">
                <a href="{{route('admin.order.index')}}" class="btn btn-sm btn-danger select-md text-light font-weight-bold mb-0">Back </a>
            </li>
          </ul>
    </section>
    <form wire:submit.prevent="submitForm">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
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
                            @foreach($order->items as $key=>$order_item)
                            @php
                                $magrin = '';
                                if($key!=0){
                                    $magrin = "margin-bottom: 20px;";
                                }
                            @endphp
                            <div class="col-sm-6">
                                <table>
                                    <tr>
                                        <td>
                                            <span class="text-sm badge bg-primary sale_grn_sl" style="{{$magrin}}">{{$key+1}}</span>
                                        </td>
                                        <td class="w-100"> 
                                            <div class="form-group mb-3">
                                            @if($key==0)
                                                <label>Product</label>
                                            @endif
                                            <div class="position-relative">
                                                <input type="hidden" wire:model="order_item.{{$key}}.price" class="form-control form-control-sm">
                                                <input type="hidden" wire:model="order_item.{{$key}}.id" class="form-control form-control-sm" value="{{$order_item->id}}">
                                                <input type="text" value="{{$order_item->product_name}}" class="form-control form-control-sm border border-1 customer_input" {{$readonly}}>
                                            </div>
                                        </div>
                                    </td>
                                    </tr>
                                </table>
                               
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    @if($key==0)
                                        <label>Required Quantity</label>
                                    @endif
                                    <input type="text" class="form-control form-control-sm" value="{{$order_item->quantity}}" disabled {{$readonly}}>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group mb-3">
                                    @if($key==0)
                                        <label for="">Disburse Quantity</label>
                                    @endif
                                    <input type="text" wire:model="order_item.{{$key}}.quantity" class="form-control form-control-sm" oninput="validateNumber(this)" wire:keyup="updateQuantity($event.target.value, {{$key}}, {{$order_item->piece_price}})">
                                    @if(isset($errorMessage["order_item.$key.quantity"]))
                                        <div class="text-danger">{{ $errorMessage["order_item.$key.quantity"] }}</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="" id="">Customer <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" wire:model="customer" 
                                    class="form-control form-control-sm border border-1 customer_input" 
                                    placeholder="Search customer by name, mobile, order ID" {{$readonly}}>
                                    <input type="hidden" wire:model="customer_id" value="">
                                    <input type="hidden" wire:model="staff_id" value="">
                                    @if(isset($errorMessage['customer_id']))
                                        <div class="text-danger">{{ $errorMessage['customer_id'] }}</div>
                                    @endif
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="" id="">Collected By <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" wire:model="staff_name" 
                                    class="form-control form-control-sm border border-1 customer_input" {{$readonly}}>
                                    @if(isset($errorMessage['staff_id']))
                                        <div class="text-danger">{{ $errorMessage['staff_id'] }}</div>
                                    @endif
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="">Voucher No</label>
                            <input type="text" wire:model="voucher_no"
                                class="form-control form-control-sm" disabled {{$readonly}}>
                                @if(isset($errorMessage['voucher_no']))
                                    <div class="text-danger">{{ $errorMessage['voucher_no'] }}</div>
                                @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="">Date <span class="text-danger">*</span></label>
                            <input type="date" wire:model="payment_date" id="payment_date" max="{{date('Y-m-d')}}"
                                class="form-control form-control-sm" value="{{date('Y-m-d')}}">
                                @if(isset($errorMessage['payment_date']))
                                    <div class="text-danger">{{ $errorMessage['payment_date'] }}</div>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row justify-content-{{$activePayementMode=="cash"?"end":"start"}}">
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="">Mode of Payment <span class="text-danger">*</span></label>
                            <select wire:model="payment_mode" class="form-control form-control-sm" id="payment_mode" wire:change="ChangePaymentMode($event.target.value)">
                                <option value="" selected hidden>Select One</option>
                                <option value="cheque">Cheque</option>
                                <option value="neft">NEFT</option>
                                <option value="cash">Cash</option>
                            </select>
                            @if(isset($errorMessage['payment_mode']))
                                <div class="text-danger">{{ $errorMessage['payment_mode'] }}</div>
                            @endif
                        </div>
                    </div>
                    @if($activePayementMode!=="cash")
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="">Cheque No / UTR No </label>
                            <input type="text" value="" wire:model="chq_utr_no" class="form-control form-control-sm"
                                maxlength="100">
                                @if(isset($errorMessage['chq_utr_no']))
                                    <div class="text-danger">{{ $errorMessage['chq_utr_no'] }}</div>
                                @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="">Bank Name </label>
                            <div id="bank_search">
                                <input type="text" id="" placeholder="Search Bank" wire:model="bank_name"
                                    value=""
                                    class="form-control bank_name form-control-sm" maxlength="200">
                                    @if(isset($errorMessage['bank_name']))
                                        <div class="text-danger">{{ $errorMessage['bank_name'] }}</div>
                                    @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-2">
                        <div class="form-group mb-3">
                            <label for="">Actual Amount <span class="text-danger">*</span></label>
                            <input type="text" value="" maxlength="20" wire:model="actual_amount" class="form-control form-control-sm" {{$readonly}}>
                            @if(isset($errorMessage['actual_amount']))
                                <div class="text-danger">{{ $errorMessage['actual_amount'] }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group mb-3">
                            <label for="">Paid Amount<span class="text-danger">*</span></label>
                            <input type="text" value="" maxlength="20" wire:model="amount" class="form-control form-control-sm">
                            @if(isset($errorMessage['amount']))
                                <div class="text-danger">{{ $errorMessage['amount'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group text-end">
                        <button type="submit" id="submit_btn"
                            class="btn btn-sm btn-success"><i class="material-icons text-white" style="font-size: 15px;">add</i>Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

