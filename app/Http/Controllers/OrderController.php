<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // عرض صفحة بيانات الشحن (Checkout)
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'سلتك فاضية!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += ($item['price'] + ($item['is_combo'] ? $item['combo_price'] : 0)) * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    // حفظ الأوردر في الداتابيز
   public function store(Request $request)
{
    $cart = session()->get('cart', []);
    if (empty($cart)) return redirect()->route('menu.index');

        if ($request->input('delivery_option') === 'saved') {
            $request->validate([
                'customer_name' => 'required|string|max:255',
            ]);
            
            // Use saved details
            $phone = $request->input('saved_phone');
            $address = $request->input('saved_address');
        } else {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'phone' => 'required|string',
                'address' => 'required|string',
            ]);

            // Use new details
            $phone = $request->phone;
            $address = $request->address;
        }

    // التعديل هنا: خلي الـ transaction ترجع قيمة الـ order
    $order = DB::transaction(function () use ($request, $cart, $phone, $address) {
        
        $totalPrice = 0;
        foreach($cart as $item) {
            $totalPrice += ($item['price'] + ($item['is_combo'] ? $item['combo_price'] : 0)) * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'phone' => $phone,
            'address' => $address,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        foreach($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'variant_name' => $item['variant_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'is_combo' => $item['is_combo'],
                'combo_price' => $item['is_combo'] ? $item['combo_price'] : 0,
            ]);
        }

        session()->forget('cart');

        return $order; // لازم ترجع الـ order من هنا
    });

    // دلوقتي الـ $order بقت معروفة هنا
    return redirect()->route('order.success')
        ->with('order_id', $order->id)
        ->with('customer_name', $order->customer_name)
        ->with('phone', $order->phone)
        ->with('address', $order->address)
        ->with('total_price', $order->total_price);
}

    public function success(Request $request)
{
    // بنجيب رقم الأوردر من الرابط أو من السيشين
    $orderId = $request->query('order') ?? session('order_id');

    if (!$orderId) {
        return redirect()->route('menu.index'); // لو مفيش أوردر فعلاً هيرجعه للمينيو
    }

    // هنجيب بيانات الأوردر عشان الـ JavaScript يلقطها
    $order = \App\Models\Order::find($orderId);

    return view('checkout.success', compact('order'));
}
}
