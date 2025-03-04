<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use App\Models\UserAddress;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleUserAndAddressExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Fetch users along with their addresses using eager loading
        $users = User::with('userAddress') // Eager load the user addresses
            ->where('user_type', 1) // Adjust based on the requirement, assuming 1 means customers
            ->limit(2)
            ->get();

        $data = $users->flatMap(function ($user) {
         
            $userType = $user->user_type == 0 ? 'Staff' : 'Customer';

            // Check if user has addresses
            return $user->userAddress->map(function ($address) use ($user, $userType) {
                $addressType = $address->address_type == 1 ? 'Billing Address' : 'Shipping Address';

                return [
                    'User Name' => $user->name,
                    'Company Name' => $user->company_name,
                    'Email' => $user->email,
                    'Rank' => $user->employee_rank,
                    'Phone' => $user->phone,
                    'Whatsapp Number' => $user->whatsapp_no,
                    'DOB' => $user->dob,
                    // 'Profile Image'=> asset('storage/' . $user->profile_image), // Full URL for profile image
                    // 'Verified Video'=> asset('storage/' . $user->verified_video), // Full URL for profile image

                    // 'Branch' => $branchName,
                    // 'Country' => $countryName,
                    'User Type' => $userType,
                    'Address Type' => $addressType, // Billing or Shipping
                    'Address' => $address->address,
                    'Landmark' => $address->landmark,
                    'City' => $address->city,
                    'Country' => $address->country,
                    'State' => $address->state,
                    'Zip Code' => $address->zip_code,
                    'Status' => $user->status ? 'Active' : 'Inactive', 
                ];
            });
        });

        // Return the collected data
        return $data;
    }

    public function headings(): array
    {
        return [
            'User Name',
            'Company Name',
            'Email',
            'Rank',
            'Phone',
             'Whatsapp Number',
             'DOB',
            // 'Profile Image',
            //  'Verified Video',
            // 'Branch',
            // 'Country',
            'User Type',
            'Address Type',
            'Address',
            'Landmark',
            'City',
            'Country',
            'State',
            'Zip Code',
            'Status',
            
        ];
    }
}
