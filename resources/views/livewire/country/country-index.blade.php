<div class="container">
    <section class="admin__title">
        <h5>Country</h5>
    </section>
    <section>
        <ul class="breadcrumb_menu">
            <li>Country</li>
            <li></li>
            <!-- <li>Create Customer</li> -->
        </ul>
       
    </section>

    <div class="row mb-4">
        <div class="col-lg-12">
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
                            <div class="card-body pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">SL</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Country</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Status</th>
                                                {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($country as $index => $countries)
                                                <tr>
                                                    <td><h6 class="mb-0 text-sm">{{ $index + 1 }}</h6></td>
                                                    
                                                    <td><p class="text-xs font-weight-bold mb-0">{{ $countries->title }}</p></td>
                                                    <td class="align-middle">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input ms-auto" type="checkbox" wire:click="toggleStatus({{ $countries->id }})" 
                                                            @if ($countries->status)
                                                                checked
                                                            @endif>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $country->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>