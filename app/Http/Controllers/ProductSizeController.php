<?php

namespace App\Http\Controllers;

use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = ProductSize::all();
        return view('admin.product.size.list', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.size.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'size' => 'required|string|max:255',
        ]);

        ProductSize::create($request->only(['type', 'size']));

        return redirect()->back()->with('message', 'Size added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSize $productSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSize $productSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSize $productSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSize $productSize)
    {
        $productSize->delete();

        return redirect()->route('productSize.index')->with('message', 'Size deleted successfully!');
    }
}
