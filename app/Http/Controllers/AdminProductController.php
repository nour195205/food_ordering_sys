<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants'])->latest();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->paginate(10)->appends(['search' => $search ?? null]);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string',
            'variants.*.price' => 'required|numeric',
        ]);

        // 1. تحديد السعر الأساسي من أول حجم (عشان المنيو)
        $basePrice = $request->variants[0]['price'];

        // 2. حفظ المنتج
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'base_price' => $basePrice,
            'image' => $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null,
            'is_active' => $request->has('is_active'),
            'can_be_combo' => $request->has('can_be_combo'),
        ]);

        // 3. حفظ كل الأحجام
        foreach ($request->variants as $variant) {
            $product->variants()->create([
                'variant_name' => $variant['name'], 
                'price'        => $variant['price'],
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة الوجبة بنجاح 🔥');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'variants' => 'required|array|min:1',
        'variants.*.name' => 'required|string',
        'variants.*.price' => 'required|numeric',
    ]);

    // 1. تحديث البيانات الأساسية والسعر (بناخد سعر أول فاريانت كـ base_price)
    $data = [
        'name' => $request->name,
        'category_id' => $request->category_id,
        'description' => $request->description,
        'base_price' => $request->variants[array_key_first($request->variants)]['price'],
        'is_active' => $request->has('is_active'),
        'can_be_combo' => $request->has('can_be_combo'),
    ];

    // 2. تحديث الصورة لو اترفعت واحدة جديدة
    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    $product->update($data);

    // 3. تحديث الأحجام (الطريقة الأضمن هي مسح القديم وإعادة الإضافة)
    $product->variants()->delete(); 
    foreach ($request->variants as $variantData) {
        $product->variants()->create([
            'variant_name' => $variantData['name'], 
            'price'        => $variantData['price'],
        ]);
    }

    return redirect()->route('admin.products.index')->with('success', 'تم تحديث الوجبة وأحجامها بنجاح!');
}

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return redirect()->back()->with('success', 'تم الحذف');
    }
}