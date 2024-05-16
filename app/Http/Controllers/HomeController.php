<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->except('_token', 'total_price', 'product_id'); // Exclude CSRF token
        // return $data;
        $allValuesAreNull = empty(array_filter($data, function ($value) {
            return !is_null($value);
        }));
        if ($allValuesAreNull) {
            // return response()->json(['message' => 'All inputs are null'], 400);
        return back()->with('message','Please select any item.');
        }

        foreach ($data as $key => $quantity) {
            if ($key === 'total_price' && $key === 'product_id') {
                continue; // Skip total price field
            }
            $size = explode('_', $key)[0]; // Extract size from key (e.g., XS)
            $color = explode('_', $key)[1];
            // return $size;
            $inventory = Inventory::where('product_id', $request->product_id)
                ->where('color', $color) // Assuming color is still provided in the key
                ->where('size', $size)
                ->first();
            // return $inventory;
            if (!$inventory || $inventory->quantity < $quantity) {
                // return back()->withErrors(['error' => "Insufficient stock for '$size - $color'. Please try to order"]);
                return back()->with('data', $data)->withErrors(['error' => "We apologize, but there is currently limited stock available for '$size - $color'. Please adjust the quantity ."]);

                // Handle insufficient stock
            }

            // Extract size from key (optional, adjust based on your key format)
            $size = isset($color) ? explode('_', $key)[1] : null; // Extract size if color is present in the key

        }
        // return $request->product_id;
        // Set expiration time to one day (1440 minutes)
        // $cacheKey = session('cacheKey');
        // // $cachedData = cache()->get($cacheKey);
        // // return $cachedData;
        // return $cacheKey;
        // Initialize an empty array to hold product IDs
        $productIds = [];
        // Retrieve the existing product IDs array from the session
        if (session()->has('product_ids')) {
            $productIds = session('product_ids');

            // Convert $productIds to an array if it's not already one
            if (!is_array($productIds)) {
                $productIds = [$productIds];
            }
        }
        // Assuming $request->product_id is an array of product IDs
        if ($request->has('product_id')) {
            // Get the product IDs from the request
            $newProductIds = $request->product_id;
            // Convert $newProductIds to an array if it's not already one
            if (!is_array($newProductIds)) {
                $newProductIds = [$newProductIds];
            }
            // Merge the new product IDs with the existing ones and remove duplicates
            $productIds = array_unique(array_merge($productIds, $newProductIds));
        }
        // Store the updated product IDs array back in the session
        session(['product_ids' => $productIds]);
        // Retrieve and return the updated product IDs array from the session
        // return session('product_ids');
        $totalProduct = session('totalProduct');
        // return $totalProduct;
        $requestInputValues = $request->input();
        if (is_null($totalProduct)) {
            $totalProduct = 0;
            foreach ($requestInputValues as $key => $value) {
                if ($key === 'product_id') {
                    continue;
                }
                if (!is_null($value) && is_numeric($value)) {
                    $totalProduct += intval($value);
                }
            }
            session(['totalProduct' => $totalProduct], 1440);
        } else {
            foreach ($requestInputValues as $key => $value) {
                if ($key === 'product_id') {
                    continue;
                }
                if (!is_null($value) && is_numeric($value)) {
                    $totalProduct += intval($value);
                }
            }
            session(['totalProduct' => $totalProduct], 1440);
        }
        // session()->forget('totalProduct');
        // session()->forget('product_ids');
        $cacheKey = session('cacheKey');
        // session()->forget('cacheKey');
        if (is_null($cacheKey)) {
            $cacheKey = Str::uuid()->toString();
            session(['cacheKey' => $cacheKey], 1440);
        }
        // Cache::forget($cacheKey);
        $productCacheKey = $cacheKey . '_' . $request->product_id;
        $cachedData = cache()->get($productCacheKey);
        // return $cachedData;
        if (isset($cachedData)) {
            $cachedDataInputValues = $cachedData['input'];
            foreach ($requestInputValues as $key => $value) {
                if ($key === 'product_id') {
                    continue;
                }
                // Check if the key exists in the cached data array
                if (!is_null($value) && is_numeric($value)) {
                    $cachedDataInputValues[$key] += $value; // Add the request data value to the cached data value
                }
            }
            $postData = [
                'input' => $cachedDataInputValues,
                'files' => $request->files->all(),
                'cookies' => $request->cookies->all(),
                // Add more data as needed
            ];
            cache()->put($productCacheKey, $postData, now()->addMinutes(1440));
        } else {
            $postData = [
                'input' => $request->input(),
                'files' => $request->files->all(),
                'cookies' => $request->cookies->all(),
                // Add more data as needed
            ];
            // Store the data in the cache
            cache()->put($productCacheKey, $postData, now()->addMinutes(1440));
        }
        // Generate a unique cache key
        // return $cacheKey;
        // Retrieve cached data
        // $cachedData = cache()->get($productCacheKey);
        // return $cachedData;
        return redirect()->route('shop.product-cart')->with('message', 'Added to cart successFully');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
