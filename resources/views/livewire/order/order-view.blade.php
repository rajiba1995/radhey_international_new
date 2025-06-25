<div class="container">
    <section class="admin__title">
        <h5>Order detail</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li><a href="{{route('admin.order.index')}}">Orders</a></li>
            <li>Order detail :- <span>#{{$order->order_number}}</span></li>
            <li class="back-button">
                <a href="{{ url()->previous() }}"
                    class="btn btn-sm btn-danger select-md text-light font-weight-bold mb-0">Back </a>
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
                        {{-- <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>WhatsApp :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0"> {{$order->customer? $order->customer->whatsapp_no: ""}}</p>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong> Address :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{$order->billing_address}}</p>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-sm-4">
                                <p class="small m-0"><strong>Shipping Address :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{$order->shipping_address}}</p>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-2">
        <div class="table-responsive">
            <div class="card-body">
                <table class="table table-sm ledger">
                    <thead>
                        <tr>
                            <th class="" rowspan="1" colspan="1" style="width: 65px;" aria-label="price">Collection</th>
                            <th class="w-50 " rowspan="1" colspan="1" style="width: 328px;" aria-label="products">Order
                                Items</th>
                            <th class="" rowspan="1" colspan="1" style="width: 65px;" aria-label="price">price</th>
                            <th class="" rowspan="1" colspan="1" style="width: 50px;" aria-label="qty">
                                qty</th>
                            <th class="" rowspan="1" colspan="1" style="width: 80px;" aria-label="total">total</th>
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
                                            <img src="{{asset('assets/img/cubes.png')}}" alt="Default Image"
                                                class="rounded-2">
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
                        @if(!empty($item['deliveries']) and count($item['deliveries'])>0)
                        <tr>
                            <td colspan="5">
                                <div class="col-12 mb-2 measurement_div" style="background: #fdfdfd !important;">
                                    <h6 class="badge bg-danger custom_success_badge">Delivery Logs</h6>
                                    <div class="row">
                                        <table class="table table-sm ledger">
                                            <thead>
                                                <tr>
                                                    <th class="w-50 " rowspan="1" colspan="1" style="width: 328px;" aria-label="products">
                                                        Sl No</th>
                                                    <th class="w-50 " rowspan="1" colspan="1" style="width: 328px;" aria-label="products">Delivery
                                                        Date</th>
                                                        <th class="w-50 " rowspan="1" colspan="1" style="width: 328px;" aria-label="products">Delivered BY</th>
                                                    <th class="" rowspan="1" colspan="1" style="width: 50px;" aria-label="qty">
                                                        qty</th>
                                                    <th class="" rowspan="1" colspan="1" style="width: 80px;" aria-label="total">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item['deliveries'] as $index=> $delivery_data)
                                                <tr class="odd" style="background-color: #f2f2f2;">
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ date('d-m-Y h:i A ',timestamp: strtotime($delivery_data['delivered_at'])) }}</td>
                                                    <td>{{ $delivery_data['user']['name'] }}</td>

                                                    <td>{{ $delivery_data['delivered_quantity'] }}</td>
                                                    <td>
                                                        @if($delivery_data['status']=='Pending')
                                                        <a href="javascript:void(0)"

                                                        class="btn btn-outline-success select-md btn_outline" data-toggle="tooltip" onclick="deliveredToCustomer({{ $delivery_data['id'] }},{{ $delivery_data['order_id'] }});">Delivery to Customer
                                                    </a>
                                                    @endif
                                                    @if($delivery_data['status']=='Delivered to Customer')
                                                    <span class="btn btn-outline-success select-md btn_outline">Delivered to Customer</span>

                                                @endif
                                                    </td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endif
                        @if($item['collection_id']==1)
                            <tr>
                                <td colspan="2">
                                    <div class="col-12 mb-2 measurement_div" style="background: #fdfdfd !important;">
                                        <h6 class="badge bg-danger custom_success_badge">Measurements</h6>
                                        <div class="row">

                                            @foreach ($item['measurements'] as $index => $measurement)
                                            <div class="col-md-3">
                                                <label>
                                                    {{$measurement['measurement_name']}}
                                                    <strong>[{{$measurement['measurement_title_prefix']}}]</strong>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-sm border border-1 customer_input text-center measurement_input"
                                                    value="{{ $measurement['measurement_value'] }}">
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </td>
                                <td colspan="3" class="pt-4" style="vertical-align: text-top !important;">
                                    <p>FABRIC : <strong>{{$item['fabrics']->title}}</strong></p>
                                    <p>CATLOGUE : <strong>{{ optional(optional($item['catalogue'])->catalogueTitle)->title }}</strong> (PAGE:
                                        <strong>{{$item['cat_page_number']}}</strong>)
                                    </p>
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
@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deliveredToCustomer(Id,orderId)
{
       Swal.fire({
        title: "Confirm Customer Delivery",
        text: "Please confirm that the item has been physically handed over to the customer. Once confirmed, the system will mark this order as delivered and this action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delivered to customer!"
        }).then((result) => {
        if (result.isConfirmed) {
            console.log("Firee")
            Livewire.dispatch('deliveredToCustomerPartial', {Id,orderId});

        }
        })
}
</script>

@endpush