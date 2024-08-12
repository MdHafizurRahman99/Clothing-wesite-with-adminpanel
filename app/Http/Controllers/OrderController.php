<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pattern;
use App\Models\Product;
use App\Models\ProductBillingAddress;
use App\Models\ShipToDifferentAddress;
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
        if (auth()->check()) {
            if (Auth()->user()->role == 'user') {

                return view('frontend.orders.list', [
                    'orders' => Order::where('customer_id', Auth()->user()->id)->latest()->get(),
                    // 'orders' => Order::where('customer_id', Auth()->user()->id)
                    //     ->orderBy('created_at', 'desc')
                    //     ->get(),
                ]);
            } elseif (Auth()->user()->role == 'admin') {

                return view('admin.orders.list', [
                    'orders' => Order::latest()->get(),
                ]);
            } else {
                return back();
            }
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            'email' => 'required|email',
            'mobile' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',

            'ship_to_first_name' => $request->ship_to_different_address == 1 ? 'required' : '',
            'ship_to_last_name' => $request->ship_to_different_address == 1 ? 'required' : '',
            'ship_to_email' => $request->ship_to_different_address == 1 ? 'required|email' : '',
            'ship_to_mobile_no' => $request->ship_to_different_address == 1 ? 'required' : '',
            'ship_to_address' => $request->ship_to_different_address == 1 ? 'required' : '',
            'ship_to_country' => $request->ship_to_different_address == 1 ? 'required' : '',
            'ship_to_city' => $request->ship_to_different_address == 1 ? 'required' : '',
            'ship_to_state' => $request->ship_to_different_address == 1 ? 'required' : '',
            'ship_to_zip_code' => $request->ship_to_different_address == 1 ? 'required' : '',
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
            'ship_to_first_name' => 'First Name',
            'ship_to_last_name' => 'Last Name',
            'ship_to_email' => 'Email',
            'ship_to_mobile_no' => 'Mobile',
            'ship_to_address' => 'Address',
            'ship_to_country' => 'Country',
            'ship_to_city' => 'City',
            'ship_to_state' => 'State',
            'ship_to_zip_code' => 'Zip Code',
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        session()->forget('order_info');

        $orderData = $request->except('_token', '_method');

        // Store order data in the session
        session()->push('order_info', $orderData);

        // Retrieve all order info from the session
        $data = session()->get('order_info');

        // return $data;

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
        // dd($cartproducts);

        if (!empty($cartproducts) && isset($cartproducts)) {
            foreach ($cartproducts as $cartproduct) {
                if (!empty($cartproduct['input'])) {
                    $inputData = $cartproduct['input'];
                    $productData = [];
                    // Remove the first element from $inputData
                    // array_shift($inputData);

                    foreach ($inputData as $key => $quantity) {
                        // dd($inputData);
                        if ($key === '_token') {
                            continue;
                        }
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

                                        $product->display_name .  "'. Please adjust the quantity."
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


        //stripe payment start here
        $stripe = new \Stripe\StripeClient(config("stripe.stripe_sk"));
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => 'Total'],
                        'unit_amount' => $request->total_price * 100, // Total amount in cents
                    ],
                    'quantity' => 1,
                ],
                // [
                //     'price_data' => [
                //         'currency' => 'usd',
                //         'product_data' => ['name' => 'T-shirt'],
                //         'unit_amount' => 2000,
                //         // 'tax_behavior' => 'exclusive',
                //     ],
                //     'adjustable_quantity' => [
                //         'enabled' => true,
                //         'minimum' => 1,
                //         // 'maximum' => 10,
                //     ],
                //     'quantity' => 1,
                // ],
                // [
                //     'price_data' => [
                //         'currency' => 'usd',
                //         'product_data' => ['name' => 'Pant'],
                //         'unit_amount' => 2000,
                //         // 'tax_behavior' => 'exclusive',
                //     ],
                //     'adjustable_quantity' => [
                //         'enabled' => true,
                //         'minimum' => 1,
                //         // 'maximum' => 10,
                //     ],
                //     'quantity' => 1,
                // ],
            ],
            // 'automatic_tax' => ['enabled' => true],
            'mode' => 'payment',

            // 'ui_mode' => 'embedded',
            // 'return_url' => 'https://example.com/return',

            // 'success_url' => route('stripe-success') . '?session_id={CHECKOUT_SESSION_ID}',
            // 'success_url' => route('stripe-success', ['total_price' => $request->total_price]) . '&session_id={CHECKOUT_SESSION_ID}',
            'success_url' => route('stripe-success'),
            'cancel_url' => route('stripe-cancel'),
        ]);
        // dd($response->id);

        if (isset($response->id) && $response->id != '') {
            session(['session_id' =>  $response->id]);

            return redirect($response->url);
            ///************************************** */
            // $discountedPrice = session('discountedPrice');
            // $subTotal = session('totalPrice');
            // $order = Order::create([
            //     'customer_id' => auth()->user()->id,
            //     'order_date' => Carbon::now(),
            //     'total_price' => $request->total_price,
            //     'sub_total' => $subTotal,
            //     'payment_status' => 'Done',
            // ]);

            // $billingAddress = ProductBillingAddress::create([
            //     'order_id' => $order->id,
            //     'first_name' => $request->first_name,
            //     'last_name' => $request->last_name,
            //     'company_name' => $request->company_name,
            //     'email' => $request->email,
            //     'mobile' => $request->mobile,
            //     'address' => $request->address,
            //     'country' => $request->country,
            //     'city' => $request->city,
            //     'state' => $request->state,
            //     'zip_code' => $request->zip_code,
            //     'ship_to_different_address' => $request->ship_to_different_address,
            // ]);
            // if ($request->ship_to_different_address == 1) {
            //     # code...
            //     $shipingAddress = ShipToDifferentAddress::create([
            //         'order_id' => $order->id,
            //         'first_name' => $request->ship_to_first_name,
            //         'last_name' => $request->ship_to_last_name,
            //         'company_name' => $request->ship_to_company_name,
            //         'email' => $request->ship_to_email,
            //         'mobile' => $request->shipto_to_mobile_no,
            //         'address' => $request->ship_to_address,
            //         'country' => $request->ship_to_country,
            //         'city' => $request->ship_to_city,
            //         'state' => $request->ship_to_state,
            //         'zip_code' => $request->ship_to_zip_code,
            //     ]);
            // }

            // $cacheKey = session('cacheKey');
            // $productIds = session('product_ids');
            // $cartproducts = [];
            // if (isset($productIds)) {
            //     # code...
            //     foreach ($productIds as $productId) {
            //         $productCacheKey = $cacheKey . '_' . $productId;
            //         // Retrieve cache data for the current product
            //         $cartProduct = cache()->get($productCacheKey);

            //         // Add cache data to the array
            //         $cartproducts[$productId] = $cartProduct;
            //     }
            // }
            // if (!empty($cartproducts) && isset($cartproducts)) {
            //     foreach ($cartproducts as $cartproduct) {
            //         if (!empty($cartproduct['input'])) {
            //             $inputData = $cartproduct['input'];
            //             $productData = [];

            //             // Remove the first element from $inputData (assuming it's not needed)
            //             array_shift($inputData);

            //             foreach ($inputData as $key => $quantity) {
            //                 if ($quantity !== null && $quantity > 0) {
            //                     // Extract product_id from input data
            //                     if ($key === 'product_id') {
            //                         $product_id = $quantity;
            //                         continue;
            //                     }
            //                     // dd($quantity);

            //                     $size = substr($key, 0, strpos($key, '_')); // Extract size from key
            //                     $color = substr($key, strpos($key, '_') + 1); // Extract color from key
            //                     $inventory = Inventory::where('product_id', $product_id)->where('size', $size)->where('color', $color)->first();
            //                     $updateQuantity = $inventory->quantity - $quantity;
            //                     // return $inventory->quantity;

            //                     // return $updateQuantity;
            //                     // $product = Product::find($product_id);
            //                     // return $product;
            //                     $orderDetails = OrderDetail::create([
            //                         'order_id' => $order->id,
            //                         'product_id' => $product_id,
            //                         'size' => $size,
            //                         'color' => $color,
            //                         'quantity' => $quantity,
            //                     ]);

            //                     $inventory->update([
            //                         'quantity' => $updateQuantity
            //                     ]);
            //                 }
            //             }

            //             // Add product data to the main array
            //             if (!empty($productData)) {
            //                 $cartProductsData[] = $productData;
            //             }
            //         }
            //     }
            // }

            // if (isset($productIds)) {
            //     # code...
            //     foreach ($productIds as $productId) {
            //         $productCacheKey = $cacheKey . '_' . $productId;
            //         // Retrieve cache data for the current product
            //         if (isset($productIds)) {
            //             # code...
            //             foreach ($productIds as $productId) {
            //                 $productCacheKey = $cacheKey . '_' . $productId;
            //                 $cartProduct = cache()->get($productCacheKey);
            //                 cache()->forget($productCacheKey);
            //             }
            //         }
            //         // Add cache data to the array
            //         $cartproducts[$productId] = $cartProduct;
            //     }
            // }

            // session()->forget('product_ids');
            // session()->forget('totalProduct');
            // session()->forget('totalPrice');
            // session()->forget('discountedPrice');
            //stripe success url
            // return redirect($response->url)->with('order_id', $order->id);
            // return redirect($response->url)->with('session_id', $response->id);

            # code...
        } else {
            return redirect()->route('stripe-cancel');
            # code...
        }

        // return $request;
        // return redirect()->route('home')->with('message', 'Order Placed Successfully!');
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
