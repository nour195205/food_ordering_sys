<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SiteSetting; // عشان نجيب سعر الكومبو الديناميكي
use Illuminate\Http\Request;

class CartController extends Controller
{
    // عرض محتويات السلة
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            if($item['is_combo']) {
                $itemTotal += ($item['combo_price'] * $item['quantity']);
            }
            $total += $itemTotal;
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // إضافة منتج للسلة
    public function add(Request $request)
    {
        $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
        
        // نجيب سعر الكومبو من الإعدادات (لو مش موجود نثبت 45)
        $comboPrice = SiteSetting::where('key', 'combo_price')->value('value') ?? 45;

        $cart = session()->get('cart', []);
        $cartKey = $variant->product_id . '_' . $variant->id;

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                "product_id" => $variant->product_id,
                "variant_id" => $variant->id,
                "name" => $variant->product->name,
                "variant_name" => $variant->variant_name,
                "quantity" => 1,
                "price" => $variant->price,
                "image" => $variant->product->image,
                "is_combo" => false,
                "combo_price" => $comboPrice
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'تمت الإضافة للسلة');
    }

    // تحويل الساندوتش لـ كومبو أو العكس
    public function toggleCombo($cartKey)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['is_combo'] = !$cart[$cartKey]['is_combo'];
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // حذف صنف من السلة
    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'تم حذف الصنف');
    }
}