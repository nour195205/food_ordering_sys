<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UserProfile;


class UserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user_profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        // Update User table for name
        $user->update(['name' => $request->name]);

        // Update or Create UserProfile for extra details
        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'alt_phone' => $request->alt_phone,
                'address' => $request->address,
                'city' => 'Damanhour', // Default
            ]
        );

        return redirect()->back()->with('success', 'تم تحديث بياناتك بنجاح');
    }
}