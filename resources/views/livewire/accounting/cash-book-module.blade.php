<div class="container">
    <style>
        .wallet-negative{
            color: red;
            font-size: 1.5rem;
        }
    </style>
    <section class="admin__title">
        <h5>Cashbook</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li>Accounting</li>
            <li><a href=""> Cashbook</a></li>
            <li class="back-button"></li>
        </ul>
    </section>
    <div class="search__filter">
        <div class="row justify-content-end">
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2">
                    {{-- Start Date --}}
                    <div class="mb-4">
                        <label for="start_date" class="form-label mb-1">Start Date</label>
                        <input type="date" wire:model="start_date" id="start_date" wire:change="AddStartDate($event.target.value)"
                            class="form-control select-md bg-white">
                    </div>
                    <!-- End Date -->
                    <div class="mb-4">
                        <label for="end_date" class="form-label mb-1">End Date</label>
                        <input type="date" wire:model="end_date" id="end_date" class="form-control select-md bg-white" wire:change="AddEndDate($event.target.value)">
                    </div>

                    {{-- <button type="button" wire:click="resetForm"
                        class="btn btn-outline-danger select-md mt-3">Clear</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="filter">
        <div class="row align-items-center justify-content-end">
            <div class="col-auto">
                {{-- <p class="text-sm font-weight-bold">{{$total}} Items</p> --}}
            </div>
        </div>
    </div>
    {{-- <div class="card"> --}}
        {{-- <div class="card-body"> --}}
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
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card data-card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl  position-absolute">
                                <i class="material-icons opacity-10">attach_money</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Collection</p>
                                <h4 class="mb-0">{{ number_format($totalCollections, 2) }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">

                        </div>
                    </div>
                </div>
                {{-- Total Expenses --}}
                {{-- @if ($totalCollections > 0 || $totalExpenses > 0) --}}
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card data-card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl  position-absolute">
                                <i class="material-icons opacity-10">money_off</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Expenses</p>
                                <h4 class="mb-0">{{ number_format($totalExpenses, 2) }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3 d-flex justify-content-between align-items-center">
                            {{-- <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span>
                                than
                                yesterday</p> --}}
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
                {{-- Total Wallet --}}
                {{-- @if ($totalCollections > 0 || $totalExpenses > 0) --}}
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card data-card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl  position-absolute">
                                <i class="material-icons opacity-10">account_balance_wallet</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Wallet</p>

                                <h4 class="mb-0 {{ $totalWallet < 0 ? 'wallet-negative' : 'text-dark' }}">
                                    {{ number_format($totalWallet, 2) }}
                                </h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3 d-flex justify-content-between align-items-center">
                            {{-- <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span>
                                than
                                yesterday</p> --}}
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
            </div>
            {{--
        </div> --}}
        {{-- </div> --}}
    <div class="loader-container" wire:loading>
        <div class="loader"></div>
    </div>
</div>
</div>