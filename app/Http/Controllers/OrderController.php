<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pattern;
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
        if (isset(Auth()->user()->id)) {
            return view('frontend.orders.list', [
                'orders' => Order::where('customer_id', Auth()->user()->id)->get(),
            ]);
            # code...
        } else {
            return back();
            # code...
        }
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
        // return $request;
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





        $cacheKey = session('cacheKey');
        $productIds = session('product_ids');
        $cartproducts = [];
        if (isset($productIds)) {
            foreach ($productIds as $productId) {
                $productCacheKey = $cacheKey . '_' . $productId;
                $cartProduct = cache()->get($productCacheKey);
                $cartproducts[$productId] = $cartProduct;
            }
        }
        if (!empty($cartproducts) && isset($cartproducts)) {
            foreach ($cartproducts as $cartproduct) {
                if (!empty($cartproduct['input'])) {
                    $inputData = $cartproduct['input'];
                    $productData = [];
                    // Remove the first element from $inputData
                    array_shift($inputData);

                    foreach ($inputData as $key => $quantity) {
                        if ($quantity !== null && $quantity > 0) {
                            if ($key === 'product_id') {
                                $product_id = $quantity;
                                continue;
                            }
                            $size = substr($key, 0, strpos($key, '_')); // Extract size from key
                            $color = substr($key, strpos($key, '_') + 1); // Extract color from key
                            $inventory = Inventory::where('product_id', $product_id)->where('size', $size)->where('color', $color)->first();
                            $product = Product::find($product_id);
                            $pattern = Pattern::where('id', $product->pattern_id)->first();
                            $category = Category::where('id', $product->category_id)->first();

                            $updateQuantity = $inventory->quantity - $quantity;

                            if ($updateQuantity < '0') {
                                # code...
                                return redirect()->route('shop.product-cart')->withErrors([
                                    'error' => "We apologize, but there is currently limited stock ({$inventory->quantity} pcs) available for '{$size}({$color})' of Product '" .
                                        (isset($pattern->name) ? $pattern->name : '') . ' ' .
                                        $product->name . ' ' .
                                        (isset($product->weight) ? $product->weight . 'Gsm' : '') . ' ' .
                                        (isset($category->category_name) ? $category->category_name : '') . "'. Please adjust the quantity."
                                ]);
                            }
                        }
                    }
                    if (!empty($productData)) {
                        $cartProductsData[] = $productData;
                    }
                }
            }
        }


        ///************************************** */
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
                            $inventory = Inventory::where('product_id', $product_id)->where('size', $size)->where('color', $color)->first();
                            $updateQuantity = $inventory->quantity - $quantity;
                            // return $inventory->quantity;

                            // return $updateQuantity;
                            // $product = Product::find($product_id);
                            // return $product;
                            $orderDetails = OrderDetail::create([
                                'order_id' => $order->id,
                                'product_id' => $product_id,
                                'size' => $size,
                                'color' => $color,
                                'quantity' => $quantity,
                            ]);

                            $inventory->update([
                                'quantity' => $updateQuantity
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
                        cache()->forget($productCacheKey);
                    }
                }
                // Add cache data to the array
                $cartproducts[$productId] = $cartProduct;
            }
        }
        session()->forget('product_ids');
        session()->forget('totalProduct');
        session()->forget('totalPrice');
        session()->forget('discountedPrice');
        return redirect()->route('home')->with('message', 'Order Placed Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('frontend.orders.order', [
            'order' => $order,
            'order_details' => OrderDetail::where('order_id', $order->id)->get()
        ]);
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
