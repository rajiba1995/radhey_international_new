<div class="container">
    <section class="admin__title">
        <h5>Catalogue Pages</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li>Catalogue Pages</li>
            <li></li>
            <!-- <li>Create Customer</li> -->
        </ul>
       
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
                                @elseif(session()->has('error'))
                                    <div class="alert alert-danger" id="flashMessage">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                
                                <!-- <div class="col-lg-6 col-5 my-auto text-end">
                                    <div class="input-group w-100 search-input-group">
                                        <input type="text" wire:model.debounce.500ms="search" class="form-control border" placeholder="Search Title">
                                        <button type="button" wire:target="search" class="btn btn-outline-primary mb-0">
                                            <span class="material-icons">search</span>
                                        </button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="card-body pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">SL</th> --}}
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Catalogue</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Page</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pages as $index => $page)
                                            <tr>
                                                {{-- <td><h6 class="mb-0 text-sm">{{ $index + 1 }}</h6></td> --}}
                                                
                                                <td><p class="text-xs font-weight-bold mb-0">{{ $page->catalogue && $page->catalogue->catalogueTitle ?$page->catalogue->catalogueTitle->title : "" }}</p></td>
                                                <td><p class="text-xs font-weight-bold mb-0">{{ $page->page_number }}</p></td>
                                                <td class="align-middle">
                                                    <button wire:click="setCatalogueAndPage({{ $page->catalogue_id }} , {{$page->page_number}})" class="btn btn-outline-primary select-md btn_action btn_outline" title="Edit">
                                                        Click
                                                    </button>
                                                   
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination-nav">
                                {{-- {{ $catalogs->links() }} --}}
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
                                <h5>Catalogue Page Item</h5>  
                            </div>
                            <form wire:submit.prevent="store">
                                <div class="row">
                                    <!-- Title -->
                                    <label class="form-label">Catalogue</label>
                                    <div class="ms-md-auto pe-md-3 d-flex align-items-center mb-2">
                                        <input type="text" wire:model="catalogue_name" readonly class="form-control">
                                    </div>
                                    @error('catalogue_name')
                                        <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
    
                                    <!-- Page  -->
                                    <label class="form-label">Page</label>
                                    <div class="ms-md-auto pe-md-3 d-flex align-items-center mb-2">
                                       <input type="number" wire:model="page_number" readonly class="form-control">
                                    </div>
                                    @error('page_number')
                                        <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror


                                    <label class="form-label">Page Item</label>
                                    @foreach($catalog_items as $index => $item)
                                        <div class="ms-md-auto pe-md-3 d-flex align-items-center mb-2">
                                        <input type="text" wire:model="catalog_items.{{$index}}" placeholder="Enter Page Item" class="form-control">
                                        @if($index > 0)
                                         <button type="button" class="btn btn-danger btn-sm ms-2 mt-2" wire:click="removeItem({{ $index }})"><span class="material-icons">delete</span></button>
                                        @endif
                                        </div>
                                        @error("catalog_items.{$index}")
                                            <p class="text-danger inputerror">{{ $message }}</p>
                                        @enderror
                                    @endforeach
                                    <!-- Add More Button -->
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-success select-md" wire:click="addItem"><i class="material-icons me-1">add</i>Add More</button>
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="mb-2 text-end mt-4">
                                        {{-- @if($cataloguePageId)
                                        <a href="javascript:void(0);" 
                                        class="btn btn-sm btn-danger select-md" 
                                        wire:click.prevent="resetFields">
                                        Clear
                                        </a>
                                        @endif --}}
                                        <button type="submit" class="btn btn-sm btn-success select-md" wire:loading.attr="disabled">
                                            <span>Create</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>