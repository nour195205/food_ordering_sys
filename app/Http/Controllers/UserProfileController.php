<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class UserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // بنجيب طلبات اليوزر ده بس ونرتبها من الأحدث للأقدم
        $orders = Order::where('user_id', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('user_profile.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            // لو عندك حقول زيادة في جدول الـ users زي phone
            'phone' => 'nullable|string', 
        ]);

        $user->update($request->only('name', 'phone'));

        return redirect()->back()->with('success', 'تم تحديث بياناتك بنجاح');
    }
}