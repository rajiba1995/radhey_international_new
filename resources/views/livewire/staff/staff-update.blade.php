<div class="container-fluid px-2 px-md-4">
    <div class="card card-body">
        <h4 class="m-0">Update Staff</h4>
        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                </div>
                <div class="col-md-6 align-items-center">
                    <div class="row">
                        <div class="col-4">
                            <select wire:model="selectedBusinessType" class="form-select me-2 form-control"
                                aria-label="Default select example">
                                <option selected hidden>Select Domain</option>
                                @foreach ($Business_type as $domain)
                                <option value="{{$domain->id}}">{{$domain->title}}</option>
                                @endforeach

                            </select>
                            @error('selectedBusinessType')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-5">
                            <select wire:change="SelectedCountry($event.target.value)" wire:model="selectedCountryId"
                                class="form-select form-control me-2" aria-label="Default select example">
                                <option selected hidden>Select Country</option>
                                @foreach($Selectcountry as $countries)
                                <option value="{{$countries->id}}">{{$countries->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <a href="{{ route('staff.index') }}" class="btn btn-cta btn-sm">
                                <i class="material-icons text-white" style="font-size: 15px;">chevron_left</i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-3">
            <form wire:submit.prevent="update">
                <div class="row">
                    {{-- Branch --}}
                    <div class="mb-3 col-md-6">
                        <label for="selectedBranchId" class="form-label">Branch Name <span
                                class="text-danger">*</span></label>
                        <select wire:model="selectedBranchId" id="selectedBranchId"
                            class="form-control form-control-sm border border-1 p-2">
                            <option value="" selected hidden>Select Branch</option>
                            @foreach ($branchNames as $branchName)
                            <option value="{{$branchName->id}}">{{ucwords($branchName->name)}}</option>
                            @endforeach
                        </select>
                        @error('selectedBranchId')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Designation --}}
                    <div class="mb-3 col-md-6">
                        <label for="designation" class="form-label">Designation <span
                                class="text-danger">*</span></label>
                        <select wire:model="designation" id="designation"
                            class="form-control form-control-sm border border-1 p-2">
                            <option value="" selected hidden>Select Designation</option>
                            @foreach ($designations as $designation)
                            <option value="{{$designation->id}}">{{ucwords($designation->name)}}</option>
                            @endforeach

                            <!-- Add more options as needed -->
                        </select>
                        @error('designation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label for="emp_code" class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" wire:model="emp_code" id="emp_code"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Your Code">
                        @error('emp_code')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="person_name" class="form-label">Person Name <span
                                class="text-danger">*</span></label>
                        <input type="text" wire:model="person_name" id="person_name"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Person Name">
                        @error('person_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                        <input type="text" wire:model="surname" id="surname"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Surname">
                        @error('surname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="prof_name" class="form-label">Prof. Name <span class="text-danger">*</span></label>
                        <input type="text" wire:model="prof_name" id="prof_name"
                            class="form-control form-control-sm border border-1 p-2"
                            placeholder="Enter Profession Name">
                        @error('prof_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                <!-- Contact Information -->
                <div class="row mt-2">
                    <div class="mb-3 col-md-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" wire:model="email" id="email"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Email">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                        <input type="text" wire:model="mobile" id="mobile"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Staff mobile">
                        @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3" @if ($selectedCountryId !=1) style="display: none;" @endif>
                        <label for="aadhaar_number" class="form-label">Aadhaar Number
                            @if($showRequiredFields)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="text" wire:model="aadhaar_number" id="aadhaar_number"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Staff Aadhaar Number">
                        @error('aadhaar_number')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="whatsapp_no" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                        <div class="align-items-center">
                            <input type="text" wire:model="whatsapp_no" id="whatsapp_no"
                                class="form-control form-control-sm border border-1 p-2 me-2"
                                placeholder="Staff WhatsApp No" @if($is_wa_same) disabled @endif>
                            <div class="custon-input-group">
                                <input type="checkbox" id="is_wa_same" wire:change="SameAsMobile" value="0"
                                    @if($is_wa_same) checked @endif>
                                <label for="is_wa_same" class="form-check-label ms-2">Same as Phone Number</label>
                            </div>
                        </div>
                        @error('whatsapp_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Image Upload Section -->
                    <div class="col-md-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" wire:model="image" id="image"
                            class="form-control form-control-sm border border-1 p-2">
                        @if($staff && $staff->image)
                        <img src="{{ asset('storage/' . $staff->image) }}" alt="Stored Image" class="mt-2" width="100">
                        @endif
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="passport_id_front" class="form-label">Passport ID Front</label>
                        <input type="file" wire:model="passport_id_front" id="passport_id_front"
                            class="form-control form-control-sm border border-1 p-2">
                        @if($staff && $staff->passport_id_front)
                        <img src="{{ asset('storage/' . $staff->passport_id_front) }}" alt="Stored User ID Front"
                            class="mt-2" width="100">
                        @endif

                        @error('passport_id_front')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="passport_id_back" class="form-label">Passport ID Back</label>
                        <input type="file" wire:model="passport_id_back" id="passport_id_back"
                            class="form-control form-control-sm border border-1 p-2">
                        @if($staff && $staff->passport_id_back)
                        <img src="{{ asset('storage/' . $staff->passport_id_back) }}" alt="Stored User ID Back"
                            class="mt-2" width="100">
                        @endif

                        @error('passport_id_back')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                        <input type="date" wire:model="passport_expiry_date" id="passport_expiry_date"
                            class="form-control form-control-sm border border-1 p-2">
                        @error('passport_expiry_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3" @if ($selectedCountryId !=1) style="display: none;" @endif>
                        <label for="passport_no" class="form-label">Passport No.
                            @if ($showRequiredFields)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="number" wire:model="passport_no" id="passport_no"
                            class="form-control form-control-sm border border-1 p-2"
                            placeholder="Enter Passport Number">
                        @error('passport_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="dob" class="form-label">D.O.B <span class="text-danger">*</span></label>
                        <input type="date" wire:model="dob" id="dob"
                            class="form-control form-control-sm border border-1 p-2">
                        @error('dob')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="passport_issued_date" class="form-label">Passport Issued Date </label>
                        <input type="date" wire:model="passport_issued_date" id="passport_issued_date"
                            class="form-control form-control-sm border border-1 p-2">
                        @error('passport_issued_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3" @if ($selectedCountryId !=1) style="display: none;" @endif>
                        <label for="visa_no" class="form-label">Visa No.
                            @if ($showRequiredFields)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="visa_no" wire:model="visa_no" id="visa_no"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Visa Number">
                        @error('visa_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Emergency Contact Information --}}
                <div class="col-md-8 mt-4 d-flex align-items-center">
                    <h6 class="badge bg-danger custom_danger_badge">Emergency Contact Information</h6>
                </div>
                <div class="row mt-4">
                    <!-- Banking Information -->
                    <div class="col-md-4">
                        <label class="form-label"> Contact Name</label>
                        <input type="text" wire:model="emergency_contact_person" id="emergency_contact_person"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Contact Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Number</label>
                        <input type="number" wire:model="emergency_mobile" id="emergency_mobile"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Mobile Number">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">WhatsApp Number</label>
                        <div class="align-items-center">
                            <input type="number" wire:model="emergency_whatsapp" id="emergency_whatsapp"
                                class="form-control form-control-sm border border-1 p-2"
                                placeholder="Enter Whatsapp Number">
                            <div class="custon-input-group">
                                <input type="checkbox" wire:model="same_as_contact" id="same_as_contact" class="me-2">
                                <label for="same_as_contact" class="form-check-label">Same as Contact Number</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Address</label>
                        <textarea type="text" wire:model="emergency_contact_person" id="emergency_contact_person"
                            class="form-control form-control-sm border border-1 p-2"
                            placeholder="Enter Contact Address"></textarea>
                    </div>
                </div>
                <!-- Other Details -->
                <div class="col-md-8 mt-4 mb-2 d-flex align-items-center">
                    <h6 class="badge bg-danger custom_danger_badge">Account Information</h6>
                </div>
                <div class="row">
                    <!-- Banking Information -->
                    <div class="col-md-4">
                        <label class="form-label">A/C Holder Name</label>
                        <input type="text" wire:model="account_holder_name"
                            class="form-control form-control-sm border border-1 p-2" placeholder="A/C Holder Name">
                        @error('account_holder_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bank Name</label>
                        <input type="text" wire:model="bank_name"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Bank Name">
                        @error('bank_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Branch Name</label>
                        <input type="text" wire:model="branch_name"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Branch Name">
                        @error('branch_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Account No</label>
                        <input type="text" wire:model="account_no"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Account No">
                        @error('account_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">IFSC</label>
                        <input type="text" wire:model="ifsc" class="form-control form-control-sm border border-1 p-2"
                            placeholder="IFSC">
                        @error('ifsc')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Salary and Allowance -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label class="form-label">Salary (In 30 days) <span class="text-danger">*</span></label>
                        <input type="text" wire:model="monthly_salary"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Salary (30 Days)">
                        @error('monthly_salary')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bonus</label>
                        <input type="text" wire:model="daily_salary"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Bonus">
                        @error('daily_salary')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Post Salaries</label>
                        <input type="text" wire:model="travel_allowance"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Post Salaries">
                        @error('travel_allowance')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="col-md-8 mt-4 d-flex align-items-center">
                    <h6 class="badge bg-danger custom_danger_badge">Address Information</h6>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label class="form-label">Address</label>
                        <input type="text" wire:model="address" class="form-control form-control-sm border border-1 p-2"
                            placeholder="Address">
                        @error('address')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Landmark</label>
                        <input type="text" wire:model="landmark"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Landmark">
                        @error('landmark')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4" @if ($selectedCountryId !=1) style="display: none;" @endif>
                        <label class="form-label">State
                            @if($showRequiredFields)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="text" wire:model="state" class="form-control form-control-sm border border-1 p-2"
                            placeholder="State">
                        @error('state')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" wire:model="city" class="form-control form-control-sm border border-1 p-2"
                            placeholder="City">
                        @error('city')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pincode</label>
                        <input type="text" wire:model="pincode" class="form-control form-control-sm border border-1 p-2"
                            placeholder="Pincode">
                        @error('pincode')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" wire:model="country" class="form-control form-control-sm border border-1 p-2"
                            placeholder="Country">
                        @error('country')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-cta mt-4">Save</button>
            </form>
        </div>
    </div>
</div>