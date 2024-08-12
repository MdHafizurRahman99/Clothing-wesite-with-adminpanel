<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductImage::all();
    }
    public function anikProductImage(){
        return view('anikimage');

    }

    public function store(Request $request)
    {
        dd('hello');
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048'
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $image = ProductImage::create([
            'title' => $request->title,
            'image_path' => $imagePath
        ]);

        return response()->json($image, 201);
    }

    public function show($id)
    {
        return ProductImage::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $image = ProductImage::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($image->image_path);
            $imagePath = $request->file('image')->store('images', 'public');
            $image->image_path = $imagePath;
        }

        if ($request->has('title')) {
            $image->title = $request->title;
        }

        $image->save();

        return response()->json($image);
    }

    public function destroy($id)
    {
        dd('hello');
        $image = ProductImage::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(null, 204);
    }
}
