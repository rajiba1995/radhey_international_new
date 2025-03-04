<div class="">
    <!-- Navbar -->
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row align-items-center my-sm-3">
        <div class="col-lg-6 col-md-6 text-start">
            <h4 class="block-heading mb-0">Staff</h4>
        </div>
        <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end text-end">
                <!-- Single Button -->
                <a class="btn btn-cta btn-sm mb-0" href="{{route('staff.add')}}" role="button" >
                    <i class="material-icons text-white" style="font-size: 15px;">add</i>
                    <span class="ms-1">Add New Staff</span>
                </a>
            </div>
        </div>
      </div>
        <div class="row">
            <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body pb-0">
                            <!-- Display Success Message -->
                            @if (session('message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Display Error Message -->
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Designation</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Contact</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Action</th>
                                            {{-- <th class="text-secondary opacity-7"></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($staff as $key=> $member)
                                        <tr>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ucwords($member->name)}}</p></td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ ucwords($member->designationDetails->name ?? 'N/A')  }}</p></td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><span>Mobile:</span><strong>{{ $member->phone ?? 'N/A' }}</strong> <br>
                                                <span>WhatsApp:</span><strong>{{ $member->whatsapp_no ?? 'N/A' }}</strong></p> 
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input ms-auto" type="checkbox" wire:click="toggleStatus({{ $member->id }})" 
                                                    @if ($member->status)
                                                        checked
                                                    @endif>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                 <a href="{{route('staff.update',$member->id)}}" class="btn btn-outline-primary select-md btn_action btn_outline" data-toggle="tooltip" data-original-title="Edit Staff" title="Edit">Edit
                                                </a>
                                                 <a href="{{route('staff.view',$member->id)}}" class="btn btn-outline-primary select-md btn_action btn_outline" data-toggle="tooltip" data-original-title="View Staff" title="View">View
                                                </a>
                                                 {{-- <a href="{{route('staff.task',$member->id)}}" class="btn btn-outline-info btn-sm custom-btn-sm mb-0" data-toggle="tooltip" data-original-title="Staff Task" title="Task">
                                                    <span class="material-icons">assignment</span>
                                                </a> --}}
                                                @if ($member->designationDetails && $member->designationDetails->id == 2)
                                                    <a href="{{route('staff.cities.add',$member->id)}}" class="btn btn-outline-primary select-md btn_action btn_outline" data-toggle="tooltip" data-original-title="Staff City" title="City">
                                                        <span class="material-icons">place</span>
                                                    </a>
                                                @endif
                                                 @if ($member->designationDetails && $member->designationDetails->id == 2)
                                                    <a href="{{route('salesman.index',['staff_id'=>$member->id])}}" class="btn btn-outline-primary select-md btn_action btn_outline">
                                                    Bill Books
                                                    </a>
                                                @endif
                                               
                                               {{-- <button wire:click="deleteProduct({{ $member->id }})" class="btn btn-outline-danger btn-sm custom-btn-sm mb-0">Delete</button> --}}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">No Staff found.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="mt-3">
                                <nav aria-label="Page navigation">
                                    {{ $staff->links('pagination::bootstrap-5') }}
                                </nav>
                            </div> --}}
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>


