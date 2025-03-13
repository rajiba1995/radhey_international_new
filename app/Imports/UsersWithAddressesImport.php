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


class UsersWithAddressesImport implements ToModel, WithHeadingRow
{
    
    
    public function model(array $row)
    {
        try {
            // Determine user type (staff = 0, others = 1)
            $userType = isset($row['user_type']) && strtolower(trim($row['user_type'])) == 'staff' ? 0 : 1;
    
            // Fetch country details for validation
            $country = Country::where('country_code', $row['country_code'])->first();
            $mobileLength = $country ? $country->mobile_length : 10; // Default to 10 if country not found
    
            // Validation rules
            $validator = Validator::make($row, [
                'phone'        => "nullable|numeric|digits:$mobileLength",
                'whatsapp_no'  => "nullable|numeric|digits:$mobileLength",
                'email'        => "required|email|unique:users,email",
            ]);
    
            if ($validator->fails()) {
                $errorMessages = $validator->errors()->first(); // Get only the first error message
                session()->push('import_errors', [
                    'row' => $row,
                    'errors' => [$errorMessages] // Wrap the first error in an array
                ]);
                return null; // Skip this row
            }
    
            // Format date of birth
            $dob = isset($row['dob']) ? Carbon::createFromFormat('m/d/Y', $row['dob'])->format('Y-m-d') : null;
    
            // Create or update user
            $user = User::updateOrCreate(
                ['email' => $row['email']], // Unique identifier
                [
                    'name' => $row['customer_name'] ?? null,
                    'dob' => $dob,
                    'user_type' => $userType,
                    'company_name' => $row['company_name'] ?? null,
                    'employee_rank' => $row['employee_rank'] ?? null,
                    'country_code' => $row['country_code'] ?? null,
                    'phone' => $row['phone'] ?? null,
                    'alternative_phone_number_1' => $row['alternative_phone_number_1'] ?? null,
                    'alternative_phone_number_2' => $row['alternative_phone_number_2'] ?? null,
                    'whatsapp_no' => $row['whatsapp_no'] ?? null,
                    'image' => $row['image'] ?? null,
                ]
            );
    
            // Store or update user address (billing)
            if (!empty($row['billing_address'])) {
                UserAddress::updateOrCreate(
                    ['user_id' => $user->id, 'address_type' => 1], // 1 = Billing
                    [
                        'address' => $row['billing_address'],
                        'landmark' => $row['billing_landmark'] ?? null,
                        'city' => $row['billing_city'] ?? null,
                        'state' => $row['billing_state'] ?? null,
                        'country' => $row['billing_country'] ?? null,
                        'zip_code' => $row['billing_zip'] ?? null,
                    ]
                );
            }
    
            return $user;
        } catch (\Exception $e) {
            session()->push('import_errors', [
                'row' => $row,
                'errors' => [$e->getMessage()]
            ]);
            return null; // Skip row on error
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

