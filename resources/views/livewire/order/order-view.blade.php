<div class="container">
    <section class="admin__title">                
        <h5>Order detail</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="{{route('admin.order.index')}}">Orders</a></li>
            <li>Order detail :- <span>#{{$order->order_number}}</span></li>
            <li class="back-button">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-danger select-md text-light font-weight-bold mb-0">Back </a>
            </li>
          </ul>
    </section>
    <div class="card shadow-sm mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h6>Order Information</h6>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0">
    
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Order Amount :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{number_format($order->total_amount, 2)}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Order Time :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{ $order->created_at->format('d M Y h:i A') }}</p>
                            </div>
                        </div>
    
    
    
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <h6>Customer Details</h6>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Person Name :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{$order->customer_name}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Company Name :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{$order->customer?$order->customer->company_name:"---"}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Rank :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{$order->customer?$order->customer->employee_rank:"---"}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Email :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0"> {{$order->customer_email}} </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Mobile :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0"> {{$order->customer? $order->customer->phone: ""}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>WhatsApp :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0"> {{$order->customer? $order->customer->whatsapp_no: ""}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Billing Address :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{$order->billing_address}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Shipping Address :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{$order->shipping_address}}</p>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="table-responsive">
            <div class="card-body">
                <table class="table table-sm ledger">
                    <thead>
                        <tr>
                            <th class="" rowspan="1" colspan="1" style="width: 65px;"
                            aria-label="price">Collection</th>
                            <th class="w-50 " rowspan="1" colspan="1" style="width: 328px;"
                                aria-label="products">Order Items</th>
                            <th class="" rowspan="1" colspan="1" style="width: 65px;"
                                aria-label="price">price</th>
                            <th class="" rowspan="1" colspan="1" style="width: 50px;" aria-label="qty">
                                qty</th>
                            <th class="" rowspan="1" colspan="1" style="width: 80px;"
                                aria-label="total">total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orderItems->isNotEmpty())
                    
                        @foreach ($orderItems as $item)
                        {{-- {{dd()}} --}}
                        <tr class="odd" style="background-color: #f2f2f2;">
                            <td>{{$item['collection_title']}}</td>
                            <td class="">
                                <div class="d-flex justify-content-start align-items-center product-name">
                                    <div class="me-3">
                                        @if (!empty($item['product_image']))
                                        <div class="avatar avatar-sm rounded-2 bg-label-secondary">
                                            <img src="{{ asset('storage/' . $item['product_image']) }}"
                                                alt="Product Image" class="rounded-2">
                                        </div>
                                        @else
                                        <div class="avatar avatar-sm rounded-2 bg-label-secondary">
                                            <img src="{{asset('assets/img/cubes.png')}}"
                                                alt="Default Image" class="rounded-2">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span
                                            class="text-nowrap text-heading fw-medium">{{$item['product_name']}}</span>
                                    </div>
                                </div>
                            </td>
                            <td><span>{{number_format($item['price'], 2)}}</span></td>
                            <td><span>{{$item['quantity']}}</span></td>
                            <td><span>{{number_format($item['price']*$item['quantity'], 2)}}</span></td>
                        </tr>
                        @if($item['collection_id']==1)
                            <tr>
                                <td colspan="2">
                                    <div class="col-12 mb-2 measurement_div" style="background: #fdfdfd !important;">
                                        <h6 class="badge bg-danger custom_success_badge">Measurements</h6>
                                        <div class="row">
                                    
                                            <!--[if BLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]-->
                                            <div class="col-md-3">
                                                <label>
                                                    JACKET LENGTH
                                                    <strong>[J/L]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.0.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    MUSCLE
                                                    <strong>[MSL]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.1.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    WRIST
                                                    <strong>[WRT]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.2.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    TROUSER LENGTH
                                                    <strong>[T/L]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.3.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    BIG INSEAM
                                                    <strong>[INS (B)]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.4.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    SHORT INSEAM
                                                    <strong>[INS (S)]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.5.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    CROTCH
                                                    <strong>[CRT]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.6.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    THIGH
                                                    <strong>[THG]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.7.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    BOTTOM
                                                    <strong>[BTM]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.8.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    KNEE
                                                    <strong>[KNE]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.9.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    FRONT
                                                    <strong>[FRT]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.10.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    CHEST
                                                    <strong>[CST]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.11.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    COLLAR
                                                    <strong>[COL]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.12.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    AFTER CHEST
                                                    <strong>[AF CST]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.13.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    WAIST
                                                    <strong>[WST ]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.14.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    STOMACH
                                                    <strong>[STM]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    wire:model="items.0.measurements.15.value">
                                                <!--[if BLOCK]><![endif]-->
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <!--[if ENDBLOCK]><![endif]-->
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </td>
                                <td colspan="3" class="pt-4" style="vertical-align: text-top !important;">
                                    <p>FABRIC : <strong>{{$item['fabrics']->title}}</strong></p>
                                    <p>CATLOGUE : <strong>{{$item['catalogue']->catalogueTitle->title}}</strong> (PAGE: <strong>{{$item['cat_page_number']}}</strong>)</p>
                                </td>
                            </tr>
                        @endif
                        @endforeach
                        @else
                        <tr>
                            <td>
                                <p>No items found for this order.</p>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-left"><small>Total Amount:</small></td>
                            <td><strong>{{number_format($order->total_amount, 2)}}</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-left"><small>Paid Amount:</small></td>
                            <td><strong>{{number_format($order->paid_amount, 2)}}</strong></td>
                        </tr>
                        @if ($order->remaining_amount > 0)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-left"><small>Remaining Amount:</small></td>
                            <td><strong class="text-danger">{{number_format($order->remaining_amount, 2)}}</strong></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>