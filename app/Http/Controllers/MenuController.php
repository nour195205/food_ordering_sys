<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // بنجيب كل التصنيفات ومعاها المنتجات والـ variants عشان نوفر في الـ Queries (Eager Loading)
        $categories = Category::with(['products.variants'])->get();

        return view('menu.index', compact('categories'));
    }

    public function show(Product $product)
    {
        // لو عايز صفحة مخصصة لكل ساندوتش
        $product->load('variants');
        return view('menu.show', compact('product'));
    }
}