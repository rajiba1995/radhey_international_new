<div class="container">
    <style>
        
      .no-padding-td tr td{
        padding: 12px 6px !important;
      }
    </style>
    <section class="admin__title">
        <h5>Order detail</h5>
    </section>
    <section>

        <ul class="breadcrumb_menu">
            <li><a href="{{route('admin.order.index')}}">Orders</a></li>
            <li>Order detail :- <span>#{{$order->order_number}}</span></li>
            <li class="back-button">
                <a href="{{route('production.order.index')}}"
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
                                <p class="small m-0"><strong> Address :</strong></p>
                            </div>
                            <div class="col-sm-8">
                                <p class="small m-0">{{$order->billing_address}}</p>
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
                <table class="table table-sm ledger no-padding-td">
                    <thead>
                        <tr>
                            <th class="" rowspan="1" colspan="1" style="width: 65px;" aria-label="price">Collection</th>
                            <th class="w-50 " rowspan="1" colspan="1" style="width: 328px;" aria-label="products">Order
                                Items</th>
                            {{-- <th class="" rowspan="1" colspan="1" style="width: 65px;" aria-label="price">price</th> --}}
                            <th class="" rowspan="1" colspan="1" style="width: 50px;" aria-label="qty">
                                qty</th>
                            <th class="" rowspan="1" colspan="1" style="width: 50px;" aria-label="used">
                                Total Used</th>
                            <th class="" rowspan="1" colspan="1" style="width: 50px;" aria-label="">
                                Action</th>
                            {{-- <th class="" rowspan="1" colspan="1" style="width: 80px;" aria-label="total">total</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($orderItems) > 0)
                        
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
                            {{-- <td><span>{{number_format($item['price'], 2)}}</span></td> --}}
                            <td><span>{{$item['quantity']}}</span></td>
                            @if ($item['has_stock_entry'])
                            
                                <td>
                                    @php
                                        $inputName = 'row_' . $loop->index . '_' . $item['stock_entry_data']['input_name'];
                                        $required = $item['stock_entry_data']['available_value'] ?? 0;
                                        $totalUsed = $item['total_used'] ?? 0;
                                        $isFabric = $item['collection_id'] == 1;
                                        $unit = $isFabric ? 'meters' : 'pieces';
                                    @endphp
                                    <span>{{$totalUsed}} {{$unit}}</span>

                                   
                                </td>
                            @else
                              <td>0</td>
                            @endif
                           <td>
                                <div>
                                    @if ($item['collection_id'] == 1)
                                   
                                    @endif

                                    @if ($item['collection_id'] == 1)
                                        @if ($item['is_delivered'] ?? false)
                                            <button class="btn btn-success select-md" disabled>
                                                Delivered
                                            </button>
                                        @else
                                        <button class="btn btn-outline-success select-md"
                                            wire:click="openStockModal({{$loop->index}},true)">
                                            @if ($item['has_stock_entry'])
                                            Update Stock
                                            @else
                                            Enter Stock  
                                            @endif 
                                        </button>
                                        @if ($item['has_stock_entry'])
                                        <button class="btn btn-outline-success select-md"
                                            wire:click="openDeliveryModal({{ $loop->index }})">
                                                Delivery
                                        </button>
                                        @endif
                                        @endif
                                    @endif

                                    @if ($item['collection_id'] == 2)
                                     @php
                                     $orderedQty = (int) ($item['quantity'] ?? 0) ;
                                     $deliveredQty = (int) ($item['delivered_quantity'] ?? 0);
                                    //  dd($deliveredQty);
                                     $remainingQty = $orderedQty - $deliveredQty;
                                    @endphp
                                        @if ($remainingQty <=0 )
                                            <button class="btn btn-success select-md" disabled>
                                                Delivered
                                            </button>
                                        @else
                                            <button class="btn btn-outline-success select-md"
                                            wire:click="openDeliveryModal({{ $loop->index }})">
                                                Delivery
                                            </button>
                                        @endif
                                    @endif
                                    
                                </div>
                            </td>
                        </tr>
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
                                <p>CATALOGUE : <strong>{{ optional(optional($item['catalogue'])->catalogueTitle)->title
                                        }}</strong> (PAGE:
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
                       
                    </tbody>
                </table>

                {{-- Stock Entry Modal --}}
                <div wire:ignore.self class="modal fade" id="stockEntryModal" tabindex="-1" aria-labelledby="stockEntryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stockEntryModalLabel">
                               Stock Entry Sheet - {{$order->order_number}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   <div class="modal-body">
                        @if ($selectedItem)
                        <div class="card">
                            <div class="card-body">
                                <h6>Stock Entry Interface</h6>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <strong>Collection</strong> <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" value="{{ $selectedItem['collection_title'] ?? '' }}"
                                            class="form-control form-control-sm border border-1 p-2" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <strong>{{ $selectedItem['collection_id'] == 2 ? 'Product' : 'Fabric' }}</strong>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            value="{{ $selectedItem['collection_id'] == 2 ? $selectedItem['product_name'] : $selectedItem['fabric_title'] }}"
                                            class="form-control form-control-sm border border-1 p-2" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">{{ $selectedItem['available_label'] }}</label>
                                        <input type="number" value="{{ $selectedItem['available_value'] }}"
                                            class="form-control form-control-sm border border-1 p-2" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">{{ $selectedItem['updated_label'] }}</label>
                                        <input type="text"
                                            wire:model="rows.{{ $selectedItem['input_name'] }}"
                                            class="form-control form-control-sm border border-1 p-2 @error($selectedItem['input_name']) is-invalid @enderror">
                                        
                                        @error( $selectedItem['input_name'])
                                             <div class="invalid-feedback">
                                                 {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 mt-4">
                                            <button class="btn btn-outline-success select-md"
                                                wire:click="updateStock({{ $selectedItem['index'] }},
                                                            '{{ $selectedItem['input_name'] }}')">
                                                Update
                                            </button>
                                        @if($selectedItem['has_stock_entry'])
                                        <button class="btn btn-outline-danger select-md"
                                            wire:click="$dispatch('confirm-revert-back', { index: {{ $selectedItem['index'] }}, inputName: '{{ $selectedItem['input_name'] }}' })">
                                            Revert Back
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <p class="text-muted">No data loaded.</p>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>

                {{-- Delivery Process Modal --}}
                <div wire:ignore.self class="modal fade" id="delieveryProcessModal" tabindex="-1" aria-labelledby="delieveryProcessModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delieveryProcessModalLabel">Process Delivery - {{$order->order_number}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   <div class="modal-body">
                        <div class="card">
                           <div class="card-body">
                                <!-- Row for Stock Validation -->
                                <div class="row align-items-center mb-4">
                                    <div class="col-md-6">
                                        @if (isset($selectedDeliveryItem['collection_id']) && $selectedDeliveryItem['collection_id'] == 1)
                                            <strong>Total Usage:</strong> 
                                            {{ $selectedDeliveryItem['planned_usage'] ?? 0 }} {{ $selectedDeliveryItem['unit'] ?? '' }}
                                        @else
                                            <strong>Total Stock:</strong> 
                                            {{ $selectedDeliveryItem['stock_product'] ?? 0 }} {{ $selectedDeliveryItem['unit'] ?? '' }}
                                            <br>
                                            <strong>Delivered Quantity:</strong> 
                                            {{ $selectedDeliveryItem['delivered_quantity'] ?? 0 }} {{ $selectedDeliveryItem['unit'] ?? '' }}
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="actualUsage" class="form-label mb-1">Actual Usage ({{ $selectedDeliveryItem['unit'] ?? '' }})</label>
                                        <input type="number" class="form-control @error('actualUsage') is-invalid @enderror" id="actualUsage" wire:model="actualUsage.{{ $selectedDeliveryItem['item_id'] ?? 'default' }}" 
                                        wire:keyup="checkActualUsage">
                                        @error('actualUsage.' . ($selectedDeliveryItem['item_id'] ?? 'default'))
                                            <p class="small text-danger">{{ $message }}</p>
                                        @enderror
                                        @if (session()->has('stock_error'))
                                            <p class="small text-danger">{{ session('stock_error') }}</p>
                                        @endif
                                    </div>
                                </div>
                                @if (isset($selectedDeliveryItem['collection_id']) && $selectedDeliveryItem['collection_id'] == 1) 
                                    @if ($showExtraStockPrompt)
                                        <div class="bg-danger p-3 rounded mt-3 mb-2">
                                            <i class="material-icons text-warning me-2" style="font-size: 20px;">warning</i>
                                            Actual usage ({{ $actualUsage[$selectedDeliveryItem['item_id']] ?? 0 }} {{ $selectedDeliveryItem['unit'] ?? '' }})
                                            exceeds total usage ({{ $selectedDeliveryItem['planned_usage'] }} {{ $selectedDeliveryItem['unit'] ?? '' }}).
                                            Please add extra stock entries before proceeding.
                                        </div>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-dark" data-bs-dismiss="modal">Close</button>
                        @if($showExtraStockPrompt && $selectedDeliveryItem['collection_id'] == 1)
                             <button type="button" 
                                    class="btn btn-sm btn-outline-primary mt-2"
                                    wire:click="addExtraStock">
                                Add Extra Stock
                            </button>
                        @else
                            <button type="button" 
                                    class="btn btn-sm btn-outline-primary mt-2"
                                    wire:click="processDelivery">
                                Process Delivery
                            </button>
                        @endif
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('confirm-revert-back', event => {
        const { index, inputName } = event.detail;

        Swal.fire({
            title: 'Are you sure?',
            text: "This will revert the stock entry update.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, revert it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // use @this.call to run the Livewire method
                @this.call('revertBackStock', index, inputName);
            }
        });
    });
</script>
<script>
    // for the stock modal open and close
    window.addEventListener('open-stock-modal',event=>{
        let myModal = new bootstrap.Modal(document.getElementById('stockEntryModal'));
        myModal.show();
    });

     window.addEventListener('close-stock-modal',event=>{
        let myModal = new bootstrap.Modal(document.getElementById('stockEntryModal'));
        myModal.hide();
    });

    // for the delivery modal open and close
     window.addEventListener('open-delivery-modal',event=>{
        let myModal = new bootstrap.Modal(document.getElementById('delieveryProcessModal'));
         myModal.show();
     });

      window.addEventListener('close-delivery-modal', event => {
        let deliveryModal = bootstrap.Modal.getInstance(document.getElementById('delieveryProcessModal'));
        if (deliveryModal) {
            deliveryModal.hide();
        }
    });


</script>
