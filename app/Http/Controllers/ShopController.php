<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return 'hello';

        return view('frontend.shop.shop');
    }
    public function productDetails()
    {
        return view('frontend.shop.shop-details');
    }
    public function productCart()
    {
        // $uplodedimage = cache()->get('tecture4');
        // return $uplodedimage;
        $cacheKey = session('cacheKey');

        $productIds = session('product_ids');
        $allCartproduct = [];
        if (isset($productIds)) {
            # code...
            foreach ($productIds as $productId) {
                $productCacheKey = $cacheKey . '_' . $productId;
                // Retrieve cache data for the current product
                $cartProduct = cache()->get($productCacheKey);

                // Add cache data to the array
                $allCartproduct[$productId] = $cartProduct;
            }
        }
        // return $allCartproduct;
        return view('frontend.shop.cart', [
            'cartproducts' => $allCartproduct,
        ]);
    }
    public function customDesign()
    {
        return view('frontend.shop.design');
    }
    public function productCheckout()
    {
        return view('frontend.shop.checkout');
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
