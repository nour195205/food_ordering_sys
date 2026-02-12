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

        $deliveryFee = SiteSetting::where('key', 'delivery_fees')->value('value') ?? 20;
        $grandTotal = $total + $deliveryFee;

        return view('cart.index', compact('cart', 'total', 'deliveryFee', 'grandTotal'));
    }

    // إضافة منتج للسلة
    public function add(Request $request)
    {
        $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
        
        // نجيب سعر الكومبو من الإعدادات (لو مش موجود نثبت 45)
        $comboPrice = SiteSetting::where('key', 'combo_price')->value('value') ?? 45;

        // استلام الكمية والكومبو من الريكويست
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) $quantity = 1;

        $isCombo = $request->has('is_combo'); 
        
        // التحقق من قابلية الكومبو
        if ($isCombo && !$variant->product->can_be_combo) {
            $isCombo = false;
        }

        $cart = session()->get('cart', []);
        
        // المفتاح لازم يعتمد على الكومبو كمان عشان نفصلهم
        $cartKey = $variant->product_id . '_' . $variant->id . '_' . ($isCombo ? 'combo' : 'normal');

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                "product_id" => $variant->product_id,
                "variant_id" => $variant->id,
                "name" => $variant->product->name,
                "variant_name" => $variant->variant_name,
                "quantity" => $quantity,
                "price" => $variant->price,
                "image" => $variant->product->image,
                "is_combo" => $isCombo,
                "combo_price" => $comboPrice,
                "can_be_combo" => $variant->product->can_be_combo // نحفظ الحالة عشان التبديل لاحقاً
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'تمت الكرشه بنجاح 😋');
    }

    // تحديث الكمية
    public function update(Request $request, $cartKey)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$cartKey])) {
            $quantity = (int) $request->input('quantity');
            if($quantity > 0) {
                $cart[$cartKey]['quantity'] = $quantity;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'تم تعديل الكمية');
            } else {
                // لو الكمية 0 أو أقل نحذف الصنف
                return $this->remove($cartKey);
            }
        }
        
        return redirect()->back();
    }

    // تحويل الساندوتش لـ كومبو أو العكس
    public function toggleCombo($cartKey)
    {
        $cart = session()->get('cart', []);

        if(!isset($cart[$cartKey])) return redirect()->back();

        $item = $cart[$cartKey];
        $isComboNew = !$item['is_combo'];
        
        // لو بيحاول يعمل كومبو والمنتج مش متاح كـ كومبو، نلغي العملية
        if ($isComboNew && isset($item['can_be_combo']) && !$item['can_be_combo']) {
             return redirect()->back()->with('error', 'هذا المنتج غير متاح كـ كومبو');
        }
        
        // المفتاح الجديد
        $newKey = $item['product_id'] . '_' . $item['variant_id'] . '_' . ($isComboNew ? 'combo' : 'normal');

        if(isset($cart[$newKey])) {
            // لو الصنف بالحالة الجديدة موجود، ندمجهم
            $cart[$newKey]['quantity'] += $item['quantity'];
            unset($cart[$cartKey]); // نحذف القديم
        } else {
            // لو مش موجود، نغير الحالة والمفتاح بس
            $cart[$newKey] = $item;
            $cart[$newKey]['is_combo'] = $isComboNew;
            unset($cart[$cartKey]);
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'تم تغيير حالة الكومبو');
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