<div class="container">
    <section class="admin__title">
        <h5>Fabrics</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li>Fabrics</li>
            <li></li>
            <!-- <li>Create Customer</li> -->
        </ul>
        <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <!-- <p class="text-sm font-weight-bold">Items</p> -->
                </div>
            </div>
    </section>
    <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                @if(session()->has('message'))
                                    <div class="alert alert-success" id="flashMessage">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                        <div class="card-body pb-2">
                        <section>
                            <div class="search__filter">
                                <div class="row align-items-center justify-content-end">
                                    <div class="col-auto">
                                        <div class="row g-3 align-items-center">
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
                                </div>
                            </div>
                        </section>
                            <div class="d-flex justify-content-between mb-3">
                                <!-- Import Form -->
                                    @if(session()->has('error'))
                                        <span class="text-danger">{{ session('error') }}</span>
                                    @endif
                                    @if(session()->has('success'))
                                        <span class="text-success">{{ session('success') }}</span>
                                    @endif
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" >
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Title</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        @foreach ($fabrics as $fabric)
                                      
                                            <tr data-id="{{ $fabric->id }}" class="handle">
                                                <td class="align-middle">
                                                     @if ($fabric->image)
                                                         <img src="{{ asset($fabric->image) }}" alt="Fabric Image" width="70" style="border-radius: 10px;">
                                                     @else
                                                         <img src="{{ asset('assets/img/fabric.webp') }}" alt="Fabric Image" width="70" style="border-radius: 10px;">
                                                     @endif
                                                </td>
                                                <td><h6 class="mb-0 text-sm">{{ ucwords($fabric->title) }}</h6></td>
                                                <td class="align-middle text-center">
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" 
                                                            class="form-check-input ms-auto" 
                                                            wire:click="toggleStatus({{ $fabric->id }})" 
                                                            @if ($fabric->status) checked @endif>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <button wire:click="edit({{ $fabric->id }})" class="btn btn-outline-primary select-md btn_action btn_outline">Edit
                                                    </button>
                                                    <button wire:click="destroy({{ $fabric->id }})"  class="btn btn-outline-danger select-md btn_outline">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end mt-2">
                                    {{-- {{$fabrics->links()}} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body px-0 pb-2 mx-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>{{ $fabricId ? 'Update Fabric' : 'Create Fabric' }}</h5>
                            </div>
                            <form wire:submit.prevent="{{ $fabricId ? 'update' : 'store' }}">
                                <!-- Measurement Title -->
                                <div class="form-group mb-3">
                                    <input type="hidden" wire:model="product_id" id="product_id">
                                    <label for="title">Fabric Title <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        id="title" 
                                        wire:model="title" 
                                        class="form-control border border-2 p-2" 
                                        placeholder="Enter Title" 
                                        aria-describedby="titleHelp">
                                    @error('title') 
                                        <small id="titleHelp" class="text-danger">{{ $message }}</small> 
                                    @enderror
                                </div>
                                
                              <!--Threshold Price -->
                                <div class="form-group mb-3">
                                <label for="threshold_price">Threshold Price <span class="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    id="threshold_price" 
                                    wire:model="threshold_price" 
                                    class="form-control border border-2 p-2" 
                                    placeholder="Enter Thereshold Price" 
                                    aria-describedby="thresholdpriceHelp">
                                @error('threshold_price') 
                                    <small id="thresholdpriceHelp" class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                            
                                <!--  Code -->
                                <div class="form-group mb-3">
                                    <label for="image">Color Image</label>
                                    <input 
                                        type="file" 
                                        id="image" 
                                        wire:model="image" 
                                        class="form-control border border-2 p-2" 
                                        aria-describedby="imageHelp">
                                        @if(is_object($image))
                                            <img src="{{ $image->temporaryUrl() }}" alt="Preview" width="100">
                                        @endif
                                    @error('image') 
                                        <small id="imageHelp" class="text-danger">{{ $message }}</small> 
                                    @enderror
                                </div>
    
                                <!-- Submit Button -->
                                <div class="text-end">
                                @if($fabricId)
                                        <a href="javascript:void(0);" 
                                        class="btn btn-sm btn-danger select-md" 
                                        wire:click.prevent="resetFields">
                                        Clear
                                        </a>
                                        @endif
                                    <button type="submit" class="btn btn-sm btn-success select-md">
                                        {{ $fabricId ? 'Update Fabric' : 'Create Fabric' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>