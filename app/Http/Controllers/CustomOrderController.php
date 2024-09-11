<?php

namespace App\Http\Controllers;

use App\Mail\CustomOrder as MailCustomOrder;
use App\Models\CustomOrder;
use App\Models\CustomOrderImage;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Mail;

class CustomOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function index()
    {

        if (auth()->check()) {
            if (Auth()->user()->role == 'user') {
                return view('frontend.custom-order.list', [
                    'orders' => CustomOrder::where('user_id', Auth()->user()->id)->get(),
                ]);
            } elseif (Auth()->user()->role == 'admin') {
                $orders = CustomOrder::whereHas('user', function ($query) {
                    $query->whereNotNull('email_verified_at');
                })->orderBy('created_at', 'desc')->get();
                // return $orders;
                // Log the fetched orders for debugging
                // \Log::info($orders);
                return view('admin.custom-order.list', [
                    'orders' => CustomOrder::whereHas('user', function ($query) {
                        $query->whereNotNull('email_verified_at');
                    })->orderBy('created_at', 'desc')->get(),
                ]);
            }
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->check()) {
            return view('frontend.shop.custom-order');
        } else {
            return redirect()->route('login')->with('message', 'Please login first.');
        }
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->check()) {
            // Retrieve the authenticated user's email
            $email = auth()->user()->email;
        } else {
            return redirect('login')->with('message', 'Please login.');
        }
        // return $email;
        // dd(auth()->user()->email);
        // return $request;

        $rules = [
            'target' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'subcategory' => 'string|max:255',
            'looking_for' => 'required|max:255',
            'additional_services' => 'nullable',
            'number_of_products' => 'required',
            'quantity_per_product' => 'required',
            'project_budget' => 'required',
            'sample_delivery_date' => 'required',
            'production_delivery_date' => 'required ',
            'project_description' => 'nullable|string',
            'inspiration_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // Define custom attribute names
        $attributes = [
            'target' => 'Target',
            'category' => 'Category',
            'subcategory' => 'Subcategory',
            'looking_for' => 'Looking For',
            'additional_services' => 'Additional Services',
            'number_of_products' => 'Number of Products',
            'quantity_per_model' => 'Quantity Per Model',
            'project_budget' => 'Project Budget',
            'sample_delivery_date' => 'Sample Delivery Date',
            'production_delivery_date' => 'Production Delivery Date',
            'project_description' => 'Project Description',
            'inspiration_images' => 'Inspiration Images',
        ];
        $request->validate($rules, [], $attributes);
        // return 'hello';
        $custom = CustomOrder::create(
            [
                'user_id' => auth()->user()->id,
                'target' => $request->target,
                'category' => $request->category,
                'subcategory' => $request->subcategory,
                'looking_for' => json_encode($request->looking_for),
                'additional_services' => json_encode($request->additional_services),
                'number_of_products' => $request->number_of_products,
                'quantity_per_model' => $request->quantity_per_product,
                'project_budget' => $request->project_budget,
                'sample_delivery_date' => $request->sample_delivery_date,
                'production_delivery_date' => $request->production_delivery_date,
                'project_description' => $request->project_description,
            ]
        );
        // return $custom->id;
        // Validate the request

        $imagePaths = [];

        // Handle the uploaded files
        if ($request->hasfile('inspiration_images')) {
            foreach ($request->file('inspiration_images') as $file) {
                $extention = $file->getClientOriginalExtension();
                $imageName = rand() . '.' . $extention;
                $directory = 'assets/frontend/product/custom-order/inspiration-images/';
                $imageUrl = $directory . $imageName;
                session()->push('galleryImage', $imageUrl);
                $file->move($directory, $imageName);
                $image = CustomOrderImage::create(
                    [
                        'custom_order_id' => $custom->id,
                        'image_url' => $imageUrl,
                    ]
                );
                // $name = time() . '_' . $file->getClientOriginalName();
                // // return $name;
                // // Store the file in the public storage
                // $path = $file->storeAs('public/inspiration_images', $name);
                // // Add the file path to the array
                // $imagePaths[] = Storage::url($path);

            }
        }
        Mail::to($email)->send(new MailCustomOrder());

        return redirect()->route('home')->with('message', 'Product Custom Order created successfully.');


        // return auth()->user()->id;
        // $rules = [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255',
        //     'phone' => 'nullable|string|max:20',
        //     'clothing_type' => 'required|string|in:Shirts,Pants,Dresses,Outerwear,Accessories,Other',
        //     'specific_preferences' => 'nullable|string|max:1000',
        // ];

        // // Validate the request data
        // $request->validate($rules);
        // if (auth()->check()) {
        //     CustomOrder::create([
        //         'user_id' => auth()->user()->id,
        //         'name' => $request->name,
        //         'company_name' => $request->company_name,
        //         'email' => $request->email,
        //         'phone' => $request->phone,
        //         'clothing_type' => $request->clothing_type,
        //         'specific_preferences' => $request->specific_preferences,
        //     ]);
        //     return redirect()->route('home')->with('message', 'Custom order submitted successfully! An agent will contact you soon.');
        // } else {
        //     return redirect()->route('login')->with('message', 'To submit custom order, you need to log in first.');
        // }

        //
        //**************************************************** */

        // $existingUser = User::where('email', $request->email)->first();
        // // return $existingUser;

        // if (!$existingUser && !auth()->check()) {
        //     // return $existingUser;

        //     $rules = [
        //         'name' => 'required|string|max:255',
        //         'email' => 'required|email|max:255',
        //         'phone' => 'nullable|string|max:20',
        //         // 'clothing_type' => 'required|string|in:Shirts,Pants,Dresses,Outerwear,Accessories,Other',
        //         'specific_preferences' => 'nullable|string|max:1000',
        //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
        //     ];

        //     // Validate the request data
        //     $request->validate($rules);
        //     // return $request;
        //     // $password = 'mpc_clothing';
        //     $user = User::create([
        //         'name' => $request->name,
        //         'email' => $request->email,
        //         'role' => 'user',
        //         'password' => Hash::make($request->password),
        //         'custom_user_parameter' => '1'
        //     ]);

        //     $user->assignRole('User');

        //     CustomOrder::create([
        //         'user_id' => $user->id,
        //         'name' => $request->name,
        //         'company_name' => $request->company_name,
        //         'email' => $request->email,
        //         'phone' => $request->phone,
        //         'clothing_type' => json_encode($request->clothing_type),
        //         'specific_preferences' => $request->specific_preferences,
        //     ]);

        //     Mail::to($request->email)->send(new MailCustomOrder());

        //     event(new Registered($user));

        //     Auth::login($user);
        //     return redirect(RouteServiceProvider::HOME_PATH);
        // } else {

        //     $rules = [
        //         'name' => 'required|string|max:255',
        //         'email' => 'required|email|max:255',
        //         'phone' => 'nullable|string|max:20',
        //         // 'clothing_type' => 'required|string|in:Shirts,Pants,Dresses,Outerwear,Accessories,Other',
        //         'specific_preferences' => 'nullable|string|max:1000',
        //     ];

        //     // Validate the request data
        //     $request->validate($rules);
        //     if (auth()->check()) {
        //         $user_id = auth()->user()->id;
        //         # code...
        //     } else {
        //         $user_id = $existingUser->id;
        //     }
        //     CustomOrder::create([
        //         'user_id' => $user_id,
        //         'name' => $request->name,
        //         'company_name' => $request->company_name,
        //         'email' => $request->email,
        //         'phone' => $request->phone,
        //         'clothing_type' => json_encode($request->clothing_type),
        //         'specific_preferences' => $request->specific_preferences,
        //     ]);

        //     Mail::to($request->email)->send(new MailCustomOrder());
        // }

        // if (auth()->check()) {
        //     return redirect()->route('home')->with('message', 'Custom order submitted successfully!
        //     An agent will contact you soon.');
        // } else {
        //     return redirect()->route('home')->with('message', 'Custom order submitted successfully!
        //     An agent will contact you soon.To see custom order, you need to login.');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomOrder $customOrder)
    {
        return view('frontend.custom-order.details', [
            'order' => $customOrder,
            'images' => CustomOrderImage::where('custom_order_id', $customOrder->id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomOrder $customOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomOrder $customOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomOrder $customOrder)
    {
        //
    }
}
