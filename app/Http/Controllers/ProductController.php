<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
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
}
