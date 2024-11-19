<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class GalleryImageController extends Controller
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
        // return view('admin.product.gallery-images.create');
        //
    }
    public function createimages($product_id)
    {
        $product = Product::findOrFail($product_id);
        $colors = $product->colors;


        // return $colors;
        return view(
            'admin.product.gallery-images.create',
            [
                'product_id' => $product_id,
                'colors' => $colors
            ]
        );
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return back()->with('message','Images Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        //
    }

    public function galleryImage(Request $request)
    {

        $images = $request->file('file');
        // return $request->product_id;
        // return $request->color;

        foreach ($images as $image) {
            $extention = $image->getClientOriginalExtension();
            $imageName = rand() . '.' . $extention;
            $directory = 'assets/frontend/product/gallery-images/color/';
            $imageUrl = $directory . $imageName;
            session()->push('galleryImage', $imageUrl);
            $image->move($directory, $imageName);
            // return $imageUrl;
            $saveImage = ProductImage::create([
                'product_id' => $request->product_id,
                'type' => 'gallery',
                'color' =>  $request->color,
                'image_url' => $imageUrl,
            ]);
        }
        return $imageUrl;
    }
}
