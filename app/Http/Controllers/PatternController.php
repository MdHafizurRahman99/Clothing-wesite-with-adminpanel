<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use Illuminate\Http\Request;

class PatternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin.product.pattern.list',
            [
                'patterns' => Pattern::all(),
            ]
        );
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.pattern.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pattern = Pattern::create(
            ['name' => $request->name,]
        );
        return redirect()->route('pattern.index')->with('message', 'Pattern Added Sucessfully!');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pattern $pattern)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pattern $pattern)
    {
        return view(
            'admin.product.pattern.edit',
            [
                'pattern' => $pattern
            ]
        );
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pattern $pattern)
    {
        $pattern->update(
            [
                'name' => $request->name
            ]
        );
        return redirect()->route('pattern.index')->with('message', 'Pattern Updated Sucessfully!');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pattern $pattern)
    {
        $pattern->delete();
        return redirect()->route('pattern.index')->with('message', 'Pattern Deleted Sucessfully!');

        //
    }
}
