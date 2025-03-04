
    <!-- Navbar -->
    <!-- End Navbar -->
    <!-- <div class="container-fluid py-4"> -->

    
        <div class="container">
            <section class="admin__title mb-5">
                <h5>Customer List</h5>
            </section>
    
            <section>
                <div class="search__filter">
                    <!-- <div class="row align-items-center justify-content-end">
                        <div class="col-auto">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-auto mt-3">
                                   {{-- <a href="{{ route('admin.user-address-form') }}" class="btn btn-outline-success select-md">Add Customer</a> --}}
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="row align-items-center justify-content-end">
                        <!-- <div class="col-auto">
                            <p class="text-sm font-weight-bold">Items</p>
                        </div> -->
                        <div class="col-auto">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto mt-0">
                                    <input type="text" wire:model="search" class="form-control select-md bg-white" id="customer"
                                        placeholder="Search Customers" value=""
                                        style="width: 350px;"  wire:keyup="FindCustomer($event.target.value)">
                                </div>
                        
                                <div class="col-auto mt-3">
                                    <button type="button" wire:click="resetForm" class="btn btn-outline-danger select-md">Clear</button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-primary select-md" data-bs-toggle="modal" data-bs-target="#importModal">
                                        <i class="fas fa-file-csv me-1"></i> Import
                                    </button>
                                </div>
                              
                                
                                <div class="col-auto">
                                    <button wire:click="export" class="btn btn-outline-success select-md"><i class="fas fa-file-csv me-1"></i>Export</button>
                                </div>
                                <!-- Import Modal -->
                                <div wire:ignore.self class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="importModalLabel">Import CSV File</h5>
                                                <button type="button" class="btn btn-outline-danger custom-btn-sm" data-bs-dismiss="modal">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Display Success/Error Messages -->
                                                @if (session()->has('success'))
                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                @endif
                                                @if (session()->has('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif
                                                
                                                <form wire:submit.prevent="import" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label for="file" class="form-label">Upload CSV File</label>
                                                        <input type="file" wire:model="file" class="form-control">
                                                        @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                   
                                                    <div class="d-flex justify-content-end  ">
                                                        <div class="col-md-auto select-md">
                                                            <button type="submit" class="btn-sm btn-success">
                                                                <i class="fas fa-file-csv me-1"></i> Import
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button wire:click="sampleExport" class="btn btn-outline-success select-md"><i class="fas fa-file-csv me-1"></i>Sample CSV Download</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                        <div class="col-auto">
                        <a href="{{ route('admin.user-address-form') }}" class="btn btn-outline-success select-md">Add Customer</a>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body pb-0">
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">
                                               Profile Image
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">
                                                Name
                                            </th>
                                            {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">
                                                Email
                                            </th> --}}
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">
                                                Phone
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">
                                               Company Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">
                                              Status
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">
                                               Action
                                            </th>
                                            <th class="text-secondary opacity-10"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            @if($user->email != 'admin@gmail.com') 
                                                <tr>
                                                   <td>
                                                        @if ($user->profile_image)
                                                            <img src="{{asset($user->profile_image)}}" alt="profile-image" width="85px">
                                                        @else
                                                            <img src="{{asset("assets/img/profile_image.png")}}" alt="profile-image" width="85px">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!--<div class="d-flex py-1">-->
                                                            <!-- <div>
                                                                <img src="{{ asset('assets/img/team-2.jpg') }}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                            </div> -->
                                                            <!--<div class="d-flex flex-column justify-content-center">-->
                                                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                            <!--</div>-->
                                                        <!--</div>-->
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $user->phone }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $user->company_name ?? 'N/A'}}</p>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input ms-auto" type="checkbox" wire:click="toggleStatus({{ $user->id }})" 
                                                            @if ($user->status)
                                                                checked
                                                            @endif>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="{{ route('admin.customers.details', ['id' => $user->id]) }}" class="btn btn-outline-dark custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="View Details" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.customers.edit', ['id' => $user->id]) }}" class="btn btn-outline-info custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="Edit user" title="Edit Customer">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button wire:click="deleteCustomer({{ $user->id }})" class="btn btn-outline-danger custom-btn-sm mb-0" title="Delete Customer"><i class="fas fa-trash"></i></button>
                                                        <a href="{{route('admin.order.new',['user_id' => $user->id])}}" class="btn btn-outline-primary custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="Place Order" title="Place Order">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </a>
                                                          <!-- Purchase History (Ledger) Button -->
                                                        <a href="{{route('admin.order.index',['customer_id' => $user->id])}}" class="btn btn-outline-secondary custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="Purchase History" title="Purchase History">
                                                            <i class="fas fa-file-invoice"></i>
                                                        </a>
    
                                                        <!-- Add Payment Button -->
                                                        <a href="" class="btn btn-outline-success custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="Add Payment" title="Add Payment">
                                                            <i class="fas fa-credit-card"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
    
                                </table>
                            </div>
                            <div class="mt-3">
                                <nav aria-label="Page navigation">
                                    {{ $users->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.addEventListener('close-import-modal', event => {
                var importModal = document.getElementById('importModal');
                var modal = bootstrap.Modal.getInstance(importModal);
                modal.hide();
            });
        </script>
        