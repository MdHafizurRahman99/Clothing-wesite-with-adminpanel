<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Pattern;
use App\Models\PriceRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductQuentity;
use App\Models\ProductSize;
use App\Models\ProductSizeDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class ProductController extends Controller
{
    public $image, $imageName, $directory, $imgUrl;


    public function index()
    {
        return view(
            'admin.product.list',
            [
                'products' =>  Product::orderBy('created_at', 'desc')->get(),
                // 'products' => Product::all(),
            ]
        );
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $images = session()->get('product_image');
        // return $images;
        return view('admin.product.create', [
            'categories' => Category::all(),
            'patterns' => Pattern::all(),
            'colors' => Color::all(),
            'sizetype1' => ProductSize::where('type', '1')->get(),
            'sizetype2' => ProductSize::where('type', '2')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        //$selectedColors = $request->input('colors', []);
        // return $selectedColors;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'weight' => 'required',
            '1st-Range' => ['required', function ($attribute, $value, $fail) use ($request) {
                $suffixes = ['1st', '2nd', '3rd', '4th', '5th'];
                $highestPrice = 0;

                for ($i = 0; $i < count($suffixes); $i++) {
                    $suffix = $suffixes[$i];
                    $range = $request->input("$suffix-Range");

                    if ($range != null) {

                        $rangeArray = explode('-', $range);
                        $minimum = intval($rangeArray[0]);
                        $maximum = isset($rangeArray[1]) ? intval($rangeArray[1]) : $minimum;

                        // Check for range overlap or crossover
                        if ($i < count($suffixes) - 1) {
                            $nextSuffix = $suffixes[$i + 1];
                            $nextRange = $request->input("$nextSuffix-Range");
                            $nextRangeArray = explode('-', $nextRange);
                            $nextMinimum = intval($nextRangeArray[0]);
                            $nextMaximum = isset($nextRangeArray[1]) ? intval($nextRangeArray[1]) : $nextMinimum;

                            if (($maximum >= $nextMinimum || $maximum >= $nextMaximum) && $nextRange != null) {
                                // dd($nextRange);
                                // Ranges overlap or cross over, handle validation failure
                                // For example, you could throw an exception or return a validation error message
                                // Here, I'm throwing an exception
                                // throw new \Exception("Ranges overlap or cross over: $range and $nextRange");
                                $fail("Ranges overlap or cross over: $range and $nextRange");
                            }
                        }
                    }
                }
            },],
        ], [
            'required' => 'The :attribute field is required.',
        ]);



        $validator->setAttributeNames([
            'name' => 'Product Name',
            'category_id' => 'Category',
            'weight' => 'Weight',
        ]);

        if ($validator->fails()) {
            $images = session()->get('product_image');
            if (!is_null($images) && is_array($images)) {
                foreach ($images as $image) {
                    unlink($image);
                }
            }
            session()->forget('product_image');
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // return $request;
        $category = Category::find($request->category_id);

        $categoryName = $category->category_name;
        $productName = $request->name;
        $weight =  $request->weight;

        // Function to extract first letters of words in a string
        function extractFirstLetters($string)
        {
            $words = explode(' ', $string);
            $firstLetters = array_map(function ($word) {
                return strtoupper(substr($word, 0, 1));
            }, $words);

            return implode('', $firstLetters);
        }

        // Generate the key
        $key = 'MPC-' . extractFirstLetters($categoryName) . extractFirstLetters($productName) . $weight . rand();

        // Output the key
        // return $key;
        $pattern = Pattern::where('id', $request->pattern_id)->first();
        $category = Category::where('id', $request->category_id)->first();

        $patternName = isset($pattern->name) ? $pattern->name : '';
        $productName = $request->name;
        $gender = $request->gender;
        $productWeight = isset($request->weight) ? $request->weight . 'Gsm' : '';
        $categoryName = isset($category->category_name) ? $category->category_name : '';

        $displayName = trim("$gender $patternName $productName $productWeight $categoryName");

        // $image = $this->saveImage($request);
        $image = $this->saveImage($request->image);
        $design_image_front_side = $this->saveDesignImage($request->design_image_front_side);
        $design_image_back_side = $this->saveDesignImage($request->design_image_back_side);
        $design_image_right_side = $this->saveDesignImage($request->design_image_right_side);
        $design_image_left_side = $this->saveDesignImage($request->design_image_left_side);
        $product = Product::create([
            'id' => $key,
            'name' => $request->name,
            'display_name' => $displayName,
            'customcolor' => $request->customcolor,
            'product_for' => $request->product_for,
            'pattern_id' => $request->pattern_id,
            'size' => $request->size,
            'productsizetype' => $request->productsizetype,
            'weight' => $request->weight,
            'gender' => $request->gender,
            'category_id' => $request->category_id,
            'image' => $image,
            'design_image_front_side' => $design_image_front_side,
            'design_image_back_side' => $design_image_back_side,
            'design_image_left_side' => $design_image_left_side,
            'design_image_right_side' => $design_image_right_side,
            'description' => $request->description,
        ]);

        if ($request->customcolor == 'Yes') {
            $product->update(
                [
                    'minimum_order' => $request->minimum_order,
                    'minimum_time_required' => $request->minimum_time_required,
                ]
            );
        }

        $sizes = $request->input('sizes', []);

        foreach ($sizes as $size => $sizeData) {
            // @dd($sizeData);
            if (isset($sizeData['selected'])) {
                ProductSizeDetail::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'size' => $size,
                    ],
                    [
                        'height' => $sizeData['height'],
                        'weight' => $sizeData['weight'],
                    ]
                );
            }
        }

        $selectedColors = $request->input('colors', []);

        // Attach or sync the colors with the product
        $product->colors()->sync($selectedColors);


        $images = session()->get('product_image');
        if (isset($images)) {
            foreach ($images as $imageUrl) {
                $saveImage = ProductImage::create([
                    'product_id' => $product->id,
                    'type' => 'gallery',
                    'image_url' => $imageUrl,
                ]);
            }
            session()->forget('product_image');
        }
        // return $saveImage;
        foreach ($request->all() as $key => $value) {
            // return $key;
            // Check if the key starts with "XS_", "S_", "M_", "L_", or "XL_"
            if (preg_match('/^(XS|S|M|L|XL)_(.+)$/', $key, $matches)) {
                // Extract size and color
                $size = $matches[1];
                $color = $matches[2];
                $productQuuentity = ProductQuentity::Create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'color' => $color,
                    'quantity' => $value,
                ]);
            }
        }

        $suffixes = ['1st', '2nd', '3rd', '4th', '5th'];
        $higestPrice = 0;

        foreach ($suffixes as $suffix) {
            $range = $request->input("$suffix-Range");
            // $rangeArray = explode('-', $range);
            if ($range) {

                if (substr($range, -1) === '+') {
                    // Extract the minimum value (remove the "+" sign)
                    $minimum = intval(substr($range, 0, -1));
                    // Set the maximum value to null or any other appropriate value
                    $maximum = null;
                } else {
                    // Split the range string into an array
                    $rangeArray = explode('-', $range);
                    // Extract the minimum value
                    $minimum = $rangeArray[0];
                    // Check if the range has at least two elements
                    if (isset($rangeArray[1])) {
                        // Extract the maximum value
                        $maximum = $rangeArray[1];
                    } else {
                        // Set the maximum value to the same as minimum
                        $maximum = $minimum;
                        // $maximum = null;
                    }
                }

                $temp = $higestPrice;
                $higestPrice = $request->input("$suffix-Range_price");

                if ($higestPrice < $temp) {
                    $higestPrice = $temp;
                }

                $productPriceRange = PriceRange::create([
                    'product_id' => $product->id,
                    'min_quantity' => $minimum,
                    'max_quantity' => $maximum,
                    'price' => $request->input("$suffix-Range_price"),
                ]);
            }
        }

        $product->update(
            [
                'price' => $higestPrice,
            ]
        );
        // return $suffix;
        // return $productPriceRange;

        return back()->with('message', 'Product Added Successfully!');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    public function getProductDetails(Request $request)
    {
        $product_id = $request->get('product_id');
        $productQuentity = Inventory::where('product_id', $product_id)
            ->whereNotNull('quantity')
            ->get();
        // return $productQuentity;

        $sizes = $productQuentity->pluck('size')->unique()->toArray();
        $colors = $productQuentity->pluck('color')->unique()->toArray();

        return response()->json([
            'sizes' => $sizes,
            'colors' => $colors,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Product $product)
    {
        $quentity = ProductQuentity::where('product_id', $product->id)->select('size', 'color', 'quantity')->get();
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

        // return PriceRange::where('product_id', $product->id)->select('min_quantity', 'max_quantity', 'price')->get();
        $priceRanges = PriceRange::where('product_id', $product->id)->select('min_quantity', 'max_quantity', 'price')->get();
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
        // return $minQuantityArray;
        return view('admin.product.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'patterns' => Pattern::all(),
            'quentity' => $quantityArray,
            'prices' => $priceArray,
            'minQuantity' => $minQuantityArray,
            'maxQuantity' => $maxQuantityArray,
            'colors' => Color::all(),
            'sizetype1' => ProductSize::where('type', '1')->get(),
            'sizetype2' => ProductSize::where('type', '2')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
        ], [
            'required' => 'The :attribute field is required.',
        ]);

        $validator->setAttributeNames([
            'name' => 'Product Name',
            'category_id' => 'Category',

        ]);

        if ($validator->fails()) {
            $images = session()->get('product_image');
            if (!is_null($images) && is_array($images)) {
                foreach ($images as $image) {
                    unlink($image);
                }
            }
            session()->forget('product_image');
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $pattern = Pattern::where('id', $product->pattern_id)->first();
        $category = Category::where('id', $product->category_id)->first();

        $patternName = isset($pattern->name) ? $pattern->name : '';
        $productName = $request->name;
        $gender = $request->gender;

        $productWeight = isset($request->weight) ? $product->weight . 'Gsm' : '';
        $categoryName = isset($category->category_name) ? $category->category_name : '';
        $displayName = trim("$gender $patternName $productName $productWeight $categoryName");

        // return $displayName;
        $product->update([
            'name' => $request->name,
            'display_name' => $displayName,
            'size' => $request->size,
            'customcolor' => $request->customcolor,
            'minimum_order' => $request->minimum_order,
            'minimum_time_required' => $request->minimum_time_required,
            'product_for' => $request->product_for,
            'weight' => $request->weight,
            'gender' => $request->gender,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'pattern_id' => $request->pattern_id,
            'productsizetype' => $request->productsizetype,
        ]);

        $sizes = $request->input('sizes', []);

        foreach ($sizes as $size => $sizeData) {
            if (isset($sizeData['selected'])) {
                ProductSizeDetail::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'size' => $size,
                    ],
                    [
                        'height' => $sizeData['height'],
                        'weight' => $sizeData['weight'],
                    ]
                );
            } else {
                // If a size is unchecked, remove it from the database
                ProductSizeDetail::where('product_id', $product->id)
                    ->where('size', $size)
                    ->delete();
            }
        }
        // Get the selected colors from the form
        $selectedColors = $request->input('colors', []);

        // Sync the selected colors with the product
        $product->colors()->sync($selectedColors);

        if (isset($request->image)) {
            if (isset($product->image)) {
                unlink($product->image);
            }

            $image = $this->saveImage($request->image);
            $product->update([
                'image' => $image,
            ]);
        }

        if (isset($request->design_image_front_side)) {
            if (isset($product->design_image_front_side)) {
                unlink($product->design_image_front_side);
            }

            $design_image_front_side = $this->saveImage($request->design_image_front_side);
            $product->update([
                'design_image_front_side' => $design_image_front_side,
            ]);
        }

        if (isset($request->design_image_back_side)) {
            if (isset($product->design_image_back_side)) {
                unlink($product->design_image_back_side);
            }

            $design_image_back_side = $this->saveImage($request->design_image_back_side);
            $product->update([
                'design_image_back_side' => $design_image_back_side,
            ]);
        }

        if (isset($request->design_image_left_side)) {
            if (isset($product->design_image_left_side)) {
                unlink($product->design_image_left_side);
            }

            $design_image_left_side = $this->saveImage($request->design_image_left_side);
            $product->update([
                'design_image_left_side' => $design_image_left_side,
            ]);
        }
        if (isset($request->design_image_right_side)) {
            if (isset($product->design_image_right_side)) {
                unlink($product->design_image_right_side);
            }

            $design_image_right_side = $this->saveImage($request->design_image_right_side);
            $product->update([
                'design_image_right_side' => $design_image_right_side,
            ]);
        }

        $productImages = ProductImage::where('product_id', $product->id)->get();

        $images = session()->get('product_image');

        if (!is_null($images) && is_array($images)) {

            foreach ($productImages as $productImage) {
                unlink($productImage);
            }

            $productImages = ProductImage::where('product_id', $product->id)->delete();
            foreach ($images as $imageUrl) {
                $saveImage = ProductImage::create([
                    'product_id' => $product->id,
                    'type' => 'gallery',
                    'image_url' => $imageUrl,
                ]);
            }
        }
        session()->forget('product_image');
        // return $saveImage;
        $productQuentity = ProductQuentity::where('product_id', $product->id)->delete();
        foreach ($request->all() as $key => $value) {
            // return $key;
            // Check if the key starts with "XS_", "S_", "M_", "L_", or "XL_"
            if (preg_match('/^(XS|S|M|L|XL)_(.+)$/', $key, $matches)) {
                // Extract size and color
                $size = $matches[1];
                $color = $matches[2];
                $productQuuentity = ProductQuentity::Create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'color' => $color,
                    'quantity' => $value,
                ]);
            }
        }
        $suffixes = ['1st', '2nd', '3rd', '4th', '5th'];
        $higestPrice = 0;
        $productRanges = PriceRange::where('product_id', $product->id)->delete();
        foreach ($suffixes as $suffix) {
            $range = $request->input("$suffix-Range");
            // $rangeArray = explode('-', $range);
            if ($range) {
                if (substr($range, -1) === '+') {
                    // Extract the minimum value (remove the "+" sign)
                    $minimum = intval(substr($range, 0, -1));
                    // Set the maximum value to null or any other appropriate value
                    $maximum = $minimum;
                } else {
                    // Split the range string into an array
                    $rangeArray = explode('-', $range);
                    // Extract the minimum value
                    $minimum = $rangeArray[0];
                    // Check if the range has at least two elements
                    if (isset($rangeArray[1])) {
                        // Extract the maximum value
                        $maximum = $rangeArray[1];
                    } else {
                        // Set the maximum value to the same as minimum
                        $maximum = $minimum;
                    }
                }
                $temp = $higestPrice;
                $higestPrice = $request->input("$suffix-Range_price");
                if ($higestPrice < $temp) {
                    $higestPrice = $temp;
                }

                $productPriceRange = PriceRange::create([
                    'product_id' => $product->id,
                    'min_quantity' => $minimum,
                    'max_quantity' => $maximum,
                    'price' => $request->input("$suffix-Range_price"),
                ]);
            }
        }
        $product->update(
            [
                'price' => $higestPrice,
            ]
        );
        // return $higestPrice;
        // return $suffix;
        // return $productPriceRange;
        return redirect()->route('product.index')->with('message', 'Product Updated Successfully!');

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $productImages = ProductImage::where('product_id', $product->id)->get();
        foreach ($productImages as $productImage) {
            // dd($productImage);
            unlink($productImage->image_url);
        }
        $productQuentity = ProductQuentity::where('product_id', $product->id)->delete();
        $productRanges = PriceRange::where('product_id', $product->id)->delete();
        if (isset($product->image)) {
            unlink($product->image);
        }
        $product = $product->delete();
        return redirect()->route('product.index')->with('message', 'Product Deleted Successfully!');
        //
    }
    public function dropzoneImage(Request $request)
    {

        $images = $request->file('file');
        // return $images;

        foreach ($images as $image) {
            // dd($image->getClientOriginalName());
            $extention = $image->getClientOriginalExtension();
            // for ($i = 0; $i < count($imageSettings); $i++) {
            // dd($imageSettings);
            // if ($imageSetting) {
            // $width = $imageSetting->width;
            // $height = $imageSetting->height;
            // $extension = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            // return $extension;
            $imageName = rand() . '.' . $extention;
            $directory = 'assets/frontend/product/gallery-images/';
            $imageUrl = $directory . $imageName;

            // $images = ()->get('product_image');

            session()->push('product_image', $imageUrl);
            // $img->save($directory . $imageName);
            $image->move($directory, $imageName);
            // }

        }
        return $imageUrl;
    }

    public function incrementQuantity(Request $request)
    {

        //  return $request;
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
        if ($request->has('productId')) {
            // Get the product IDs from the request
            $newProductIds = $request->productId;
            // Convert $newProductIds to an array if it's not already one
            if (!is_array($newProductIds)) {
                $newProductIds = [$newProductIds];
            }
            // Merge the new product IDs with the existing ones and remove duplicates
            $productIds = array_unique(array_merge($productIds, $newProductIds));
        }
        // Store the updated product IDs array back in the session
        session(['product_ids' => $productIds]);

        $input = ['product_id' => $request->productId, $request->newkey => $request->quantity];

        $cacheKey = session('cacheKey');
        // return $input;
        $productId = $request->productId;
        // dd($productId);
        $productCacheKey = $cacheKey . '_' . $productId;
        // Retrieve cache data for the current product
        $cartProduct = cache()->get($productCacheKey);
        // return $cartProduct;


        // return $cachedDataInputValues;

        // $postData = [
        //     'input' => $cachedDataInputValues,
        //     'files' => $request->files->all(),
        //     'cookies' => $request->cookies->all(),
        //     // Add more data as needed
        // ];

        // cache()->put($productCacheKey, $postData, now()->addMinutes(1440));
        $totalProduct = session('totalProduct');
        // return $totalProduct;
        // $requestInputValues = $request->input();
        if ($totalProduct >= 0) {
            $totalProduct++;
            session(['totalProduct' => $totalProduct], 1440);
        }
        if (isset($cartProduct)) {
            $cachedDataInputValues = $cartProduct['input'];
            if (isset($cachedDataInputValues[$request->key]) && $request->key != $request->newkey) {

                $cachedDataInputValues[$request->newkey] = $request->quantity;
                unset($cachedDataInputValues[$request->key]);
            } else if ($request->key) {
                $cachedDataInputValues[$request->key] = $request->quantity;
            } else {
                $cachedDataInputValues[$request->newkey] = $request->quantity;
            }
            //  return $request;


            $postData = [
                'input' => $cachedDataInputValues,
            ];

            cache()->put($productCacheKey, $postData, now()->addMinutes(1440));
        } else {
            $postData = [
                'input' => $input,
                // 'files' => $request->files->all(),
                // 'cookies' => $request->cookies->all(),
                // Add more data as needed
            ];
            // Store the data in the cache
            cache()->put($productCacheKey, $postData, now()->addMinutes(1440));
        }
        return $totalProduct;
    }

    public function decrementQuantity(Request $request)
    {



        $cacheKey = session('cacheKey');
        // return $request;
        $productId = $request->productId;
        // dd($productId);
        $productCacheKey = $cacheKey . '_' . $productId;
        // Retrieve cache data for the current product
        $cartProduct = cache()->get($productCacheKey);
        $cachedDataInputValues = $cartProduct['input'];
        // return $cachedDataInputValues;
        if (isset($cachedDataInputValues[$request->key]) && $request->key != $request->newkey) {
            unset($cachedDataInputValues[$request->key]);
            $cachedDataInputValues[$request->newkey] = $request->quantity;
        } else {
            $cachedDataInputValues[$request->key] = $request->quantity;
        }
        $postData = [
            'input' => $cachedDataInputValues,
            'files' => $request->files->all(),
            'cookies' => $request->cookies->all(),
            // Add more data as needed
        ];
        cache()->put($productCacheKey, $postData, now()->addMinutes(1440));
        $totalProduct = session('totalProduct');
        if ($totalProduct > 0) {
            $totalProduct--;
            session(['totalProduct' => $totalProduct], 1440);
        }
        return $totalProduct;
    }


    public function searchProducts(Request $request)
    {
        $term = $request->get('term');
        $products = Product::where('display_name', 'LIKE', '%' . $term . '%')->get();

        $results = [];
        foreach ($products as $product) {
            $results[] = [
                'id' => $product->id,
                'label' => $product->display_name,
                'value' => $product->display_name,
                'price' => $product->price,
            ];
        }

        return response()->json($results);
    }

    public function saveCanvasMockup(Request $request)
    {
        // dd($imageUrls);
        $request->validate([
            'imageFile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules
        ]);

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'imageURL_') === 0) {
                // Decode the base64 image
                $data = explode(',', $value);
                $imageData = base64_decode($data[1]);

                // Generate a unique filename
                $filename = uniqid() . '.png'; // Assuming all images are PNG
                $directory = 'assets/product/images/canvasImage/logo-design/';
                $filePath = public_path($directory . $filename);

                // Save the file
                file_put_contents($filePath, $imageData);

                // Store the URL in the session
                $imageUrl = $directory . $filename;
                $sessionKey = 'design' . '_' . $request->side . '_' . $request->product_id;
                session()->push($sessionKey, $imageUrl);
            }
        }
        // return session()->get($sessionKey);


        if ($request->hasFile('imageFile')) {
            // Get the file from the request
            $imageFile = $request->file('imageFile');
            // Generate a unique filename
            $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $directory = 'assets/product/images/product/mockup/';
            $imageUrl = $directory . $filename;

            $imageFile->move($directory, $filename);


            $sessionKey = 'mockup' . '_' . $request->side . '_' . $request->product_id;
            // dd($request->side);
            // session()->forget($sessionKey);
            $previousImageUrl = session()->get($sessionKey);

            // Check if the file exists before attempting to delete
            if (!empty($previousImageUrl['imageUrl']) && file_exists($previousImageUrl['imageUrl'])) {
                unlink($previousImageUrl['imageUrl']);
            }

            // $imageUrls = session()->get($sessionKey, []);
            // if (isset($imageUrls)) {
            //     $imageUrls[] = $imageUrl;
            //     session()->put($sessionKey, $imageUrls);
            // } else {
            //     $imageUrls = [];
            //     $imageUrls[] = $imageUrl;
            //     session()->put($sessionKey, $imageUrls);
            // }
            $objects = json_decode($request->input('objects'), true);  // Decode the objects from JSON

            Log::info('Premium objects input:', ['objects' => $request->input('objects')]);
            session()->put($sessionKey, [
                'objects' => $request->input('objects'),
                'imageUrl' => $imageUrl
            ]);
            return $imageUrl;

            // return session()->get($sessionKey,[]);


            // return response()->json(['message' => 'Image uploaded successfully', 'filename' => $filename], 200);
        }

        // Return an error response if the file is not found
        return response()->json(['error' => 'File not found'], 404);
        // unlink($gallaryImage->image);
    }
    public function saveCanvasImage(Request $request)
    {
        // session()->flush();
        // return 'hello';
        // return $request->product_id;
        // feathing all images to show in forntend
        $allSessionData = session()->all();
        // return $allSessionData;
        $productId = $request->product_id;
        $pattern = '/^texture.*_' . $productId . '$/';
        $matchingKeys = array_filter($allSessionData, function ($key) use ($pattern) {
            return preg_match($pattern, $key);
        }, ARRAY_FILTER_USE_KEY);

        // dd($matchingKeys);
        $request->validate([
            'imageFile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules
        ]);
        // dd($request->product_id);
        $imageCount = session('imageCount');
        // session()->forget('imageCount');
        if (is_null($imageCount)) {
            $imageCount = 1;
            session(['imageCount' => $imageCount], 1440);
        } else {
            $imageCount++;
            session(['imageCount' => $imageCount], 1440);
        }


        // Check if the request contains the file
        if ($request->hasFile('imageFile')) {
            // Get the file from the request
            $imageFile = $request->file('imageFile');
            // Generate a unique filename
            $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $directory = 'assets/product/images/canvasImage/logo-design/';
            $imageUrl = $directory . $filename;

            $imageFile->move($directory, $filename);
            // Store the file in the storage/app/public directory (or any other directory you prefer)
            // $imageFile->storeAs('images/canvasImage/logo-design', $filename);
            // Storage::disk('public')->put('images/canvasImage/logo-design' . $filename, $imageFile);
            // Optionally, you can save the file path to the database or perform any other operations
            // Example: You can save it to a model
            // $image = new Image();
            // $image->path = 'storage/images/' . $filename;
            // $image->save();

            $sessionKey = 'texture' . $imageCount . '_' . $request->product_id;

            session()->put($sessionKey, $imageUrl);
            // session(['totalProduct' => $totalProduct], 1440);
            // Return a response
            return response()->json(['message' => 'Image uploaded successfully', 'filename' => $filename], 200);
        }

        // Return an error response if the file is not found
        return response()->json(['error' => 'File not found'], 404);
        // unlink($gallaryImage->image);
    }

    public function deleteCanvasImage(Request $request)
    {
        $sessionKey = $request->cacheKey . '_' . $request->product_id;
        $textureData = session()->get($sessionKey);
        // return $textureData;
        // Check if the textureData is set and not empty
        if ($textureData && file_exists($textureData)) {
            if (unlink($textureData)) {
                return response()->json(['message' => 'Image Deleted successfully', 'filename' => $sessionKey], 200);
            } else {
                return response()->json(['message' => 'Error deleting the file'], 500);
            }
        } else {
            return response()->json(['message' => 'File does not exist', 'filename' => $textureData], 404);
        }
    }
    // private function saveImage($request)
    private function saveImage($image)
    {
        // $this->image = $request->file('image');
        $this->image = $image;
        // dd($request);
        if ($this->image) {
            $this->imageName = rand() . '.' . $this->image->getClientOriginalExtension();
            $this->directory = 'adminAsset/product-image/feature-image/';
            $this->imgUrl = $this->directory . $this->imageName;
            $this->image->move($this->directory, $this->imageName);
            return $this->imgUrl;
        } else {
            return $this->image;
        }
    }
    private function saveDesignImage($image)
    {
        // $this->image = $request->file('image');
        $this->image = $image;
        // dd($request);
        if ($this->image) {
            $this->imageName = rand() . '.' . $this->image->getClientOriginalExtension();
            $this->directory = 'adminAsset/product-image/design-image/';
            $this->imgUrl = $this->directory . $this->imageName;
            $this->image->move($this->directory, $this->imageName);
            return $this->imgUrl;
        } else {
            return $this->image;
        }
    }
}
