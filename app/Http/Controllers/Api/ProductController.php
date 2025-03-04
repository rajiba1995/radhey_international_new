<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{


    public function getProductsByCategoryAndCollection(Request $request)
    {
        try {
            // Validate the query parameters
            $validated = $request->validate([
                'collection_id' => 'required|exists:collections,id',
                'category_id' => 'required|exists:categories,id',
            ], [
                'collection_id.required' => 'The collection ID is required.',
                'collection_id.exists' => 'The selected collection does not exist.',
                'category_id.required' => 'The category ID is required.',
                'category_id.exists' => 'The selected category does not exist.',
            ]);
    
            // Fetch products by category and collection
            $products = Product::where('collection_id', $validated['collection_id'])
                ->where('category_id', $validated['category_id'])
                ->get();
    
            // Check if products are found
            if ($products->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No products found for the given category and collection.',
                ]);
            }
    
            // Return the list of products
            return response()->json([
                'status' => true,
                'message' => 'Products retrieved successfully.',
                'data' => $products,
            ]);
        } catch (ValidationException $e) {
            // Handle validation exceptions with a custom error response
            return response()->json([
                'status' => false,
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ]);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching products.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getProductsByCollection(Request $request)
    {
        try {
            // Validate the query parameters
            $rules = [
                'collection_id' => 'required|exists:collections,id',
            ];
            
            $messages = [
                'collection_id.required' => 'The collection ID is required.',
                'collection_id.exists' => 'The selected collection does not exist.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ]);
            }
            // Fetch products by category and collection
            $products = Product::where('collection_id', $validated['collection_id'])
                ->get();
    
            // Check if products are found
            if ($products->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No products found for the given collection.',
                ]);
            }
    
            // Return the list of products
            return response()->json([
                'status' => true,
                'message' => 'Products retrieved successfully.',
                'data' => $products,
            ]);
        } catch (ValidationException $e) {
            // Handle validation exceptions with a custom error response
            return response()->json([
                'status' => false,
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ]);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching products.',
                'error' => $e->getMessage(),
            ]);
        }
    }
    

}
