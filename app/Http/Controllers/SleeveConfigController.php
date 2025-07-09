<?php

namespace App\Http\Controllers;

use App\Models\SleeveConfig;
use App\Models\Product;
use App\Models\sleeve_config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SleeveConfigController extends Controller
{
    public function index()
    {
        $configs = sleeve_config::with('product')->get();
        return response()->json($configs);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id|unique:sleeve_configs,product_id',
            'left_image_left' => 'required|numeric',
            'left_image_rotate' => 'required|numeric',
            'sleeve_top' => 'required|numeric',
            'left_image_right' => 'required|numeric',
            'left_image_right_rotate' => 'required|numeric',
            'right_image_left' => 'required|numeric',
            'right_image_rotate' => 'required|numeric',
            'right_image_right' => 'required|numeric',
            'right_image_right_rotate' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $config = sleeve_config::create($request->all());
        return response()->json($config, 201);
    }

    public function show($id)
    {
        $config = sleeve_config::with('product')->findOrFail($id);
        return response()->json($config);
    }

    public function update(Request $request, $id)
    {
        $config = sleeve_config::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id|unique:sleeve_configs,product_id,' . $id,
            'left_image_left' => 'required|numeric',
            'left_image_rotate' => 'required|numeric',
            'sleeve_top' => 'required|numeric',
            'left_image_right' => 'required|numeric',
            'left_image_right_rotate' => 'required|numeric',
            'right_image_left' => 'required|numeric',
            'right_image_rotate' => 'required|numeric',
            'right_image_right' => 'required|numeric',
            'right_image_right_rotate' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $config->update($request->all());
        return response()->json($config);
    }

    public function destroy($id)
    {
        $config = sleeve_config::findOrFail($id);
        $config->delete();
        return response()->json(null, 204);
    }
}
