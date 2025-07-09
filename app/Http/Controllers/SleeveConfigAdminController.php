<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\sleeve_config;
use App\Models\SleeveConfig;

class SleeveConfigAdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $configs = sleeve_config::with('product')->get();
        return view('admin.product.sleeve_configs', compact('products', 'configs'));
    }
}
