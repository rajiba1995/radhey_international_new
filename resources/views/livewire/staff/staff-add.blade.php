<div class="container-fluid px-2 px-md-4">
    <div class="card card-body">
        <h4 class="m-0">Create Staff</h4>
        <div class="card-header pb-0 p-3">
            <div class="row">
                {{-- Supplier Information --}}
                <div class="col-md-6 d-flex align-items-center">
                    <h6 class="badge bg-danger custom_danger_badge">Basic Information</h6>
                </div>
                <div class="col-md-6 text-end">
                    <div class="row">
                        <div class="col-10">
                            <select wire:model="selectedBusinessType" class="form-select me-2 form-control"
                                aria-label="Default select example">
                                <option selected hidden>Select Domain</option>
                                @foreach ($Business_type as $domain)
                                <option value="{{$domain->id}}">{{$domain->title}}</option>
                                @endforeach

                            </select>
                            @error('selectedBusinessType')
                            <div class="text-danger error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2">
                            <a href="{{ route('staff.index') }}" class="btn btn-cta btn-sm">
                                <i class="material-icons text-white" style="font-size: 15px;">chevron_left</i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-3">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="branch_id" class="form-label">Branch Name <span class="text-danger">*</span></label>
                        <select wire:model="branch_id" id="branch_id"
                            class="form-control form-control-sm border border-1 p-2">
                            <option value="" selected hidden>Select Branch</option>
                            @foreach ($branchNames as $branchName)
                            <option value="{{$branchName->id}}">{{ucwords($branchName->name)}}</option>
                            @endforeach
                        </select>
                        @error('branch_id')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="team_lead" class="form-label">Team Lead <span class="text-danger">*</span></label>
                        <select wire:model="team_lead" id="team_lead" class="form-control form-control-sm border border-1 p-2">
                            <option value="" selected hidden>Select Team Lead</option>
                            @foreach ($teamLeads as $lead)
                            <option value="{{ $lead->id }}">{{ ucwords($lead->name) }} {{ucwords($lead->surname)}}@if($lead->prof_name)({{ucwords($lead->prof_name)}})@endif</option>
                            @endforeach
                        </select>
                        @error('team_lead')
                            <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
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
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label for="emp_code" class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" wire:model="emp_code" id="emp_code" 
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Your Code" readonly>
                        @error('emp_code')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="person_name" class="form-label">Person Name <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <select wire:model="prefix" class="form-control form-control-sm border border-1" style="max-width: 60px;">
                                <option value="" selected hidden>Prefix</option>
                                @foreach (App\Helpers\Helper::getNamePrefixes() as $prefix)
                                    <option value="{{$prefix}}">{{ $prefix }}</option>
                                @endforeach
                            </select>
                            <input type="text" wire:model="person_name" id="person_name"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Person Name">
                        </div>
                        @error('prefix')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                        @error('person_name')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                        <input type="text" wire:model="surname" id="surname"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Surname">
                        @error('surname')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="prof_name" class="form-label">Prof. Name <span class="text-danger">*</span></label>
                        <input type="text" wire:model="prof_name" id="prof_name"
                            class="form-control form-control-sm border border-1 p-2"
                            placeholder="Enter Profession Name">
                        @error('prof_name')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" wire:model="email" id="email"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Email">
                        @error('email')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                        <div class="extention-group">
                            <select wire:model="selectedCountryPhone"
                                wire:change="GetCountryDetails($event.target.selectedOptions[0].getAttribute('data-length'), 'phone')"
                                class="form-control form-control-sm">
                                <option value="" selected hidden>Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->country_code }}"
                                    data-length="{{$country->mobile_length}}">{{
                                    $country->title }} ({{ $country->country_code
                                    }})</option>
                                @endforeach
                            </select>
                            <input type="text" wire:model="mobile" id="mobile"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Staff Mobile No" maxLength={{ $mobileLengthPhone }}>
                        </div>
                        @error('mobile')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                        <div>
                            <input type="checkbox" id="is_whatsapp1" wire:model="isWhatsappPhone">
                            <label for="is_whatsapp1" class="form-check-label ms-2">Is Whatsapp</label>
                        </div>
                    </div>


                    <div class="mb-3 col-md-3" >
                        <label for="aadhaar_number" class="form-label">Aadhaar Number
                            @if($showRequiredFields)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="text" wire:model="aadhaar_number" id="aadhaar_number"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Staff Aadhaar Number">
                        @error('aadhaar_number')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="whatsapp_no" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                        <div class=" align-items-center">

                            <div class="extention-group">
                                <select wire:model="selectedCountryWhatsapp"
                                    wire:change="GetCountryDetails($event.target.selectedOptions[0].getAttribute('data-length'), 'whatsapp')"
                                    class="form-control form-control-sm">
                                    <option value="" selected hidden>Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_code }}" data-length="{{$country->mobile_length}}">{{
                                        $country->title }} ({{ $country->country_code }})</option>
                                    @endforeach
                                </select>
                                <input type="text" wire:model="whatsapp_no" id="whatsapp_no"
                                class="form-control form-control-sm border border-1 p-2 me-2"
                                placeholder="Staff WhatsApp No" @if($is_wa_same) disabled @endif maxLength={{ $mobileLengthWhatsapp }}>
                            </div>
                        </div>
                        @error('whatsapp_no')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="mobile" class="form-label">alternative phone number 1 </label>
                        <div class="extention-group">
                            <select wire:model="selectedCountryAlt1"
                                    wire:change="GetCountryDetails($event.target.selectedOptions[0].getAttribute('data-length'), 'alt_phone_1')"
                                    class="form-control form-control-sm">
                                    <option value="" selected hidden>Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_code }}" data-length="{{$country->mobile_length}}">{{
                                        $country->title }} ({{ $country->country_code
                                        }})</option>
                                    @endforeach
                                </select>
                            <input type="text" wire:model="alternative_phone_number_1" class="form-control form-control-sm border border-1 p-2" placeholder="Alternative Phone No" maxLength={{ $mobileLengthAlt1 }}>
                        </div>
                        @error('alternative_phone_number_1')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                        <div>
                            <input type="checkbox" id="is_whatsapp2" wire:model="isWhatsappAlt1">
                            <label for="is_whatsapp2" class="form-check-label ms-2">Is Whatsapp</label>
                        </div>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="mobile" class="form-label">alternative phone number 2 </label>
                        <div class="extention-group">
                            <select wire:model="selectedCountryAlt2"
                                    wire:change="GetCountryDetails($event.target.selectedOptions[0].getAttribute('data-length'), 'alt_phone_2')"
                                    class="form-control form-control-sm">
                                    <option value="" selected hidden>Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_code }}" data-length="{{$country->mobile_length}}">{{
                                        $country->title }} ({{ $country->country_code
                                        }})</option>
                                    @endforeach
                            </select>
                            <input type="text" wire:model="alternative_phone_number_2" class="form-control form-control-sm border border-1 p-2" placeholder="Alternative Phone No" maxLength={{ $mobileLengthAlt2 }}>
                        </div>
                        @error('alternative_phone_number_2')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                        <div>
                            <input type="checkbox" id="is_whatsapp3" wire:model="isWhatsappAlt2">
                            <label for="is_whatsapp3" class="form-check-label ms-2">Is Whatsapp</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Image Upload Section -->
                    <div class="col-md-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" wire:model="image" id="image"
                            class="form-control form-control-sm border border-1 p-2">
                        @error('image')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                        @if ($image)
                        <div class="mt-2">
                            <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail"
                                style="max-width: 100px; display: block;" />
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label for="passport_id_front" class="form-label">Passport ID Front</label>
                        <input type="file" wire:model="passport_id_front" id="passport_id_front"
                            class="form-control form-control-sm border border-1 p-2">
                        @error('passport_id_front')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                        @if ($passport_id_front)
                        <div class="mt-2">
                            <img src="{{ $passport_id_front->temporaryUrl() }}" class="img-thumbnail"
                                style="max-width: 100px; display: block;" />
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label for="passport_id_back" class="form-label">Passport ID Back</label>
                        <input type="file" wire:model="passport_id_back" id="passport_id_back"
                            class="form-control form-control-sm border border-1 p-2">
                        @error('passport_id_back')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                        @if ($passport_id_back)
                        <div class="mt-2">
                            <img src="{{ $passport_id_back->temporaryUrl() }}" class="img-thumbnail"
                                style="max-width: 100px; display: block;" />
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                        <input type="date" wire:model="passport_expiry_date" id="passport_expiry_date"
                            class="form-control form-control-sm border border-1 p-2">
                        @error('passport_expiry_date')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3" >
                        <label for="passport_no" class="form-label">Passport No.
                            @if ($showRequiredFields)
                             <span class="text-danger">*</span>  
                            @endif
                        </label>
                        <input type="number" wire:model="passport_no" id="passport_no"
                            class="form-control form-control-sm border border-1 p-2"
                            placeholder="Enter Passport Number">
                        @error('passport_no')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="dob" class="form-label">D.O.B <span class="text-danger">*</span></label>
                        <input type="date" wire:model="dob" id="dob"
                            class="form-control form-control-sm border border-1 p-2" max="{{now()->format('Y-m-d')}}">
                        @error('dob')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="passport_issued_date" class="form-label">Passport Issued Date </label>
                        <input type="date" wire:model="passport_issued_date" id="passport_issued_date"
                            class="form-control form-control-sm border border-1 p-2">
                        @error('passport_issued_date')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3"  >
                        <label for="visa_no" class="form-label">Visa No. 
                            @if ($showRequiredFields)
                            <span class="text-danger">*</span>  
                           @endif
                        </label>
                        <input type="visa_no" wire:model="visa_no" id="visa_no"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Enter Visa Number">
                        @error('visa_no')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- Emergency Contact Information --}}
                <div class="col-md-8 mt-4 d-flex align-items-center">
                    <h6 class="badge bg-danger custom_danger_badge">Emergency Contact Information</h6>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label class="form-label">Contact Name</label>
                        <input type="text" wire:model="emergency_contact_person"
                            class="form-control form-control-sm border border-1 p-2"
                            placeholder="Enter Emergency Contact Name">
                        @error('emergency_contact_person')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-4">
                        <label class="form-label">Contact Number</label>
                        <div class="extention-group">
                        <select wire:model="selectedCountryEmergencyContact"
                                wire:change="GetCountryDetails($event.target.selectedOptions[0].getAttribute('data-length'), 'emergency_contact')"
                                class="form-control form-control-sm">
                                <option value="" selected hidden>Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->country_code }}" data-length="{{$country->mobile_length}}">{{
                                    $country->title }} ({{ $country->country_code
                                    }})
                                </option>
                                @endforeach
                        </select>
                        <input type="text" wire:model="emergency_mobile"
                            class="form-control form-control-sm border border-1 p-2"
                            placeholder="Enter Emergency Mobile Number" maxLength={{ $mobileLengthEmergencyContact }}>
                        </div>
                        @error('emergency_mobile')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                        <div>
                            <input type="checkbox" id="is_whatsapp4" wire:model="isWhatsappEmergency">
                            <label for="is_whatsapp4" class="form-check-label ms-2">Is Whatsapp</label>
                        </div>
                    </div>

                    <!-- Checkbox to Copy Contact Number to WhatsApp Number -->
                    {{-- <div class="col-md-4 d-flex align-items-center mt-4">

                    </div> --}}

                    <!-- WhatsApp Number -->
                    <div class="col-md-4">
                        <label class="form-label">WhatsApp Number</label>
                        <div class=" align-items-center">
                            <div class="extention-group">
                            <select wire:model="selectedCountryEmergencyWhatsapp"
                                    wire:change="GetCountryDetails($event.target.selectedOptions[0].getAttribute('data-length'), 'emergency_whatsapp')"
                                    class="form-control form-control-sm">
                                    <option value="" selected hidden>Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_code }}" data-length="{{$country->mobile_length}}">{{
                                        $country->title }} ({{ $country->country_code
                                        }})</option>
                                    @endforeach
                            </select>
                            <input type="text" wire:model="emergency_whatsapp"
                                class="form-control form-control-sm border border-1 p-2"
                                placeholder="Enter Emergency WhatsApp Number" maxLength={{ $mobileLengthEmergencyWhatsapp }}>
                            </div>
                        </div>
                        @error('emergency_whatsapp')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Address -->
                    <div class="col-md-4">
                        <label class="form-label">Contact Address</label>
                        <textarea wire:model="emergency_address"
                            class="form-control form-control-sm border border-1 p-2"
                            placeholder="Enter Emergency Contact Address"></textarea>
                        @error('emergency_address')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Other Details -->
                <div class="col-md-8 mt-4 d-flex align-items-center">
                    <h6 class="badge bg-danger custom_danger_badge">Account Information</h6>
                </div>
                <div class="row mt-4">
                    <!-- Banking Information -->
                    <div class="col-md-4">
                        <label class="form-label">A/C Holder Name</label>
                        <input type="text" wire:model="account_holder_name"
                            class="form-control form-control-sm border border-1 p-2" placeholder="A/C Holder Name">
                        @error('account_holder_name')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bank Name</label>
                        <input type="text" wire:model="bank_name"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Bank Name">
                        @error('bank_name')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bank Branch Name</label>
                        <input type="text" wire:model="branch_name"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Branch Name">
                        @error('branch_name')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">Account No</label>
                        <input type="number" wire:model="account_no"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Account No">
                        @error('account_no')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">IFSC</label>
                        <input type="text" wire:model="ifsc" class="form-control form-control-sm border border-1 p-2"
                            placeholder="IFSC">
                        @error('ifsc')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Salary and Allowance -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label class="form-label">Salary (In 30 days) <span class="text-danger">*</span></label>
                        <input type="number" wire:model="monthly_salary"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Salary (30 Days)">
                        @error('monthly_salary')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bonus</label>
                        <input type="number" wire:model="daily_salary"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Bonus">
                        @error('daily_salary')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Past Salaries</label>
                        <input type="number" wire:model="travel_allowance"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Past Salaries">
                        @error('travel_allowance')
                        <div class="text-danger error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="col-md-8 mt-4 d-flex align-items-center">
                    <h6 class="badge bg-danger custom_danger_badge">Address Information</h6>
                </div>
                 <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Address</label>
                        <textarea wire:model="address" class="form-control form-control-sm border border-1 p-2"
                            placeholder="Address"></textarea>
                        @error('address')
                        <div class="text-danger error-message">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Landmark</label>
                        <input type="text" wire:model="landmark"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Landmark">
                        @error('landmark')
                        <div class="text-danger error-message">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">State 
                            @if ($showRequiredFields)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="text" wire:model="state" class="form-control form-control-sm border border-1 p-2"
                            placeholder="State">
                        @error('state')
                        <div class="text-danger error-message">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" wire:model="city" class="form-control form-control-sm border border-1 p-2"
                            placeholder="City">
                        @error('city')
                        <div class="text-danger error-message">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pincode</label>
                        <input type="number" wire:model="pincode"
                            class="form-control form-control-sm border border-1 p-2" placeholder="Pincode">
                        @error('pincode')
                        <div class="text-danger error-message">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="text" wire:model="password"
                            class="form-control form-control-sm border border-1 p-2" placeholder="password">
                        @error('password')
                        <div class="text-danger error-message">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        {{-- <label class="form-label">Country</label> --}}
                        <input type="hidden" wire:model="country" class="form-control form-control-sm border border-1 p-2"
                            placeholder="Country">
                        {{-- <input type="hidden" wire:model="password" value="yourPasswordHere"> --}}
                         @error('country')
                        <div class="text-danger error-message">{{$message}}</div>
                        @enderror
                    </div>
                </div> 
                <div class="text-end">
                    <button type="submit" class="btn btn-cta mt-4">Save</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
<script>
     window.addEventListener('error_message', event => {
        setTimeout(() => {
            let errorElement = document.querySelector(".error-message");
            if (errorElement) {
                errorElement.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        }, 100);
    });
</script>