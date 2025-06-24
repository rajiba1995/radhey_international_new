<div class="container-fluid px-4">



    <style>

        body {

            font-family: "Roboto", sans-serif;

            font-optical-sizing: auto;

            font-weight: 400;

            font-style: normal;

            font-variation-settings: "wdth" 100;

        }



        table {

            width: 100%;

            height: auto;

            border-collapse: collapse;

        }





        .table-container {

            display: flex;

            flex-direction: column;

            height: 100vh;

            position: relative;

        }



        .table-container table {

            flex-grow: 1;

            width: 100%;

            border-collapse: collapse;



        }



        .footer {

            position: absolute;

            bottom: 0;

            left: 0;

            width: 100%;

            height: 75px;

            display: flex;

            flex-direction: column;

            justify-content: flex-end;

            align-items: flex-end;



        }



        html,

        body {

            height: 100%;

        }







        h4,

        h1,

        h5,

        h2,

        h3,

        h6,

        p {

            margin-top: 0;

            color: #000;

        }

        .payment_receipt {

            display: none;

        }

        .payment_receipt.visible {

            display: block;

        }



        @media print {



            .print-hide-admin,

            .print-btn,

            .btn {

                display: none !important;

            }


            .form-control {

                border: none !important;

                padding: 0;

                text-align: left;

            }



            .form-control::placeholder {

                opacity: 0;

            }

        }



        .logo-place {
            text-align:center;
            margin-bottom: 21px;
        }

        .invoice-number {
            text-align: center;
            font-size: 17px;
            color: #000;
        }

        .contact-list {
            display:block;
            list-style:none;
        }

        .contact-list li {
            display: flex;
            align-items: flex-start;
            position: relative;
            padding: 0 0 0 22px;
            color: #000;
            margin-bottom: 5px;
        }

        .contact-list > li img {
            width: 16px;
            line-height: 1;
            margin-right: 8px;
            position: absolute;
            top: 7px;
            left: 0;
        }

        .line {
            background: #eeeeee;
            height: 1px;
        }

        .qty-style button {
            margin-bottom: 0;
            padding: 8px 15px;
            border-radius: 0;
            background: #344767;
            border: 1px solid #344767;
            color: #fff;
        }
        .qty-style input {
            background: #fff !important;
            border: 1px solid #344767 !important;
            max-width: 60px !important;
            flex: 0 0 60px !important;
        }

        .loop span {
            font-size: 12px;
            font-weight: 500;
        }

        .border-custom {
            border-top: 1px solid #e4e0e0;
        }

        .big-label {
            font-size: 13px;
        }

    </style>







    <div class="table-container">

        <div class="row justify-content-end mb-4">
            @php
                $loggedInUser = Auth::guard('admin')->user();
            @endphp
            <div class="col-md-4">
                <label class="form-label"><strong>Ordered By</strong></label>

                <select class="form-control border bg-white border-2 p-2 form-control-sm @error('salesman') border-danger  @enderror"

                    wire:change="changeSalesman($event.target.value)" wire:model="salesman" 
                    {{$loggedInUser->is_super_admin == 1 ? '' : 'disabled'}}>

                    <option value="" selected hidden>Choose one..</option>

                    <!-- Set authenticated user as default -->



                    <option value="{{auth()->guard('admin')->user()->id}}" selected>

                        {{auth()->guard('admin')->user()->name}}

                    </option>

                    <!-- Fetch all salesmen from the database -->

                    @foreach ($salesmen as $salesmans)

                    @if($salesmans->id != auth()->guard('admin')->user()->id)

                    <option value="{{$salesmans->id}}">{{strtoupper($salesmans->name . ' '.$salesmans->surname)}}</option>

                    @endif

                    @endforeach

                </select>

                @error('salesman')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label"><strong>Bill Number</strong></label>

                <!-- Remaining Amount -->

                <input type="text" class="form-control bg-white form-control-sm border border-1" disabled

                    wire:model="order_number" value="">

                @error('order_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-header p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="logo-place">
                        <img src="{{asset('assets/img/pdf_logo.png')}}" style="width:280px; height:auto;">
                    </div>
                    <div class="invoice-number">
                        Invoice: INV/{{ now()->year }}/{{$this->previewInvoiceNo}}
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="contact-list">
                        <li>
                            <img src="{{asset('assets/img/phone.svg')}}" alt="">
                            <span style="display:inline-block;"> (+242) 05 554 7777 </span>
                        </li>

                        <li>
                            <img src="{{asset('assets/img/phone.svg')}}" alt="">
                            <span style="display:inline-block;"> (+242) 05 582 5555 </span>
                        </li>

                        <li>
                            <img src="{{asset('assets/img/mail.svg')}}" alt="">
                            <span style="display:inline-block;"> contact@stannys.com </span>
                        </li>

                        <li>
                            <img src="{{ asset('assets/img/globe.svg')}}" alt="">
                            <span style="display:inline-block;"> www.stannys.com </span>
                        </li>

                        <li>
                            <img src="{{asset('assets/img/map-pin.svg')}}" alt="">
                            <span style="display:inline-block;"> 18, Blv. Denis Sassou N'guesso,<br> Brazzaville, République du Congo </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">


                <div class="col-md-4 position-relative">
                    <label class="date_lable">Customer Name:</label>
                    {{-- <input type="text" name="customer_name" class="form-control border border-2 p-2" wire:model="customer_name" required> --}}
                    <input type="text" wire:keyup="FindCustomer($event.target.value)"
                                   wire:model.debounce.500ms="searchTerm"
                                    class="form-control form-control-sm border border-1 customer_input"
                                    placeholder="Search by customer details or order ID">
                                    @if(!empty($customers) && count($customers) > 0)
                                    <div class="dropdown-menu show w-100" style="width: 100%; max-height: 200px; overflow-y: auto; position: absolute; top: 100%; z-index: 1000;">
                                        @foreach($customers as $customer)
                                            <button type="button" 
                                                    class="dropdown-item"
                                                    wire:click="selectCustomer({{ $customer->id }})">
                                                {{ ucwords($customer->name) }}
                                                @if($customer->phone)
                                                    <small class="text-muted">({{ $customer->phone }})</small>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                    @error('customer_name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label class="date_lable">Invoice Date:</label>

                    <input type="date" class="form-control border border-2 p-2" name="invoice_date" wire:model="invoice_date" required max="{{ now()->format('Y-m-d') }}">

                    @error('invoice_date')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label class="date_lable">Due Date:</label>

                    <input type="date" class="form-control border border-2 p-2" name="due_date" wire:model="due_date" required >

                    @error('due_date')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label class="date_lable">Source:</label>

                    <input type="text" class="form-control border border-2 p-2" name="source" wire:model="source" required>

                    @error('source')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label class="date_lable">Reference:</label>

                    <input type="text" class="form-control border border-2 p-2" name="reference" wire:model="reference" required>

                    @error('reference')
                        <p class="text-danger">{{$message}}</p>
                @enderror
                </div>

            </div>

            <div class="line mt-5 mb-5"></div>

            <div class="loop-holder mb-5">
                @foreach ($rows as $index => $row)
                    <div class="loop">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="date_lable">Customer Name</label>
                                <select class="form-control product-select"

                                wire:model="rows.{{ $index }}.product_id">

                                <option value="" selected hidden>Select Product</option>

                                @foreach ($products as $product)
                                    <option value="{{$product['id']}}">{{$product['name']}}</option>
                                @endforeach

                                </select>

                                @error('rows.'.$index.'.product_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="date_lable">Quantity</label>
                                <div class="input-group qty-style">

                                    <div class="input-group-prepend">

                                        <button class="btn btn-outline-secondary btn-qty minus" type="button"

                                            wire:click="updateQuantity({{ $index }}, 'decrease')">-</button>

                                    </div>

                                    <input type="text" class="form-control quantity text-center" value="1" min="1"

                                        wire:model="rows.{{ $index }}.quantity" readonly>

                                    <div class="input-group-append">

                                        <button class="btn btn-outline-secondary btn-qty plus" type="button"

                                            wire:click="updateQuantity({{ $index }}, 'increase')">+</button>

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="date_lable">Unit Price</label>
                                <input type="text" class="form-control amount"

                                 wire:model.lazy="rows.{{ $index }}.unit_price" wire:blur="updatePrice({{ $index }})"

                                placeholder="Enter Amount">

                                @error('rows.'.$index.'.unit_price')

                                    <p class="text-danger">{{$message}}</p>

                                @enderror
                            </div>
                            <div class="col-md-2 align-self-end">
                             <label class="date_lable">Total Price</label>
                                <input type="text" class="form-control amount" value="0" readonly wire:model="rows.{{ $index }}.total"> 
                                <span>FCFA</span>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row mb-0" wire:click="removeRow({{$index}})"><i class="fas fa-trash-alt"></i></button>
                                <button class="btn btn-success btn-sm mb-0" wire:click="addRow"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mb-4">
                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <div class="row">
                        @php

                            $subtotal = collect($rows)->sum(function ($row) {

                            return floatval($row['total']);

                            });

                            $tva = $subtotal * 0.18;

                            $ca = $tva * 0.05;

                            $ht_amount = $subtotal - ($tva + $ca);

                        @endphp
                        <div class="col-md-6 text-left p-2 border-custom">
                            <div class="date_lable big-label"><strong>Total</strong></div>
                        </div>
                        <div class="col-md-6 text-right p-2 border-custom">
                            <div class="date_lable text-end big-label"> {{$subtotal}} FCFA</div>
                        </div>

                        <div class="col-md-6 text-left p-2 border-custom">
                            <div class="date_lable big-label">H.T</div>
                        </div>
                        <div class="col-md-6 text-right p-2 border-custom">
                            <div class="date_lable text-end big-label">{{ number_format($ht_amount, 2) }} FCFA</div>
                        </div>

                        <div class="col-md-6 text-left p-2 border-custom">
                            <div class="date_lable big-label">T.V.A</div>
                        </div>
                        <div class="col-md-6 text-right p-2 border-custom">
                            <div class="date_lable text-end big-label">{{ number_format($tva, 2) }}</div>
                        </div>

                        <div class="col-md-6 text-left p-2 border-custom">
                            <div class="date_lable mb-4 big-label">C.A</div>
                            <div class="date_lable big-label">paid on {{ \Carbon\Carbon::now()->format('d-m-Y') }} using cash</div>
                        </div>
                        <div class="col-md-6 text-right p-2 border-custom">
                            <div class="date_lable text-end mb-4 big-label">
                                {{ number_format($ca, 2) }} FCFA
                            </div>
                            <div class="date_lable text-end big-label">0 FCFA</div>
                        </div>

                        <div class="col-md-6 text-left p-2 border-custom">
                            <div class="date_lable big-label"><strong>Amout Due</strong></div>
                        </div>
                        <div class="col-md-6 text-right p-2 border-custom">
                            <div class="date_lable text-end big-label">{{$subtotal}} FCFA</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <button id="terget" class="btn btn-primary print-btn btn-sm mt-5"  wire:click.prevent="printInvoice">Generate Invoice</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-12 big-label">
                    Please use the following communication for your payment: INV/{{ now()->year }}/{{$this->previewInvoiceNo}}
                </div>
            </div>
    
             <div id="slide-down" class=" mt-4 @if(!$showPaymentReceipt) d-none  @endif" >
                <div class="row justify-content-between">
                    <div class="col-md-4">
                        <label class="date_lable" for="">Mode of Payment <span class="text-danger">*</span></label>

                        <select wire:model="payment_mode" wire:change="ChangePaymentMode($event.target.value)" class="form-control" id="payment_mode" wire:change="ChangePaymentMode($event.target.value)">

                            <option value="" selected hidden>Select One</option>

                            <option value="cheque">Cheque</option>

                            <option value="neft">NEFT</option>

                            <option value="cash">Cash</option>

                        </select>
                        @error('payment_mode')
                            <p class="text-danger">{{$message}}</p>
                        @enderror

                    </div>
                    <div class="col-md-3">
                        <label class="date_lable" for="">Actual Amount <span class="text-danger">*</span></label>

                        <input type="text" value="" maxlength="20" wire:model="actual_amount" class="form-control" readonly>

                        @error('actual_amount')
                            <p class="text-danger">{{$message}}</p>
                        @enderror

                    </div>

                    <div class="col-md-3">
                        <label class="date_lable" for="">Paid Amount<span class="text-danger">*</span></label>

                        <input type="text" value="" maxlength="20" wire:model="amount" class="form-control">

                        @error('amount')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    
                    <div class="col-md-2">
                        <button type="submit" id="submit_btn" class="btn btn-sm btn-success" wire:click.prevent="savePayment"><i class="material-icons text-white" style="font-size: 15px;">add</i>Save</button>
                    </div>
                </div>
                
                @if ($showPaymentFields)
                <div class="row mt-4">
                    <div class="col-md-3">
                        <label class="date_lable" for="">Cheque No / UTR No </label>

                        <input type="text" value="" wire:model="chq_utr_no" class="form-control" maxlength="100">

                        @error('chq_utr_no')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="date_lable" for="">Bank Name </label>
                        <div id="bank_search">

                            <input type="text" id="" placeholder="Search Bank" wire:model="bank_name"

                                value=""

                                class="form-control bank_name " maxlength="200">

                            @error('bank_name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror    

                        </div>
                    </div>
                </div>
                @endif

               

            </div>

            <div class="row ">
                <div class="col-md-12 text-center">
                    <h6>STE RADHEY'S SARL</h6>
                    <div class="line mt-2 mb-2"></div>
                    <div class="">
                        CAPITAL: 1.000.000 FCFA<br>
                        NIU M24000000659298E<br>
                        RCCM: CG-BZV-01-2025-B20-00004
                    </div>
                </div>
               
            </div>

            
           


        </div>

        <!--Here removed table-custom and payment receipt card-->

        </div>

    </div>


<script>

    // window.addEventListener('triggerPrint', () => {

    //   if(confirm("Are you sure you want to payment?")){

    //     const target = document.getElementById('slide-down');
    //     if (target) {
    //     target.scrollIntoView({ behavior: 'smooth' });
    //     }

    //     Livewire.dispatch('paymentConfirmed');

    //     //   window.print();

    //     }
    // });


//     window.addEventListener('triggerPrint', () => {
//   console.log("triggerPrint event fired");

//   if (confirm("Are you sure you want to payment?")) {

//     const target = document.getElementById('slide-down');
//     if (target) {
//       const rect = target.getBoundingClientRect();
//       const scrollTop = window.scrollY || document.documentElement.scrollTop;

//       // Manually scroll to the element's position
//       window.scrollTo({
//         top: rect.top + scrollTop,
//         behavior: 'smooth'
//       });

//       console.log("Scrolled to targetDiv");
//     } else {
//       console.warn("targetDiv not found");
//     }

//     Livewire.dispatch('paymentConfirmed');
//   }
// });



</script>