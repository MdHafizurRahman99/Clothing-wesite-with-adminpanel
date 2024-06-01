<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.color.list',
        [
            'colors'=>Color::all()
        ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.color.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'required' => 'The :attribute field is required.',
        ]);
        $validator->setAttributeNames([
            'name' => 'Name',
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $color = Color::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return back()->with('message','Color Added Successfully!');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        //
    }
}
