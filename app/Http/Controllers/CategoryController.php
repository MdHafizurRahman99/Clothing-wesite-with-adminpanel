<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $image, $imageName, $directory, $imgUrl;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.category.list', [
            'Categories' => Category::all(),
        ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
        ];

        // Conditionally add validation rules for 'description' and 'image' only if they are present and not null
        if ($request->filled('description')) {
            $rules['description'] = 'string';
        }

        if ($request->filled('category_image')) {
            $rules['category_image'] = 'file|image|mimes:jpeg,png,jpg,gif,JPEG,PNG,JPG,GIF';
        }

        $validatedData = $request->validate($rules);


        $image = $this->saveImage($request);

        // return $image;
        // return $request;
        $category = Category::create(
            [
                'category_name' => $request->name,
                'description' => $request->description,
                'image' => $image,
            ]
        );
        return redirect()->route('category.index')->with('message', 'Category Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', [
            'category' => $category
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if ($request->category_image) {
            $image = $this->saveImage($request);
            if ($category->image) {
                unlink($category->image);
            }
            $category->update(
                [
                    'image' => $image,
                ]
            );
        }
        //
        $category->update(
            [
                'category_name' => $request->name,
                'description' => $request->description,
            ]
        );

        return redirect()->route('category.index')->with('message', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            unlink($category->image);
        }

        $category->delete();
        return back()->with('message', 'Category Deleted Successfully!');
    }

    private function saveImage($request)
    {
        $this->image = $request->file('category_image');
        // dd($request);
        if ($this->image) {
            $this->imageName = rand() . '.' . $this->image->getClientOriginalExtension();
            $this->directory = 'adminAsset/category-image/';
            $this->imgUrl = $this->directory . $this->imageName;
            $this->image->move($this->directory, $this->imageName);
            return $this->imgUrl;
        } else {
            return $this->image;
        }
    }
}
