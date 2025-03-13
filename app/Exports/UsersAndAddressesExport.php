<?php

namespace App\Exports;

use App\Models\User;
use App\Models\UserAddress;
// use App\Models\Branch;
// use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersAndAddressesExport implements FromCollection, WithHeadings
{
    // public function collection()
    // {
    //     return User::leftJoin('user_address', 'users.id', '=', 'user_address.user_id')
    //         ->select(
    //             'users.id',
    //             'users.name',
    //             'users.email',
    //             'users.phone',
    //             'users.company_name',
    //             'users.designation',
    //             'user_address.address_type',
    //             'user_address.address',
    //             'user_address.city',
    //             'user_address.state',
    //             'user_address.country',
    //             'user_address.zip_code'
    //         )->get();
    // }

    // public function headings(): array
    // {
    //     return [
    //         'User ID', 'Name', 'Email', 'Phone', 'Company Name', 'Designation',
    //         'Address Type', 'Address', 'City', 'State', 'Country', 'Zip Code'
    //     ];
    // }
    // public function collection()
    // {
    //     // Fetch users along with their addresses using eager loading
    //     $users = User::with('userAddress') // Eager load the user addresses
    //         ->where('user_type', 1) // Adjust based on the requirement, assuming 1 means customers
    //         ->get();

    //     $data = $users->flatMap(function ($user) {
    
    //         $userType = $user->user_type == 0 ? 'Staff' : 'Customer';

    //         // Check if user has addresses
    //         return $user->userAddress->map(function ($address) use ($user, $userType) {
    //             $addressType = $address->address_type == 1 ? 'Billing Address' : 'Shipping Address';

    //             return [
    //                 'User Name' => $user->name,
    //                 'Company Name' => $user->company_name,
    //                 'Email' => $user->email,
    //                 'Rank' => $user->employee_rank,
    //                 'Phone' => $user->phone,
    //                 'Whatsapp Number' => $user->whatsapp_no,
    //                 'DOB' => $user->dob,
    //                 // 'Profile Image'=> asset('storage/' . $user->profile_image), // Full URL for profile image
    //                 // 'Verified Video'=> asset('storage/' . $user->verified_video), // Full URL for profile image

    //                 // 'Branch' => $branchName,
    //                 // 'Country' => $countryName,
    //                 'User Type' => $userType,
    //                 'Address Type' => $addressType, // Billing or Shipping
    //                 'Address' => $address->address,
    //                 'Landmark' => $address->landmark,
    //                 'City' => $address->city,
    //                 'Country' => $address->country,
    //                 'State' => $address->state,
    //                 'Zip Code' => $address->zip_code,
    //                 'Status' => $user->status ? 'Active' : 'Inactive', 
    //             ];
    //         });
    //     });

    //     // Return the collected data
    //     return $data;
    // }

    public function collection()
    {
        // Fetch users along with their addresses using eager loading
        $users = User::with(['userAddress' => function ($query) {
                $query->where('address_type', 1); // Only Billing Address
            }])
            ->where('user_type', 1) // Adjust based on the requirement, assuming 1 means customers
            ->get();
    
        $data = $users->map(function ($user) {
            $userType = $user->user_type == 0 ? 'Staff' : 'Customer';
        
            // If no address exists, use empty values
            if ($user->userAddress->isEmpty()) {
                return [[
                    'User Type' => $userType,
                    'Customer Name' => $user->name,
                    'Company Name' => $user->company_name,
                    'Rank' => $user->employee_rank,
                    'Email' => $user->email,
                    'Country Code Phone' => $user->country_code,
                    'Phone' => $user->phone,
                    'Country Code Alternet Phone One' => $user->country_code_alt_1,
                    'Alternet Phone One' => $user->alternative_phone_number_1,
                    'Country Code Alternet Phone Two' => $user->country_code_alt_2,
                    'Alternet Phone Two' => $user->alternative_phone_number_2,
                    'Country Code Whatsapp' => $user->country_code_whatsapp, // Added here

                    'Whatsapp Number' => $user->whatsapp_no,
                    'DOB' => $user->dob,
                    'Address Type' => 'N/A', // No address
                    'Address' => '',
                    'Landmark' => '',
                    'City' => '',
                    'Country' => '',
                    'State' => '',
                    'Zip Code' => '',
                ]];
            }
        
            // If user has an address, return mapped data
            return $user->userAddress->map(function ($address) use ($user, $userType) {
                return [
                    'User Type' => $userType,
                    'Customer Name' => $user->name,
                    'Company Name' => $user->company_name,
                    'Rank' => $user->employee_rank,
                    'Email' => $user->email,
                    'Country Code Phone' => $user->country_code,
                    'Phone' => $user->phone,
                    'Country Code Alternet Phone One' => $user->country_code_alt_1,
                    'Alternet Phone One' => $user->alternative_phone_number_1,
                    'Country Code Alternet Phone Two' => $user->country_code_alt_2,
                    'Alternet Phone Two' => $user->alternative_phone_number_2,
                    'Country Code Whatsapp' => $user->country_code_whatsapp, // Added here

                    'Whatsapp Number' => $user->whatsapp_no,
                    'DOB' => $user->dob,
                    'Address Type' => 'Billing Address',
                    'Address' => $address->address,
                    'Landmark' => $address->landmark,
                    'City' => $address->city,
                    'Country' => $address->country,
                    'State' => $address->state,
                    'Zip Code' => $address->zip_code,
                ];
            });
        })->flatten(1);
    
        // Return the collected data
        return $data;
    }
    

    public function headings(): array
    {
        return [
            'User Type',
            'Customer Name',
            'Company Name',
            'Rank',
            'Email',
            'Country Code Phone',
            'Phone',
            'Country Code Alternet Phone One',
            'Alternet Phone One',
            'Country Code Alternet Phone Two',
            'Alternet Phone Two',
            'Country Code Whatsapp', // Added here

            'Whatsapp Number',
            'DOB',
            'Address Type',
            'Address',
            'Landmark',
            'City',
            'Country',
            'State',
            'Zip Code',
        ];
    }
    
}

