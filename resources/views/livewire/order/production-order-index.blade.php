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
                            <input type="text" wire:model="search" class="form-control select-md bg-white search-input" id="customer"
                                placeholder="Search by customer detail or Order number" value="" style="width: 350px;"
                                wire:keyup="FindCustomer($event.target.value)">
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
            <ul class="nav nav-tabs mb-2" id="orderTabs">
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'all' ? 'active' : '' }}" href="#" wire:click.prevent="changeTab('all')">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'pending' ? 'active' : '' }}" href="#" wire:click.prevent="changeTab('pending')">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'approved' ? 'active' : '' }}" href="#" wire:click.prevent="changeTab('approved')">Received</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'stock_entered' ? 'active' : '' }}" href="#" wire:click.prevent="changeTab('stock_entered')">Stock Entered</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'delivered' ? 'active' : '' }}" href="#" wire:click.prevent="changeTab('delivered')">Delivered</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'completed' ? 'active' : '' }}" href="#" wire:click.prevent="changeTab('completed')">Completed</a>
                </li>
            </ul>

            <div class="table-responsive p-0">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Order #</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Customer Details</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Order Amount</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Placed By</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Status</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="align-center">
                                    <span class="text-dark text-sm font-weight-bold mb-0">{{ env('ORDER_PREFIX'). $order->order_number }}</span><br>
                                    <p class="small text-muted mb-1 badge bg-warning">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                                </td>
                                <td>
                                    <p class="small text-muted mb-1">
                                        <span>Name: <strong>{{ucwords($order->prefix ." ". $order->customer_name)}}</strong> </span>
                                        <br>
                                        <span>Mobile : <strong>{{$order->customer? $order->customer->country_code_phone.' '.$order->customer->phone:""}}</strong> </span> <br>
                                    </p>
                                </td>
                                <td><p class="text-xs font-weight-bold mb-0">{{ $order->total_amount }}</p></td>
                                <td>
                                   <p class="small text-muted mb-1 text-uppercase">{{$order->createdBy?strtoupper($order->createdBy->name .' '.$order->createdBy->surname):""}}</p>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $order->status_class }}">{{ $order->status_label }}</span>
                                </td>
                            <td class="text-center">
                                    
                            </tr>
                        @endforeach  
                    </tbody>
                </table>

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

