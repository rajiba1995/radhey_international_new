<div class="container">
    <section class="admin__title">
        <h5>Order History</h5>
    </section>
    <section>
        <div class="search__filter">
            <div class="row align-items-center justify-content-end">
                <div class="col-auto">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto" style="margin-top: -27px;">
                            <label for="" class="date_lable">Start Date</label>
                            <input type="date" wire:model="start_date" wire:change="AddStartDate($event.target.value)"
                                class="form-control select-md bg-white" placeholder="Start Date">
                        </div>
                        <div class="col-auto" style="margin-top: -27px;">
                            <label for="" class="date_lable">End date</label>
                            <input type="date" wire:model="end_date" wire:change="AddEndDate($event.target.value)"
                                class="form-control select-md bg-white" placeholder="End Date">
                        </div>

                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <p class="text-sm font-weight-bold">{{count($orders)}} Items</p>
                </div>

                <div class="col-auto">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto mt-0">
                            <input type="text" wire:model="search" class="form-control select-md bg-white search-input"
                                id="customer" placeholder="Search by customer detail or Order number" value=""
                                style="width: 350px;" wire:keyup="FindCustomer($event.target.value)">
                        </div>

                        <div class="col-auto mt-3">
                            <button type="button" wire:click="resetForm"
                                class="btn btn-outline-danger select-md">Clear</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="card my-2">
        <div class="card-header pb-0">
            <div class="row">
                @if(session()->has('message'))
                <div class="alert alert-success" id="flashMessage">
                    {{ session('message') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </div>
            {{-- tab --}}
            {{-- <ul class="nav nav-tabs mb-2" id="orderTabs">
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'all' ? 'active' : '' }}" href="#"
                        wire:click.prevent="changeTab('all')">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'pending' ? 'active' : '' }}" href="#"
                        wire:click.prevent="changeTab('pending')">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'approved' ? 'active' : '' }}" href="#"
                        wire:click.prevent="changeTab('approved')">Received</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'stock_entered' ? 'active' : '' }}" href="#"
                        wire:click.prevent="changeTab('stock_entered')">Stock Entered</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'delivered' ? 'active' : '' }}" href="#"
                        wire:click.prevent="changeTab('delivered')">Delivered</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'completed' ? 'active' : '' }}" href="#"
                        wire:click.prevent="changeTab('completed')">Completed</a>
                </li>
            </ul> --}}

            <div class="table-responsive p-0">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Order #
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Customer
                                Details</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Order
                                Amount</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Placed By
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Status</th>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10 text-center">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="align-center">
                                <span class="text-dark text-sm font-weight-bold mb-0">{{ env('ORDER_PREFIX').
                                    $order->order_number }}</span><br>
                                <p class="small text-muted mb-1 badge bg-warning">{{ $order->created_at->format('Y-m-d
                                    H:i') }}</p>
                            </td>
                            <td>
                                <p class="small text-muted mb-1">
                                    <span>Name: <strong>{{ucwords($order->prefix ." ". $order->customer_name)}}</strong>
                                    </span>
                                    <br>
                                    <span>Mobile : <strong>{{$order->customer? $order->customer->country_code_phone.'
                                            '.$order->customer->phone:""}}</strong> </span> <br>
                                </p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $order->total_amount }}</p>
                            </td>
                            <td>
                                <p class="small text-muted mb-1 text-uppercase">
                                    {{$order->createdBy?strtoupper($order->createdBy->name .'
                                    '.$order->createdBy->surname):""}}</p>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->status_class }}">
                                {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($order->status == 'Approved')
                                    <button wire:click="confirmMarkAsReceived({{ $order->id }})"
                                       class="btn btn-outline-success select-md btn_outline" @click.stop>Mark As
                                        Received
                                    </button>
                                @elseif($order->status == 'Received at Production'  || $order->status == 'Partial Delivered By Production' || $order->status == 'Fully Delivered By Production')
                                    {{-- <a href="{{route('production.order.download_pdf',$order->id)}}" target="_blank" class="btn btn-outline-primary select-md btn_outline">
                                        Download Pdf
                                    </a> --}}
                                    @if (!in_array($order->id, $has_order_entry))
                                       <a href="{{route('production.order.details',$order->id)}}" class="btn btn-outline-success select-md btn_action btn_outline">Stock Entry</a>   
                                    @elseif(in_array($order->id, $has_order_entry) && $order->status != 'Fully Delivered By Production')
                                       <a href="{{route('production.order.details',$order->id)}}" class="btn btn-outline-success select-md btn_action btn_outline">Delivery</a>   
                                    @elseif($order->status == 'Fully Delivered By Production')
                                       <button class="btn btn-outline-success select-md btn_action btn_outline" disabled>Delivered</button> 
                                    @endif
                                @endif
                                 @if ($order->status !== 'Approved')
                                    <a href="{{route('production.order.details',$order->id)}}" class="btn btn-outline-success select-md btn_action btn_outline">Details</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                   <!-- Stock Entry Modal -->
                    <div wire:ignore.self class="modal fade" id="stockEntryModal" tabindex="-1" aria-labelledby="stockEntryModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="stockEntryModalLabel">Enter Stock for Order #{{$stockOrderId}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeStockModal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Your stock entry form goes here -->
                            <div class="mb-3">
                            <label for="stockItem" class="form-label">Fabric / Stock Item</label>
                            <input type="text" id="stockItem" class="form-control">
                            </div>
                            <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity Used</label>
                            <input type="number" id="quantity" class="form-control">
                            </div>
                            <!-- Add more fields as needed -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeStockModal">Close</button>
                            <button type="button" class="btn btn-primary">Save Stock Entry</button>
                        </div>
                        </div>
                    </div>
                    </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
    @if(empty($search))
    <div class="loader-container" wire:loading>
        <div class="loader"></div>
    </div>
    @endif

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('showMarkAsReceived', function (event) {
           let orderId = event.detail[0].orderId;
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to mark this order as received.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Mark as Received!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Call Livewire method with confirmed orderId
                    // Livewire.dispatch('markReceivedConfirmed', { orderId: data.orderId });
                    @this.call('markReceivedConfirmed', orderId); // Call Livewire method
                    Swal.fire("Mark As Received!", "The order has been marked as received.", "success");
                }
            });
        });
</script>


