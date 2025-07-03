<?php

namespace App\Http\Controllers;

use App\Models\CustomDesign;
use Illuminate\Http\Request;

class CustomDesignController extends Controller
{
    public $image, $imageName, $directory, $imgUrl;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $sessionKey = 'mockup_front_' . $request->product_id;

        // return session()->get($sessionKey,[]);
        // return $request;
        $swing_tag_design = $this->saveImage($request->file('swing_tag_design'));
        $neck_level_design = $this->saveImage($request->file('neck_level_design'));
        $right_sleeve_design = $this->saveImage($request->file('right_sleeve_design'));
        $left_sleeve_design = $this->saveImage($request->file('left_sleeve_design'));
        $customDesignAdditionalData = [
            'input' => $request->input(),
            'files' => [
                'swing_tag_design' => $swing_tag_design,
                'neck_level_design' => $neck_level_design,
                'right_sleeve_design' => $right_sleeve_design,
                'left_sleeve_design' => $left_sleeve_design,
            ],
            // 'cookies' => $request->cookies->all(),
            // Add more data as needed
        ];

        $customDesignAdditionalDatakey = 'customDesignAdditionalData_' . $request->product_id;

        $cachedData = cache()->get($customDesignAdditionalDatakey);
        if (!empty($cachedData['files'])) {
            foreach ($cachedData['files'] as $filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath); // Deletes the file
                }
            }
        }
        $cachedData = cache()->forget($customDesignAdditionalDatakey);

        // Store the data in the cache
        cache()->put($customDesignAdditionalDatakey, $customDesignAdditionalData, now()->addMinutes(1440));
        //  $data = cache()->get($customDesignAdditionalDatakey);
        //  return $data['input']['neck_level_details'];
        // $cachedData = cache()->forget($customDesignAdditionalDatakey);
        // return $data;

        $cartController = new CartController();
        $cartController->addToCart($request);

        return redirect()->route('shop.product-cart');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomDesign $custom_product_design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomDesign $custom_product_design)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomDesign $custom_product_design)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomDesign $custom_product_design)
    {
        //
    }

    private function saveImage($image)
    {
        $this->image = $image;
        // $this->image = $request->file('category_image');
        // dd($request);
        if ($this->image) {
            $this->imageName = rand() . '.' . $this->image->getClientOriginalExtension();
            $this->directory = 'images/customOrder/';
            $this->imgUrl = $this->directory . $this->imageName;
            $this->image->move($this->directory, $this->imageName);
            return $this->imgUrl;
        } else {
            return $this->image;
        }
    }
}
