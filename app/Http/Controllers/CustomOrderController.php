<?php

namespace App\Http\Controllers;

use App\Mail\CustomOrder as MailCustomOrder;
use App\Models\CustomOrder;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Mail\NewClient;

use Illuminate\Support\Facades\Mail;

class CustomOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (isset(Auth()->user()->id)) {
            return view('frontend.custom-order.list', [
                'orders' => CustomOrder::where('user_id', Auth()->user()->id)->get(),
            ]);
            # code...
        } else {
            return back();
            # code...
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.shop.custom-order');

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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


        $existingUser = User::where('email', $request->email)->first();
        // return $existingUser;

        if (!$existingUser && !auth()->check()) {
                    // return $existingUser;

            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'clothing_type' => 'required|string|in:Shirts,Pants,Dresses,Outerwear,Accessories,Other',
                'specific_preferences' => 'nullable|string|max:1000',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ];

            // Validate the request data
            $request->validate($rules);
            // return $request;
            // $password = 'mpc_clothing';
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'user',
                'password' => Hash::make($request->password),
                'custom_user_parameter' => '1'
            ]);

            $user->assignRole('User');

            CustomOrder::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'company_name' => $request->company_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'clothing_type' => $request->clothing_type,
                'specific_preferences' => $request->specific_preferences,
            ]);

            Mail::to($request->email)->send(new MailCustomOrder());

            event(new Registered($user));

            Auth::login($user);
            return redirect(RouteServiceProvider::HOME_PATH);
        } else {

            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'clothing_type' => 'required|string|in:Shirts,Pants,Dresses,Outerwear,Accessories,Other',
                'specific_preferences' => 'nullable|string|max:1000',
            ];

            // Validate the request data
            $request->validate($rules);
            if (auth()->check()) {
                $user_id=auth()->user()->id;
                # code...
            }
            else {
                $user_id=$existingUser->id;
            }
            CustomOrder::create([
                'user_id' => $user_id,
                'name' => $request->name,
                'company_name' => $request->company_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'clothing_type' => $request->clothing_type,
                'specific_preferences' => $request->specific_preferences,
            ]);

            Mail::to($request->email)->send(new MailCustomOrder());

        }

        if (auth()->check()) {
            return redirect()->route('home')->with('message', 'Custom order submitted successfully! An agent will contact you soon.');
        } else {
            return redirect()->route('home')->with('message', 'Custom order submitted successfully! An agent will contact you soon.To see custom order, you need to login/create account using given email.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomOrder $customOrder)
    {
        return view('frontend.custom-order.details', [
            'order' => $customOrder
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
