<?php

namespace App\Imports;

use App\Models\User;
// use App\Models\UserAddress;
// use App\Models\User;
use App\Models\UserAddress;
// use App\Models\Branch;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;



class UsersWithAddressesImport implements ToModel, WithHeadingRow
{
    
    
    public function model(array $row)
    {
        
        try {
        DB::beginTransaction(); // Start transaction
            
            $country = Country::where('country_code', $row['country_code_phone'])->first();
            $mobileLength = $country->mobile_length ?? 10;
    
            $countryCodeAlt1 = Country::where('country_code', $row['country_code_alternet_phone_one'])->first();
            $mobileLength1 = $countryCodeAlt1->mobile_length ?? 10;
    
            $countryCodeAlt2 = Country::where('country_code', $row['country_code_alternet_phone_two'])->first();
            $mobileLength2 = $countryCodeAlt2->mobile_length ?? 10;
    
            // Perform validation
            $validator = Validator::make($row, [
                'phone' => "nullable|numeric|digits:$mobileLength",
                'alternet_phone_one' => "nullable|numeric|digits:$mobileLength1",
                'alternet_phone_two' => "nullable|numeric|digits:$mobileLength2",
                'whatsapp_number' => "nullable|numeric|digits:$mobileLength",
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->whereNull('deleted_at'),
                ],
            ]);
    
            if ($validator->fails()) {
                session()->push('import_errors', [
                    'row' => $row,
                    'errors' => $validator->errors()->all()
                ]);
                DB::rollBack(); // Rollback transaction if validation fails
                return null;
            }
    
            // Convert DOB format
            $dob = isset($row['dob']) ? Carbon::createFromFormat('m/d/Y', $row['dob'])->format('Y-m-d') : null;
    
            // Create or update user
            $user = User::updateOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['customer_name'] ?? null,
                    'dob' => $dob,
                    'user_type' => strtolower(trim($row['user_type'])) == 'staff' ? 0 : 1,
                    'company_name' => $row['company_name'] ?? null,
                    'employee_rank' => $row['rank'] ?? null,
                    'country_code_phone' => $row['country_code_phone'] ?? null,
                    'phone' => $row['phone'] ?? null,
                    'country_code_alt_1' => $row['country_code_alternet_phone_one'] ?? null,
                    'alternative_phone_number_1' => $row['alternet_phone_one'] ?? null,
                    'country_code_alt_2' => $row['country_code_alternet_phone_two'] ?? null,
                    'alternative_phone_number_2' => $row['alternet_phone_two'] ?? null,
                    'whatsapp_no' => $row['whatsapp_number'] ?? null,
                ]
            );
    
            // Save billing address
            if (!empty($row['address'])) {
                UserAddress::updateOrCreate(
                    ['user_id' => $user->id, 'address_type' => 1], // 1 = Billing
                    [
                        'address' => $row['address'],
                        'landmark' => $row['landmark'] ?? null,
                        'city' => $row['city'] ?? null,
                        'state' => $row['state'] ?? null,
                        'country' => $row['country'] ?? null,
                        'zip_code' => $row['zip_code'] ?? null,
                    ]
                );
            }
    
            DB::commit(); // Commit transaction if everything is successful
            return $user;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction if any exception occurs
          
            session()->flash('error', '🚨 Something went wrong. The operation has been rolled back.');
        }
    }
    

    

    


    // public function rules(): array
    // {
    //     // return [
    //     //     // 'name'     => 'required|string|max:255',
    //     //     // 'email'         => 'required|email|unique:users,email',
    //     //     // 'country_code'  => 'required|string|exists:countries,country_code',
    //     //     'phone'         => ['required', 'numeric', function ($attribute, $value, $fail) {
    //     //         // Get country_code from the $row array instead of request
    //     //         $countryCode = request()->input('country_code'); // or pass it as a parameter if required
    //     //         $country = Country::where('country_code', $countryCode)->first();
    //     //         $expectedLength = $country ? $country->mobile_length : 10;
    //     //         if (strlen($value) != $expectedLength) {
    //     //             $fail("The $attribute must be exactly $expectedLength digits long.");
    //     //         }
    //     //     }],
    //     //     'whatsapp_no'   => ['required', 'numeric', function ($attribute, $value, $fail) {
    //     //         // Get country_code from the $row array instead of request
    //     //         $countryCode = request()->input('country_code'); // or pass it as a parameter if required
    //     //         $country = Country::where('country_code', $countryCode)->first();
    //     //         $expectedLength = $country ? $country->mobile_length : 10;
    //     //         if (strlen($value) != $expectedLength) {
    //     //             $fail("The $attribute must be exactly $expectedLength digits long.");
    //     //         }
    //     //     }],
    //     // ];
    // }
     
}

