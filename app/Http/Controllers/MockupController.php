<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSide;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class MockupController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'side' => 'required|in:front,back,left,right',
            'imageFile' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'objects' => 'required|array'
        ]);

        $productId = $request->product_id;
        $side = $request->side;
        $product = Product::findOrFail($productId);
        $sideConfig = ProductSide::where('product_id', $productId)->where('side', $side)->firstOrFail();

        $imageField = "design_image_{$side}_side";
        $baseImage = Image::make(storage_path('app/public/' . $product->$imageField));

        if ($request->hasFile('imageFile')) {
            $userDesign = Image::make($request->file('imageFile'));
            $designArea = json_decode($sideConfig->design_area, true);
            $userDesign->resize($designArea['width'], $designArea['height']);
            $baseImage->insert($userDesign, 'top-left', $designArea['x'], $designArea['y']);
        }

        $adjacentMappings = json_decode($sideConfig->adjacent_side_mappings, true)[$side] ?? [];
        foreach ($adjacentMappings as $mapping) {
            $adjacentSide = ProductSide::where('product_id', $productId)->where('side', $mapping['side'])->first();
            if ($adjacentSide && $request->hasFile('adjacent_image_' . $mapping['side'])) {
                $adjacentDesign = Image::make($request->file('adjacent_image_' . $mapping['side']));
                $designArea = json_decode($adjacentSide->design_area, true);

                // Apply cropping if specified
                if (isset($mapping['crop'])) {
                    $cropX = $mapping['crop']['x'] * $adjacentDesign->width();
                    $cropWidth = $mapping['crop']['width'] * $adjacentDesign->width();
                    $adjacentDesign->crop($cropWidth, $adjacentDesign->height(), $cropX, 0);
                }

                $adjacentDesign->resize($designArea['width'] * $mapping['scale'], $designArea['height'] * $mapping['scale']);
                $adjacentDesign->rotate($mapping['rotation']);
                $baseImage->insert($adjacentDesign, 'top-left', $mapping['x'], $mapping['y']);
            }
        }

        $outputPath = 'mockups/' . uniqid() . '.png';
        $baseImage->save(storage_path('app/public/' . $outputPath));
        return response()->json(['mockup_url' => asset('storage/' . $outputPath)]);
    }
}
