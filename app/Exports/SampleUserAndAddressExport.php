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
        $users = User::with(['userAddress' => function ($query) {
                    $query->where('address_type', 1); // Only Billing Address
                }])// Eager load the user addresses
            ->where('user_type', 1) 
            ->limit(2)
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
                        'Country Code' => $user->country_code,
                        'Phone' => $user->phone,
                        'Alternet Phone One' => $user->phone_one,
                        'Alternet Phone Two' => $user->phone_two,
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
                        'Country Code' => $user->country_code,
                        'Phone' => $user->phone,
                        'Alternet Phone One' => $user->phone_one,
                        'Alternet Phone Two' => $user->phone_two,
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
            'Country Code',
            'Phone',
            'Alternet Phone One',
            'Alternet Phone Two',
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
