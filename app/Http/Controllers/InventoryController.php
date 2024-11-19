<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view(
        //     'admin.product.inventory.list',
        //     [
        //         // 'inventories' => Inventory::where('product_id', $product_id)
        //     ]
        // );
        //
    }
    public function productInventoryList()
    {
        return view(
            'admin.product.inventory.inventory-product-list',
            [
                'products' => Product::all(),
            ]
        );
        //
    }
    public function productInventories($product_id)
    {
        return view(
            'admin.product.inventory.list',
            [
                'inventories' => Inventory::where('product_id', $product_id)->get(),
                'product_id' => $product_id,
            ]
        );
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function createInventory($product_id)
    {
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

        $product = Product::findOrFail($product_id);
        $colors = $product->colors;
        return view(
            'admin.product.inventory.create',
            [
                'product' => Product::find($product_id),
                'quentity' => $quantityArray,
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
        // return $request;

        $validator = Validator::make($request->all(), [

            'product_id' => 'required',

        ], [
            'required' => 'The :attribute field is required.',
        ]);

        $validator->setAttributeNames([
            'product_id' => 'Product Id',
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // products weights
        // dd($request);
        // $inventory = Inventory::create([
        //     'product_id' => $request->product_id,
        //     'size' => $request->size,
        //     'color' => $request->color,
        //     'weight' => $request->weight,
        //     'quantity' => $request->quantity,
        // ]);
        Inventory::where('product_id', $request->product_id)->delete();
        $requestData = $request->except(['_token', 'product_id']); // Exclude _token and product_id

        // $suffixes = ['Aquamarine', 'DarkGoldenRod', 'Blue', 'Brown', 'Purple', 'White'];
        foreach ($requestData as $key => $value) {
            // Split the key to separate size and color
            list($size, $color) = explode('_', $key);
            // return $key;
            // Check if the key starts with "XS_", "S_", "M_", "L_", or "XL_"
            // if (preg_match('/^(XS|S|M|L|XL)_(.+)$/', $key, $matches)) {
            // dd($matches[1]);
            // Extract size and color
            // $size = $matches[1];
            // $color = $matches[2];
            $productQuuentity = Inventory::Create([
                'product_id' => $request->product_id,
                'size' => $size,
                'color' => $color,
                'quantity' => $value,
            ]);
            // }
        }


        return redirect()->route('product.inventories', ['product_id' => $request->product_id])->with('message', 'Inventory Added Successfully');
        // return back()->with('message', 'Inventory Added Successfully');
        // return $request;

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        return view('admin.product.inventory.edit', [
            'product' => Product::find($inventory->product_id),
            'inventory' => $inventory
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'size' => 'required',
            'color' => 'required',
            // 'weight' => 'required|numeric',
            'quantity' => 'required|numeric',

        ], [
            'required' => 'The :attribute field is required.',
        ]);

        $validator->setAttributeNames([
            'size' => 'Product Size',
            'color' => 'Product Color',
            // 'weight' => 'Product Weight',
            'quantity' => 'Product Quantity',
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inventory->update([
            'product_id' => $request->product_id,
            'size' => $request->size,
            'color' => $request->color,
            // 'weight' => $request->weight,
            'quantity' => $request->quantity,
        ]);
        return redirect()->route('product.inventories', ['product_id' => $request->product_id])->with('message', 'Inventory Updated Successfully');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $inventory = $inventory->delete();
        return back()->with('message', 'Inventory Deleted Successfully');

        //
    }
}
