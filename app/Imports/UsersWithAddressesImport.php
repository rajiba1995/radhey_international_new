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

class UsersWithAddressesImport implements ToModel, WithHeadingRow
{
    
    
    public function model(array $row)
    {
        $userType = strtolower(trim($row['user_type'])) == 'staff' ? 0 : 1;

         // Fetch country details for validation
         $country = Country::where('country_code', $row['country_code'])->first();
         $mobileLength = $country ? $country->mobile_length : 10; // Default to 10 if country not found
 
         // Validate phone numbers dynamically
         $validator = Validator::make($row, [
             'phone'        => "required|numeric|digits:$mobileLength",
             'whatsapp_no'  => "required|numeric|digits:$mobileLength",
         ]);
 
         if ($validator->fails()) {
             // Handle validation failure (log it, skip, or throw an error)
             return null;
         }
        // Create or update user record


        $user = User::updateOrCreate(
            ['email' => $row['email']], // Unique identifier
            [
                'name' => $row['customer_name'],
                'dob' => $row['dob'] ?? null,
                'user_type' => $userType,
                'company_name' => $row['company_name'] ?? null,
                'employee_rank' => $row['employee_rank'] ?? null,
                'country_code' => $row['country_code'] ?? null,
                'phone' => $row['phone'] ?? null,
                'phone_one' => $row['phone_one'] ?? null,
                'phone_two' => $row['phone_two'] ?? null,
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
    }


    public function rules(): array
    {
        return [
            'user_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'country_code'  => 'required|string|exists:countries,country_code',
            'phone'         => ['required', 'numeric', function ($attribute, $value, $fail) {
                $country = Country::where('country_code', request()->input('country_code'))->first();
                $expectedLength = $country ? $country->mobile_length : 10;
                if (strlen($value) != $expectedLength) {
                    $fail("The $attribute must be exactly $expectedLength digits long.");
                }
            }],
            'whatsapp_no'   => ['required', 'numeric', function ($attribute, $value, $fail) {
                $country = Country::where('country_code', request()->input('country_code'))->first();
                $expectedLength = $country ? $country->mobile_length : 10;
                if (strlen($value) != $expectedLength) {
                    $fail("The $attribute must be exactly $expectedLength digits long.");
                }
            }],
        ];
    }
}

