<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // عرض كل الأوردرات (مع Pagination عشان لو زادوا)
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    // عرض تفاصيل أوردر محدد
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // تحديث الحالة
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'تم تحديث الحالة بنجاح ✅');
    }
}