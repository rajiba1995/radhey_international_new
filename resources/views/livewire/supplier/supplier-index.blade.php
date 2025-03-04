<div class="container">
    <section class="admin__title">
        <h5>Supplier List</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li>Supplier</li>
            <li></li>
            <!-- <li>Create Customer</li> -->
        </ul>
        <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <!-- <p class="text-sm font-weight-bold">Items</p> -->
                </div>
            </div>
    </section>
    <section>
        <div class="search__filter">
            <div class="row align-items-center justify-content-end">
                <div class="col-auto">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto mt-0">
                            <input type="text" wire:model="search" class="form-control select-md bg-white" id="customer"
                                placeholder="Search by supplier name or PO number" value=""
                                style="width: 350px;"  wire:keyup="FindSupplier($event.target.value)">
                        </div>
                        <div class="col-md-auto mt-3">
                            <a href="{{ route('suppliers.add') }}" class="btn btn-outline-success select-md">Add Supplier</a>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </section>
    
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
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

                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Phone
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                       Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                       Action
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                        <tr>
                                            <td>
                                                <div class="d-flex py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $supplier->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $supplier->email ?? 'N/A'}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $supplier->mobile }}</p>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input ms-auto" type="checkbox" wire:click="toggleStatus({{ $supplier->id }})" 
                                                    @if ($supplier->status)
                                                        checked
                                                    @endif
                                                    >
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                            <a href="{{ route('suppliers.details', $supplier->id) }}" class="btn btn-outline-dark custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="View Details" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}"  class="btn btn-outline-info custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="Edit supplier" title="Edit Supplier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button wire:click="deleteSupplier({{ $supplier->id }})" class="btn btn-outline-danger custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="Delete supplier" title="Delete Supplier">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>

                        </table>
                         {{-- {{ $suppliers->links() }} --}}
                    </div>
                    <div class="mt-3">
                        <nav aria-label="Page navigation">
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

