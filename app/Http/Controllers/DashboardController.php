<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. إحصائيات سريعة
        $stats = [
            'total_sales'  => Order::where('status', 'delivered')->sum('total_price'), // المبيعات الفعلية
            'new_orders'   => Order::where('status', 'pending')->count(),            // طلبات مستنية
            'total_users'  => User::count(),                                         // عدد الزبائن
            'total_items'  => Product::count(),                                      // عدد الوجبات
        ];

        // 2. آخر 10 طلبات وصلت
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('dashboard.index', compact('stats', 'recentOrders'));
    }


    // أضف هذه الدوال داخل DashboardController

public function updateStatus(Request $request, $id)
{
    $order = \App\Models\Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
}

public function showOrder($id)
{
    // بنجيب الأوردر مع الأصناف بتاعته ومعلومات المنتج لكل صنف
    $order = \App\Models\Order::with('items.product')->findOrFail($id);
    return view('dashboard.order-details', compact('order'));
}

// لعرض صفحة التعديل
public function editOrder($id)
{
    $order = Order::with('items.product')->findOrFail($id);
    $products = Product::all(); // عشان لو عايز يضيف صنف جديد
    return view('dashboard.edit-order', compact('order', 'products'));
}

// لتنفيذ التعديل
public function updateOrder(Request $request, $id)
{
    $order = Order::findOrFail($id);

    // 1. تحديث الكميات الموجودة أو حذف أصناف
    foreach ($request->items as $itemId => $data) {
        $item = \App\Models\OrderItem::find($itemId);
        if ($data['quantity'] <= 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $data['quantity']]);
        }
    }

    // 2. إعادة حساب الإجمالي النهائي للأوردر
    $newTotal = 0;
    $order->refresh(); // تحديث العلاقة بعد المسح أو التعديل
    foreach ($order->items as $item) {
        $newTotal += ($item->unit_price + ($item->is_combo ? $item->combo_price : 0)) * $item->quantity;
    }

    $order->update(['total_price' => $newTotal]);

    return redirect()->route('admin.orders.show', $order->id)->with('success', 'تم تعديل الأوردر بنجاح');
}
}