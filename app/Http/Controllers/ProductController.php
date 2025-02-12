<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        // Get the current authenticated user ID
        $userId = Auth::id();

        // Validate the incoming request
        $validatedData = $request->validate([
            'productName' => [
                'required',
                'string',
                'max:255',
                // Custom validation rule to check unique product name for the same user
                function ($attribute, $value, $fail) use ($userId) {
                    if (Product::where('user_id', $userId)->where('name', $value)->exists()) {
                        $fail('The product name has already been taken for your account.');
                    }
                },
            ],
            'productId' => 'required|numeric|unique:products,code,NULL,id,user_id,' . $userId,
            'productCost' => 'required|numeric',
            'productCategory' => 'required|string|max:255',
        ], [
            'productName.required' => 'Product name is required.',
            'productId.required' => 'Product ID is required.',
            'productId.numeric' => 'Product ID must be a number.',
            'productId.numeric' => 'Product ID has already been taken for your account.',
            'productCost.required' => 'Product cost is required.',
            'productCost.numeric' => 'Product cost must be a number.',
            'productCategory.required' => 'Product category is required.',
        ]);

        // Create a new product instance
        $product = new Product();
        $product->user_id = $userId;
        $product->name = $validatedData['productName'];
        $product->code = $validatedData['productId'];
        $product->cost = $validatedData['productCost'];
        $product->category_id = $validatedData['productCategory'];

        // Save the product to the database
        $product->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Product created successfully!');
    }


    public function show($id)
    {
        $user = Auth::user()->id;
        $product = Product::with('category')
            ->where('user_id', $user)
            ->where('id', $id)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product]);
    }

    public function showSingleproduct($id)
    {
        $user = Auth::user()->id;
        $product = Product::with('category')
            ->where('user_id', $user)
            ->where('id', $id)
            ->firstOrFail();

        $categories = Category::where('user_id', $user)->get(); // Fetch all categories for the user

        return response()->json(['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user()->id;
        $product = Product::where('user_id', $user)
            ->where('id', $id)
            ->firstOrFail();

        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->code = $request->code;
        $product->cost = $request->cost;
        $product->save();

        return response()->json(['success' => 'Product updated successfully']);
    }

    public function destroy($id)
    {
        $user = Auth::user()->id;
        // Find the product by its ID
        $product = Product::where('user_id', $user)
            ->where('id', $id)
            ->first();

        // Check if the product exists
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        try {
            // Delete the product
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the product'], 500);
        }
    }

    // Function to fetch sales categories
    public function getSalesCategories(Request $request, $productId)
    {
        $user = Auth::user()->id;
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');

        // Initialize the base queries
        $discountSalesQuery = Bill::where('product_id', $productId)
            ->where('salesCategory', 'discount')
            ->where('user_id', $user);
        $retailSalesQuery = Bill::where('product_id', $productId)
            ->where('salesCategory', 'retail')
            ->where('user_id', $user);
        $wholesaleSalesQuery = Bill::where('product_id', $productId)
            ->where('salesCategory', 'wholesales')
            ->where('user_id', $user);

        // Apply date range filters if both fromDate and toDate are present
        if ($fromDate && $toDate) {
            $fromDate = Carbon::parse($fromDate)->startOfDay();
            $toDate = Carbon::parse($toDate)->endOfDay();
            $discountSalesQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $retailSalesQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $wholesaleSalesQuery->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($fromDate || $toDate) {
            // Handle incomplete date range
            return response()->json([
                'error' => 'Both fromDate and toDate are required for date filtering.'
            ], 400);
        }

        // Execute the queries
        $discountSales = $discountSalesQuery->get();
        $retailSales = $retailSalesQuery->get();
        $wholesaleSales = $wholesaleSalesQuery->get();

        return response()->json([
            'discountSales' => $discountSales,
            'retailSales' => $retailSales,
            'wholesaleSales' => $wholesaleSales
        ], 200);
    }
}
