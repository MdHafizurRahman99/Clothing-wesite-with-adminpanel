<?php

namespace App\Http\Controllers;

use App\Models\CustomDesign;
use App\Models\Payment;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\MockupDesign;
use App\Models\Order;
use App\Models\OrderDetail;

use App\Models\ProductBillingAddress;
use App\Models\ShipToDifferentAddress;
use Carbon\Carbon;

class StripeController extends Controller
{
    public function stripe()
    {

        $stripe = new \Stripe\StripeClient(config("stripe.stripe_sk"));
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => 'T-shirt'],
                        'unit_amount' => 2000,
                        // 'tax_behavior' => 'exclusive',
                    ],
                    // 'adjustable_quantity' => [
                    //     'enabled' => true,
                    //     'minimum' => 1,
                    //     'maximum' => 10,
                    // ],
                    'quantity' => 1,
                ],
            ],
            // 'automatic_tax' => ['enabled' => true],
            'mode' => 'payment',
            // 'ui_mode' => 'embedded',
            'return_url' => 'https://example.com/return',
        ]);
        dd($response);
    }

    public function success(Request $request)
    {
        $sessionId = session('session_id');
        // dd( $sessionId);

        // $order_id = $request->session()->get('order_id');
        $data = session()->get('order_info');
        // dd($data);
        if (isset($sessionId)) {

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($sessionId);
            // dd($response->payment_status);

            if ($response->payment_status == 'paid') {
                // dd($response->payment_status);
                $discountedPrice = session('discountedPrice');
                $subTotal = session('totalPrice');
                $order = Order::create([
                    'customer_id' => auth()->user()->id,
                    'order_date' => Carbon::now(),
                    'total_price' => $data[0]['total_price'],
                    'sub_total' => $subTotal,
                    'payment_status' => 'Done',
                ]);

                $billingAddress = ProductBillingAddress::create([
                    'order_id' => $order->id,
                    'first_name' => $data[0]['first_name'],
                    'last_name' => $data[0]['last_name'],
                    'company_name' => $data[0]['company_name'],
                    'email' => $data[0]['email'],
                    'mobile' => $data[0]['mobile'],
                    'address' => $data[0]['address'],
                    'country' => $data[0]['country'],
                    'city' => $data[0]['city'],
                    'state' => $data[0]['state'],
                    'zip_code' => $data[0]['zip_code'],
                    'ship_to_different_address' => isset($data[0]['ship_to_different_address']) ? $data[0]['ship_to_different_address'] : null,
                ]);
                if (isset($data[0]['ship_to_different_address']) && $data[0]['ship_to_different_address'] == 1) {
                    # code...
                    $shipingAddress = ShipToDifferentAddress::create([
                        'order_id' => $order->id,
                        'first_name' => $data[0]['ship_to_first_name'],
                        'last_name' => $data[0]['ship_to_last_name'],
                        'company_name' => $data[0]['ship_to_company_name'],
                        'email' => $data[0]['ship_to_email'],
                        'mobile' => $data[0]['ship_to_mobile_no'],
                        'address' => $data[0]['ship_to_address'],
                        'country' => $data[0]['ship_to_country'],
                        'city' => $data[0]['ship_to_city'],
                        'state' => $data[0]['ship_to_state'],
                        'zip_code' => $data[0]['ship_to_zip_code'],
                    ]);
                }

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
                        // return $cartproducts;
                        if (!empty($cartproduct['input'])) {
                            $inputData = $cartproduct['input'];
                            $productData = [];

                            // Remove the first element from $inputData (assuming it's not needed)
                            // array_shift($inputData);

                            foreach ($inputData as $key => $quantity) {
                                if ($quantity !== null && $quantity > 0) {
                                    //    return $inputData;
                                    // Extract product_id from input data
                                    if ($key === 'product_id') {
                                        $product_id = $quantity;
                                        continue;
                                    }
                                    if ($key === '_token') {
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

                                    // $customDesignAdditionalDatakey = 'customDesignAdditionalData_' . $product_id;
                                    // // $cachedData = cache()->forget($customDesignAdditionalDatakey);
                                    // $customDesignAdditionalData = cache()->get($customDesignAdditionalDatakey);
                                    // if ($customDesignAdditionalData != null) {
                                    //     // cache()->forget($customDesignAdditionalDatakey);
                                    //     $additionalData = CustomDesign::create([
                                    //         'product_id' => $customDesignAdditionalData->product_id,
                                    //         'design_details' => $customDesignAdditionalData->design_details,
                                    //         'neck_level' => $customDesignAdditionalData->neck_level,
                                    //         'neck_level_details' => $customDesignAdditionalData->neck_level_details,
                                    //         'swing_tag' => $customDesignAdditionalData->swing_tag,
                                    //         'swing_tag_details' => $customDesignAdditionalData->swing_tag_details,
                                    //     ]);
                                    // }
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


                // for custom design additional data
                if (isset($productIds)) {
                    foreach ($productIds as $productId) {
                        $customDesignAdditionalDatakey = 'customDesignAdditionalData_' . $productId;
                        $cachedData =cache()->get($customDesignAdditionalDatakey);
                        // return $productId;
                        // if ($cachedData !== null) {
                            // The key exists, and data is available in the cache
                            $designDetail = CustomDesign::create([
                                'order_id' => $order->id,
                                'product_id' => $productId,
                                'neck_level' => $cachedData['input']['neck_level'] ?? null,
                                'neck_level_details' => $cachedData['input']['neck_level_details'] ?? null,
                                'neck_level_design' => $cachedData['files']['neck_level_design'] ?? null,
                                'right_sleeve' => $cachedData['input']['right_sleeve'] ?? null,
                                'right_sleeve_details' => $cachedData['input']['right_sleeve_details'] ?? null,
                                'right_sleeve_design' => $cachedData['files']['right_sleeve_design'] ?? null,
                                'left_sleeve' => $cachedData['input']['left_sleeve'] ?? null,
                                'left_sleeve_details' => $cachedData['input']['left_sleeve_details'] ?? null,
                                'left_sleeve_design' => $cachedData['files']['left_sleeve_design'] ?? null,
                                'design_details' => $cachedData['input']['design_details'] ?? null,
                                'swing_tag' => $cachedData['input']['swing_tag'] ?? null,
                                'custom_color' => $cachedData['input']['custom_color'] ?? null,
                                'swing_tag_details' => $cachedData['input']['swing_tag_details'] ?? null,
                                'swing_tag_design' => $cachedData['files']['swing_tag_design'] ?? null,
                            ]);
                        // }

                        // for canvas mockup design
                        $sides = ['front', 'back', 'right', 'left', 'shoulder'];
                        foreach ($sides as $side) {
                            // Session Keys
                            $designSessionKey = 'design_' . $side . '_' . $productId;
                            $mockupSessionKey = 'mockup_' . $side . '_' . $productId;

                            // Retrieve Design Data
                            $designImages = session()->get($designSessionKey, []);

                            // Retrieve Mockup Data
                            $mockupData = session()->get($mockupSessionKey, []);

                            // Check if data exists for the side
                            if (!$designImages && !$mockupData) {
                                continue; // Skip if no data
                            }

                            // Extract Mockup Data
                            $mockupImageUrl = $mockupData['imageUrl'] ?? null;
                            $objects = $mockupData['objects'] ?? [];

                            // Store in Database
                            MockupDesign::updateOrCreate(
                                [
                                    'order_id' => $order->id,
                                    'product_id' => $productId,
                                    'side' => $side,
                                    'mockup_image_url' => $mockupImageUrl,
                                    'design_images' => json_encode($designImages),
                                    'objects' => json_encode($objects),
                                ]
                            );

                            // Clear Session Data for the Side
                            session()->forget($designSessionKey);
                            session()->forget($mockupSessionKey);
                        }


                    }
                }


                session()->forget('product_ids');
                session()->forget('totalProduct');
                session()->forget('totalPrice');
                session()->forget('discountedPrice');
                session()->forget('session_id');
                session()->forget('order_info');

                $payment = Payment::create([
                    'payment_id' => $response->id,
                    'order_id' => $order->id,
                    'amount' => $data[0]['total_price'],
                    'currency' => $response->currency,
                    'status' => $response->status,
                    'customer_email' => $response->customer_details->email,
                    'payment_method' => "Stripe",
                ]);
                return redirect()->route('home')->with('message', 'Order Placed Successfully!');
                // dd($payment );
            } else {
                // dd($response->payment_status);
                return redirect('/')->with('message', 'Payment was unsuccessful. Please try again.');
            }
        } else {
            return redirect('/')->with('message', 'Unfortunately, the payment could not be processed. Please try again.');
        }
    }

    public function cancel()
    {
        return redirect('/')->with('message', 'To place order you need to pay.');
    }
}
