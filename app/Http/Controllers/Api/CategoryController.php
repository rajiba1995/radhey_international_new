<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Category::where('status',1)->get();
        if($data){
            return response()->json([
                'status' => true,
                'message' => 'Category list fetched successfully!',
                'data' => $data,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'No data found!'
            ]);
        }
       
    }

    public function getCategoriesByCollection($collectionId)
    {
        try {
            // Fetch categories based on the collection_id
            $categories = Category::where('collection_id', $collectionId)->with('collection')
                ->where('status', 1) // Optional: Only active categories
                // ->select('id', 'short_code', 'title', 'image', 'status')
                ->get();

            if ($categories->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No categories found for the given collection ID.',
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Categories retrieved successfully.',
                'data' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching categories.',
                'error' => $e->getMessage(),
            ]);
        }
    }

}
