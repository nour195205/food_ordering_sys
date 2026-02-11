<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // الإعدادات już مشاركة في الـ AppServiceProvider باسم $siteSettings
        // بس ممكن نحتاج نبعتها تاني لو المنطق هنا معقد، لكن ده كافي
        return view('about-us');
    }
}
