<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fabric;

class FabricController extends Controller
{
    public function index(Request $request)
    {
        $data = Fabric::where('collection_id',1)->with('collection')->get();
        if($data){
            return response()->json([
                'status' => true,
                'message' => 'Fabric list fetched successfully!',
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
