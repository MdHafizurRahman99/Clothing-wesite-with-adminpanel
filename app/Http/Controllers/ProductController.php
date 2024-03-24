<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PriceRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductQuentity;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public $image, $imageName, $directory, $imgUrl;


    public function index()
    {
        return view(
            'admin.product.list',
            [
                'products' => Product::all(),
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
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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


        $image = $this->saveImage($request);
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image' => $image,
            'description' => $request->description,
        ]);

        $images = session()->get('product_image');
        foreach ($images as $imageUrl) {
            $saveImage = ProductImage::create([
                'product_id' => $product->id,
                'type' => 'gallery',
                'image_url' => $imageUrl,
            ]);
        }
        session()->forget('product_image');
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
                        // $maximum = $minimum;
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
            'quentity' => $quantityArray,
            'prices' => $priceArray,
            'minQuantity' => $minQuantityArray,
            'maxQuantity' => $maxQuantityArray,
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


        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
        if (isset($request->image)) {
            unlink($product->image);
            $image = $this->saveImage($request);
            $product->update([
                'image' => $image,
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
        $cacheKey = session('cacheKey');
        // return $request;
        $productId = $request->productId;
        // dd($productId);
        $productCacheKey = $cacheKey . '_' . $productId;
        // Retrieve cache data for the current product
        $cartProduct = cache()->get($productCacheKey);
        $cachedDataInputValues = $cartProduct['input'];
        // return $cachedDataInputValues;
        $cachedDataInputValues[$request->key] = $request->quantity;
        $postData = [
            'input' => $cachedDataInputValues,
            'files' => $request->files->all(),
            'cookies' => $request->cookies->all(),
            // Add more data as needed
        ];
        cache()->put($productCacheKey, $postData, now()->addMinutes(1440));
        $totalProduct = session('totalProduct');
        // return $totalProduct;
        // $requestInputValues = $request->input();
        if ($totalProduct >= 0) {
            $totalProduct++;
            session(['totalProduct' => $totalProduct], 1440);
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
        $cachedDataInputValues[$request->key] = $request->quantity;
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


    public function saveCanvasMockup(Request $request)
    {
        $request->validate([
            'imageFile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules
        ]);
        // dd($request->product_id);
        // $imageCount = session('imageCount');
        // session()->forget('imageCount');
        // if (is_null($imageCount)) {
        //     $imageCount = 1;
        //     session(['imageCount' => $imageCount], 1440);
        // } else {
        //     $imageCount++;
        //     session(['imageCount' => $imageCount], 1440);
        // }
        // Check if the request contains the file
        if ($request->hasFile('imageFile')) {
            // Get the file from the request
            $imageFile = $request->file('imageFile');
            // Generate a unique filename
            $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $directory = 'assets/product/images/product/mockup/';
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

            $sessionKey = 'mockup' . '_' . $request->product_id;

            session()->put($sessionKey, $imageUrl);
            // session(['totalProduct' => $totalProduct], 1440);
            // Return a response
            return response()->json(['message' => 'Image uploaded successfully', 'filename' => $filename], 200);
        }

        // Return an error response if the file is not found
        return response()->json(['error' => 'File not found'], 404);
        // unlink($gallaryImage->image);
    }
    public function saveCanvasImage(Request $request)
    {

        // feathing all images to show in forntend
        $allSessionData = session()->all();
        $productId = 2; // Predefined product id.
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
        unlink($textureData);

        return response()->json(['message' => 'Image Deleted successfully', 'filename' => $sessionKey], 200);
    }
    private function saveImage($request)
    {
        $this->image = $request->file('image');
        // dd($request);
        if ($this->image) {
            $this->imageName = rand() . '.' . $this->image->getClientOriginalExtension();
            $this->directory = 'adminAsset/product-feature-image/';
            $this->imgUrl = $this->directory . $this->imageName;
            $this->image->move($this->directory, $this->imageName);
            return $this->imgUrl;
        } else {
            return $this->image;
        }
    }
}
