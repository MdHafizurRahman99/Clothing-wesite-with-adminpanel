<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PriceRange;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductQuentity;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $totalPrice, $discountedPrice, $totalProduct;

    public function index()
    {
        // return 'hello';

        return view('frontend.shop.shop');
    }
    public function productDetails($product_id)
    {
        $quentity = ProductQuentity::where('product_id', $product_id)->select('size', 'color', 'quantity')->get();
        $quantityArray = [];


        // Loop through each item in the array
        if (isset($quentity)) {
            # code...
            foreach ($quentity as $item) {
                // Access size, color, and quantity from the current item
                $size = $item->size;
                $color = $item->color;
                $quantityValue = $item->quantity;
                // Store quantity in the array indexed by size and color
                $quantityArray[$size][$color] = $quantityValue;
            }
        }
        // return $quantityArray['XS']['Aquamarine'];

        // return PriceRange::where('product_id', $product_id)->select('min_quantity', 'max_quantity', 'price')->get();
        $priceRanges = PriceRange::where('product_id', $product_id)->select('min_quantity', 'max_quantity', 'price')->get();
        $minQuantityArray = [];
        $maxQuantityArray = [];
        $priceArray = [];
        if (isset($priceRanges)) {
            # code...
            foreach ($priceRanges as $item) {
                // Access size, color, and quantity from the current item
                $minQuantity = $item->min_quantity;
                $maxQuantity = $item->max_quantity;
                $price = $item->price;

                // Store data in separate arrays
                $minQuantityArray[] = $minQuantity;
                $maxQuantityArray[] = $maxQuantity;
                // Store quantity in the array indexed by min_quantity and max_quantity
                $priceArray[$item->min_quantity][$item->max_quantity] = $price;
            }
        }
        // return $product_id;
        return view(
            'frontend.shop.shop-details',
            [
                'product' => Product::where('id', $product_id)->first(),
                'quentity' => $quantityArray,
                'prices' => $priceArray,
                'minQuantity' => $minQuantityArray,
                'maxQuantity' => $maxQuantityArray,
                'galleryImages' => ProductImage::where('product_id', $product_id)->get(),
            ]
        );
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

        $productColorCounts = [];

        foreach ($allCartproduct as $productId => $product) {
            $colorCounts = [];
            foreach ($product['input'] as $key => $value) {
                // return  $value;
                if (!in_array($key, ['_token', 'product_id', 'total_price']) && strpos($key, '_') !== false) {
                    list($size, $color) = explode('_', $key);
                    // If the color is not null and not empty
                    if (!is_null($value) && $value !== '') {

                        // Increment the count for this color for this product
                        $colorCounts[$color] = isset($colorCounts[$color]) ? $colorCounts[$color] + $value : $value;
                    }
                }
            }
            $productColorCounts[$productId] = $colorCounts;
        }

        foreach ($productColorCounts as $key => $value) {
            $this->totalProduct = 0;
            $priceRanges = PriceRange::where('product_id', $key)->select('min_quantity', 'price')->get();
            $result = [];
            $higestPriceArray = [];
            foreach ($priceRanges as $index => $minQuantity) {
                $higestPriceArray[$minQuantity['min_quantity']] = $minQuantity['price'];
            }
            arsort($higestPriceArray, SORT_NUMERIC);
            $highestPrice = reset($higestPriceArray); // Get the first element after sorting
            // return $highestPrice;
            foreach ($priceRanges as $index => $minQuantity) {
                $result[$minQuantity['price']] = $minQuantity['min_quantity'];
            }

            arsort($result, SORT_NUMERIC);
            foreach ($value as $count) {
                foreach ($result as $price => $min_quantity) {
                    if (isset($count) && $count >= $min_quantity) {
                        $this->totalProduct += $count;
                        $this->discountedPrice += ($price * $count);
                        break;
                    }
                }
            }
            $this->totalPrice += ($this->totalProduct * $highestPrice);
            // return $this->discountedPrice;
            // return $value[$color];
            // return $value['Aquamarine'];
        }
        // return $this->totalProduct;
        // return $this->discountedPrice;
        // return $result;

        session()->put('totalPrice', $this->totalPrice);
        session()->put('discountedPrice', $this->discountedPrice);
        // return        session('totalPrice');
        return view('frontend.shop.cart', [
            'cartproducts' => $allCartproduct,
            'discountedPrice' => $this->discountedPrice,
            'totalPrice' => $this->totalPrice,
        ]);
    }
    public function customDesign()
    {
        return view('frontend.shop.design');
    }
    public function productCheckout()
    {
        $discountedPrice = session('discountedPrice');
        $totalPrice = session('totalPrice');
        // return $discountedPrice;
        return view(
            'frontend.shop.checkout',
            [
                'discountedPrice' => $discountedPrice,
                'totalPrice' => $totalPrice,
            ]
        );
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
    public function show(Category $shop)
    {
        // dd($shop);
        return view(
            'frontend.shop.shop',
            [
                'products' => Product::where('category_id', $shop->id)->get(),
            ]
        );
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
