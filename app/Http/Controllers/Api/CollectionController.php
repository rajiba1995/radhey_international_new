<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $data = Collection::get();
        if($data){
            return response()->json([
                'status' => true,
                'message' => 'Collection list fetched successfully!',
                'data' => $data,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'No data found!'
            ]);
        }
       
    }
}
