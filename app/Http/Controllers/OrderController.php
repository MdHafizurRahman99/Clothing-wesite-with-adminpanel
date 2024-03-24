<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductBillingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OrderController extends Controller
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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
        ], [
            'required' => 'The :attribute field is required.',
        ]);

        $validator->setAttributeNames([
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'country' => 'Country',
            'city' => 'City',
            'state' => 'State',
            'zip_code' => 'Zip Code',
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $discountedPrice = session('discountedPrice');
        $subTotal = session('totalPrice');
        $order = Order::create([
            'customer_id' => auth()->user()->id,
            'order_date' => Carbon::now(),
            'total_price' => $request->total_price,
            'sub_total' => $subTotal,
        ]);

        $billingAddress = ProductBillingAddress::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
        ]);

        $cacheKey = session('cacheKey');
        $productIds = session('product_ids');
        $cartproducts = [];
        if (isset($productIds)) {
            # code...
            foreach ($productIds as $productId) {
                $productCacheKey = $cacheKey . '_' . $productId;
                // Retrieve cache data for the current product
                $cartProduct = cache()->get($productCacheKey);

                // Add cache data to the array
                $cartproducts[$productId] = $cartProduct;
            }
        }
        if (!empty($cartproducts) && isset($cartproducts)) {
            foreach ($cartproducts as $cartproduct) {
                if (!empty($cartproduct['input'])) {
                    $inputData = $cartproduct['input'];
                    $productData = [];

                    // Remove the first element from $inputData (assuming it's not needed)
                    array_shift($inputData);

                    foreach ($inputData as $key => $quantity) {
                        if ($quantity !== null && $quantity > 0) {
                            // Extract product_id from input data
                            if ($key === 'product_id') {
                                $product_id = $quantity;
                                continue;
                            }
                            // dd($quantity);

                            $size = substr($key, 0, strpos($key, '_')); // Extract size from key
                            $color = substr($key, strpos($key, '_') + 1); // Extract color from key
                            $product = Product::find($product_id);

                            // Build product data array
                            $orderDetails = OrderDetail::create([
                                'order_id' => $order->id,
                                'product_id' => $product->id,
                                'size' => $size,
                                'color' => $color,
                                'quantity' => $quantity,
                            ]);
                        }
                    }

                    // Add product data to the main array
                    if (!empty($productData)) {
                        $cartProductsData[] = $productData;
                    }
                }
            }
        }

        if (isset($productIds)) {
            # code...
            foreach ($productIds as $productId) {
                $productCacheKey = $cacheKey . '_' . $productId;
                // Retrieve cache data for the current product
                if (isset($productIds)) {
                    # code...
                    foreach ($productIds as $productId) {
                        $productCacheKey = $cacheKey . '_' . $productId;
                        $cartProduct = cache()->get($productCacheKey);
                    }
                }
                // Add cache data to the array
                $cartproducts[$productId] = $cartProduct;
            }
        }
        session()->forget('product_ids');

        return back()->with('message', 'Order Placed Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
