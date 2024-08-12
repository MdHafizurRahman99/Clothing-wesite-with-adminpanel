<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(UserProfile $userProfile)
    public function show(User $userProfile)
    {
        $data = UserProfile::where('user_id', auth()->user()->id)->first();
        return view('frontend.customer-profile.profile', [
            'userData' => $userProfile,
            'userProfile' => $data,
        ]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $userProfile)
    {
        $data = UserProfile::where('user_id', auth()->user()->id)->first();

        return view('frontend.customer-profile.edit-profile', [
            'user' => $userProfile,
            'userProfile' => $data,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $userProfile)
    {
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            // 'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'billing_address1' => 'nullable|string|max:255',
            'billing_address2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_postcode' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:255',
            // 'same_as_billing' => 'boolean',
            'shipping_address1' => 'nullable|string|max:255',
            'shipping_address2' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_postcode' => 'nullable|string|max:20',
            'shipping_country' => 'nullable|string|max:255',
            'primary_payment_method' => 'nullable|string|max:255',
            'terms' => 'nullable|string|max:255',
            'discount' => 'nullable|string|max:255',
            'customer_type' => 'nullable|string|max:255',
        ]);



        if ($request->hasFile('profile_picture')) {

            if ($userProfile->profile_picture && file_exists(public_path($userProfile->profile_picture))) {
                unlink(public_path($userProfile->profile_picture));
            }
            $image = $this->saveImage($request);
            // return $image;
            $userProfile->update([
                'profile_picture' => $image,
            ]);
        }
        // return $userProfile;
        // $user = Auth::user();
        $userProfile->update([
            'name' => $request->name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'phone' => $request->phone,
            // 'email' => $request->email,
        ]);

        $userProfileAditionalInfo = UserProfile::where('user_id', auth()->user()->id)->first();
        if (isset($userProfileAditionalInfo)) {
            $userProfileAditionalInfo->update([
                'user_id' => auth()->user()->id,
                'company_name' => $request->company_name,
                'mobile' => $request->mobile,
                'fax' => $request->fax,
                'billing_address1' => $request->billing_address1,
                'billing_address2' => $request->billing_address2,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_postcode' => $request->billing_postcode,
                'billing_country' => $request->billing_country,
                'same_as_billing' => $request->same_as_billing,
                'shipping_address1' => $request->shipping_address1,
                'shipping_address2' => $request->shipping_address2,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postcode' => $request->shipping_postcode,
                'shipping_country' => $request->shipping_country,
                'primary_payment_method' => $request->primary_payment_method,
                'terms' => $request->terms,
                'discount' => $request->discount,
                'customer_type' => $request->customer_type,
            ]);
        } else {
            $userProfileAditionalInfo = UserProfile::create([
                'user_id' => auth()->user()->id,
                'company_name' => $request->company_name,
                'mobile' => $request->mobile,
                'fax' => $request->fax,
                'billing_address1' => $request->billing_address1,
                'billing_address2' => $request->billing_address2,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_postcode' => $request->billing_postcode,
                'billing_country' => $request->billing_country,
                'same_as_billing' => $request->same_as_billing,
                'shipping_address1' => $request->shipping_address1,
                'shipping_address2' => $request->shipping_address2,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postcode' => $request->shipping_postcode,
                'shipping_country' => $request->shipping_country,
                'primary_payment_method' => $request->primary_payment_method,
                'terms' => $request->terms,
                'discount' => $request->discount,
                'customer_type' => $request->customer_type,
            ]);
        }
        // dd($userProfile);
        // return $userProfile;


        return redirect()->route('user-profile.show', ['user_profile' => $userProfile->id])->with('message', 'Profile updated successfully.');
    }

    private function saveImage($request)
    {
        $this->image = $request->file('profile_picture');
        // dd($request);
        if ($this->image) {
            $this->imageName = rand() . '.' . $this->image->getClientOriginalExtension();
            $this->directory = 'images/user-image/';
            $this->imgUrl = $this->directory . $this->imageName;
            $this->image->move($this->directory, $this->imageName);
            return $this->imgUrl;
        } else {
            return $this->image;
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}
