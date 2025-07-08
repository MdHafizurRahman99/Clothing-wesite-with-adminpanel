<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSide;
use Illuminate\Http\Request;

class ProductSideController extends Controller
{
    public function getSides($productId)
    {
        $product = Product::findOrFail($productId);
        $sides = ProductSide::where('product_id', $productId)->get()->map(function ($side) use ($product) {
            $imageField = "design_image_{$side->side}_side";
            $side->image_url = $product->$imageField ? asset(  $product->$imageField) : null;
            return $side;
        });

        return response()->json($sides);
    }

    public function saveCoordinate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'side' => 'required|in:front,back,left,right',
            'x' => 'required|numeric',
            'y' => 'required|numeric'
        ]);

        $side = ProductSide::where('product_id', $request->product_id)
            ->where('side', $request->side)
            ->firstOrFail();
        $mappings = json_decode($side->adjacent_side_mappings, true);
        $mappings[$request->side][] = [
            'side' => $request->side,
            'x' => $request->x,
            'y' => $request->y,
            'scale' => 0.2,
            'rotation' => 0
        ];
        $side->update(['adjacent_side_mappings' => json_encode($mappings)]);

        return response()->json(['message' => 'Coordinate saved']);
    }
}
