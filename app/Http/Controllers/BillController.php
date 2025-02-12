<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{
    //to fetch all bill data to show total sales and details of a month and year
    public function getSalesData()
    {
        $userId = Auth::id(); // Get the authenticated user's ID

        // Get the current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Query to fetch the bill data for the current month and the authenticated user
        $bills = Bill::where('user_id', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();

        // Calculate the quantity sold and total amount of sales
        $quantitySold = $bills->sum('productQuantity');
        $totalAmount = 0;
        $totalProfit = 0;

        // Calculate total sales amount for each bill
        foreach ($bills as $bill) {
            $totalAmount += $bill->productQuantity * $bill->productMrp;
            $quantity = $bill->productQuantity;
            $cost = $bill->product?->cost ?? 0;
            $mrp = $bill->productMrp;
            $totalProfit += ($quantity * $mrp) - ($quantity * $cost);
        }

        // Prepare the response data
        $data = [
            'quantitySold' => $quantitySold,
            'totalSalesAmount' => $totalAmount,
            'totalProfit' => $totalProfit
        ];

        // Return the response as JSON
        return response()->json($data);
    }


    public function getAllSales(Request $request)
    {
        $userId = Auth::id(); // Get the authenticated user's ID

        // Initialize query with user_id condition
        $query = Bill::with('product')->where('user_id', $userId)->orderBy('created_at', 'desc');

        // Search query
        if ($request->has('query') && $request->query('query') !== '') {
            $search = $request->query('query');
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                    ->orWhere('billNo', 'LIKE', "%{$search}%")
                    ->orWhere('salesCategory', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Date filtering
        if ($request->has('fromDate') && $request->has('toDate')) {
            $fromDate = Carbon::parse($request->query('fromDate'))->startOfDay();
            $toDate = Carbon::parse($request->query('toDate'))->endOfDay();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($request->has('fromDate') || $request->has('toDate')) {
            // Handle incomplete date range
            return response()->json([
                'error' => 'Both fromDate and toDate are required for date filtering.'
            ], 400);
        }

        // Retrieve bills
        $bills = $query->get();

        // Calculate total quantity and amount
        $totalQuantity = $bills->sum('productQuantity');
        $totalAmount = $bills->sum(function ($bill) {
            return $bill->productQuantity * $bill->productMrp;
        });

        // Return JSON response
        return response()->json([
            'bills' => $bills,
            'totalQuantity' => $totalQuantity,
            'totalAmount' => $totalAmount
        ]);
    }

    // Get product name
    public function getProductName(Request $request)
    {
        $user = Auth::id();
        $product_id = $request->input('product_id');
        $product = Product::where('id', $product_id)->where('user_id', $user)->first();

        if ($product) {
            return response()->json(['product_id' => $product->code]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }


    public function store(Request $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'billNumber' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($userId) {
                    if (Bill::where('user_id', $userId)->where('billNo', $value)->exists()) {
                        $fail('This Bill Number already exists.');
                    }
                }
            ],
            'productName' => 'required|string|max:255',
            'productCat' => 'required|string|in:wholesales,retail,discount',
            'productMrp' => 'required|numeric',
            'productQuantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $bill = new Bill();
        $bill->user_id = $userId;
        $bill->billNo = $request->billNumber;
        $bill->phone = $request->customerPhone;
        $bill->product_id = $request->productName; // productName actually passes the product ID
        $bill->salesCategory = $request->productCat;
        $bill->productMrp = $request->productMrp;
        $bill->productQuantity = $request->productQuantity;
        $bill->save();

        return response()->json(['message' => 'Bill added successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function getBillDetails($id)
    {
        $userId = Auth::id(); // Get the authenticated user's ID

        // Fetch the bill only if it belongs to the authenticated user
        $bill = Bill::with('product')->where('user_id', $userId)->find($id);

        if (!$bill) {
            return response()->json(['error' => 'Bill not found'], 404);
        }

        return response()->json(['bill' => $bill]);
    }
}
