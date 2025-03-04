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
    public function collection()
    {
        // Fetch users along with their addresses using eager loading
        $users = User::with('userAddress') // Eager load the user addresses
            ->where('user_type', 1) // Adjust based on the requirement, assuming 1 means customers
            ->get();

        $data = $users->flatMap(function ($user) {
            // Get the branch name
            // $branch = Branch::find($user->branch_id);
            // $branchName = $branch ? $branch->name : 'N/A';

            // Get the country name
            // $country = Country::find($user->country_id);
            // $countryName = $country ? $country->title : 'N/A';

            // Get user type as 'Staff' or 'Customer'
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

