<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get(); // بنجيب الأقسام ومعاها عدد المنتجات في كل قسم
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($request->all());

        return redirect()->back()->with('success', 'تم إضافة القسم بنجاح 🎉');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->all());

        return redirect()->back()->with('success', 'تم تحديث اسم القسم ✨');
    }

    public function destroy(Category $category)
    {
        // تأكد إن القسم مفيش فيه منتجات قبل المسح (اختياري بس أحسن للسيستم)
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'لا يمكن حذف قسم يحتوي على منتجات!');
        }

        $category->delete();
        return redirect()->back()->with('success', 'تم حذف القسم');
    }
}