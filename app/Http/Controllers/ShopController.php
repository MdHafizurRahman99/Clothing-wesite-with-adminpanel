<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Pattern;
use App\Models\PriceRange;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductQuentity;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $totalPrice, $discountedPrice, $totalProduct;

    public function index()
    {
        return view('frontend.shop.shop');
    }

    public function productDetails($product_id)
    {
        $product_images = ProductImage::where('product_id', $product_id)->select('image_url', 'color')->get()->groupBy('color');
        $colorImages = [];
        foreach ($product_images as $color => $images) {
            $colorImages[$color] = $images->pluck('image_url')->toArray();
        }
        // return $colorImages;

        // $quentity = ProductQuentity::where('product_id', $product_id)->select('size', 'color', 'quantity')->get();
        $quentity = Inventory::where('product_id', $product_id)->select('size', 'color', 'quantity')->get();
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
        // return $quantityArray;

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
        $product = Product::where('id', $product_id)->first();
        // dd($product);
        // $product = Product::findOrFail($product_id);
        $colors = $product->colors;
        // $colors=Color::all();
        if ($product->product_for == 'Order Form Catalog') {
            return view(
                'frontend.order-form-catalog.product-details',
                [
                    'product' => $product,
                    'quentity' => $quantityArray,
                    // 'colorRows' => $colorRows,
                    'prices' => $priceArray,
                    'colorImages' => $colorImages,
                    'colors' => $colors,
                    'minQuantity' => $minQuantityArray,
                    'maxQuantity' => $maxQuantityArray,
                    'galleryImages' => ProductImage::where('product_id', $product_id)->get(),
                ]
            );
        } else {
            return view(
                'frontend.shop.shop-details',
                [

                    'product' => $product,
                    'quentity' => $quantityArray,
                    // 'colorRows' => $colorRows,
                    'prices' => $priceArray,
                    'colorImages' => $colorImages,
                    'minQuantity' => $minQuantityArray,
                    'maxQuantity' => $maxQuantityArray,
                    'galleryImages' => ProductImage::where('product_id', $product_id)->get(),
                ]
            );
        }

        return view(
            'frontend.shop.shop-details',
            [

                'product' => $product,
                'quentity' => $quantityArray,
                // 'colorRows' => $colorRows,
                'prices' => $priceArray,
                'colorImages' => $colorImages,
                'minQuantity' => $minQuantityArray,
                'maxQuantity' => $maxQuantityArray,
                'galleryImages' => ProductImage::where('product_id', $product_id)->get(),
            ]
        );
    }

    public function productCart()
    {


        $cartproductscount = 0;
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
        $productColorCounts = [];

        foreach ($allCartproduct as $productId => $product) {
            $colorCounts = [];
            // return $allCartproduct;
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
        // return $productColorCounts;


        foreach ($productColorCounts as $key => $value) {
            // return $key;
            // return $value;
            $this->totalProduct = 0;
            $priceRanges = PriceRange::where('product_id', $key)->select('min_quantity', 'price')->get();
            // return $priceRanges;
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
                // return $value;
                foreach ($result as $price => $min_quantity) {
                    if (isset($count) && $count >= $min_quantity) {
                        $this->totalProduct += $count;
                        $this->discountedPrice += ($price * $count);
                        break;
                    }
                }
            }

            $cartproductscount += $this->totalProduct;
            $this->totalPrice += ($this->totalProduct * $highestPrice);

            // return $this->discountedPrice;
            // return $value[$color];
            // return $value['Aquamarine'];

        }

        // return $this->totalProduct;
        // return $this->discountedPrice;
        // return $this->totalPrice;

        session()->put('totalPrice', $this->totalPrice);
        session()->put('discountedPrice', $this->discountedPrice);
        session()->put('totalProduct', $cartproductscount);

        // return session('totalPrice');

        return view('frontend.shop.cart', [
            'cartproducts' => $allCartproduct,
            'discountedPrice' => $this->discountedPrice,
            'totalPrice' => $this->totalPrice,
        ]);
    }

    public function customDesign(Request $request)
    {
        // return $request;
        $imageCount = session('imageCount');

        //  if ($imageCount !== null) {
        //     $sessionKey = 'texture' . $imageCount . '_' . $request->product_id;
        //     $textureData = session()->get($sessionKey);
        //     if ($textureData && file_exists($textureData)) {
        //         unlink($textureData);
        //     }
        // }
        session(['imageCount' => 0], 1440);
        $product_id = $request->product_id ?? session('custom_design_product_id');

        // return $product_id;
        if (isNull($product_id)) {
            $product = Product::find($product_id);
            $category = Category::find($product->category_id);
            // $colors = Color::all();
            $colors = $product->colors;

            // dd($category);

            // dd($product_id);
            return view('frontend.shop.design', [
                'product' => $product,
                'category' => $category,
                'colors' => $colors,
            ]);
        } else {
            return redirect('/');
        }
    }
    // public function customOrder()
    // {
    //     // return session()->get('mockup_1', []);
    //     return view('frontend.shop.custom-order');
    // }
    public function productCheckout()
    {
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

                                        $product->display_name . "'. Please adjust the quantity."
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

        $product_for = request()->query('product_for');
        // dd($shop);
        $products = Product::where('category_id', $shop->id)->where('product_for', $product_for)->get();
        // return $products;
        return view(
            'frontend.shop.shop',
            [
                'products' => $products,
            ]
        );

        //this code for next use
        // if ($product_for == 'Buy Blank') {
        //     # code...
        //     return view('frontend.merchandise.gender', [
        //         'category_id' => $shop->id,
        //         'products' => $products,
        //     ]);
        // } else {
        //     return view('frontend.catalog-order.gender', [
        //         'category_id' => $shop->id,
        //         'products' => $products,
        //     ]);
        // }
    }
    public function products($category_id, $gender)
    {
        // return $gender;
        // dd($shop);
        $product_for = request()->query('product_for');
        return view(
            'frontend.shop.shop',
            [
                'products' => Product::where('category_id', $category_id)->where('product_for', $product_for)->where('gender', $gender)->get(),
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
