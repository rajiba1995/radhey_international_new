<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesmanBilling;
use App\Models\Order;
use App\Models\User;

class Helper
{
    /**
     * Handle image upload and store in a new folder.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $folderName
     * @return string The file path of the uploaded image
     */
    public static function uploadImage($image, $folderName)
    {
        // Ensure the image is valid
        if (!$image->isValid()) {
            throw new \Exception("Invalid image file.");
        }

        $folderPath = 'uploads/' . DIRECTORY_SEPARATOR . $folderName;

        // Generate a unique filename
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        // Use Laravel's Storage facade for managing file uploads
       

        try {
            // Save the file to the desired location
            $image->storeAs($folderPath, $filename, 'public');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            throw new \Exception("Image could not be moved. Error: " . $e->getMessage());
        }
        // Return the relative path of the uploaded file
        return 'uploads/' . $folderName . '/' . $filename;
    }

    public static function generateInvoiceBill($salesManId)
    {
        // Fetch Salesman Details
        $salesman = User::find($salesManId);

        if (!$salesman) {
            return [
                'number' => 'XXX-000',
                'status' => 1,
                'bill_id' => null,
            ];
        }

        // Extract the first 3 characters of the salesman's name and convert to uppercase
        $prefix = strtoupper(substr($salesman->name, 0, 3));

        // Check for salesman billing record
        $salesmanBillBook = SalesmanBilling::where('salesman_id', $salesManId)
            ->whereColumn('total_count', '>', 'no_of_used')
            ->first();

        if ($salesmanBillBook) {
            $new_number = $salesmanBillBook->start_no + $salesmanBillBook->no_of_used;

            do {
                // Format the order number with prefix and zero-padding
                $formatted_number = $prefix . '-' . str_pad($new_number, 3, '0', STR_PAD_LEFT);

                // Check if the order number already exists
                $existing_order = Order::where('order_number', $formatted_number)->first();
                
                // If order number exists, increment it
                if ($existing_order) {
                    $new_number++;
                }

                // Continue loop while the new_number is within the allowed range
            } while ($existing_order && $new_number <= $salesmanBillBook->end_no);

            // If we exit the loop and new_number is still valid, proceed
            if ($new_number <= $salesmanBillBook->end_no) {
                return [
                    'number' => $formatted_number,
                    'status' => 1,
                    'bill_id' => $salesmanBillBook->id,
                ];
            }
        }

        return [
            'number' => '000',
            'status' => 1,
            'bill_id' => null,
        ];
    }


    public static function generateUniqueNumber($increment = 0) {
        return now()->format('YmdHis') . str_pad($increment, 3, '0', STR_PAD_LEFT);
    }
    

    public static function generateTransactionId(){
        return 'PAYMENT'.now()->format('YmdHis');
    }

    public static function GetCustomerDetails($term)
    {
        if (!empty($term)) {
            // dd($term);
           return User::where('user_type', 1)
                ->where('status', 1)
                ->where(function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%')
                        ->orWhere('phone', 'like', '%' . $term . '%')
                        ->orWhere('whatsapp_no', 'like', '%' . $term . '%')
                        ->orWhere('email', 'like', '%' . $term . '%');
                })
                ->take(20)
                ->get();
                $orders = Order::where('order_number', 'like', '%' . $term . '%')
                    ->orWhereHas('customer', function ($query) {
                        $query->where('name', 'like', '%' . $term . '%');
                    })
                    ->latest()
                    ->take(1)
                    ->get();

        } else {
            // Reset results when the search term is empty
            return [];
        }
    }
    public static function getCrDr($amount){
        if($amount > 0){
            return "Cr"; # if postive +
        } else if($amount < 0) {
            return "Dr"; # if negative -
        } else {
            return "";
        }
    }
    
    public static function replaceMinusSign($number){
        return str_replace("-","",$number);
    }

}
