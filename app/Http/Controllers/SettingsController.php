<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SiteSetting;

class SettingsController extends Controller
{
    // عرض صفحة الإعدادات
    public function index()
    {
        // بنجيب كل الإعدادات ونحولها لـ Key-Value Array عشان سهولة الاستخدام في الـ View
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    // حفظ التعديلات
    public function update(Request $request)
    {
        // البيانات اللي جاية من الفورم
        $data = $request->except(['_token', '_method']);

        // معالجة المصفوفات (JSON)
        // لو مبعوت social_links أو contact_numbers كـ array، نحولهم JSON
        if ($request->has('social_links')) {
            $data['social_links'] = json_encode(array_values($request->social_links));
        }
        
        if ($request->has('contact_numbers')) {
            $data['contact_numbers'] = json_encode(array_values($request->contact_numbers));
        }

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // لو الـ checkbox مش مبعوت (عشان لو مش معلم عليه مش بيتبعت)، نخليه false
        if (!$request->has('store_open')) {
            SiteSetting::updateOrCreate(['key' => 'store_open'], ['value' => 'false']);
        } else {
             SiteSetting::updateOrCreate(['key' => 'store_open'], ['value' => 'true']);
        }

        return redirect()->back()->with('success', 'تم تحديث إعدادات الموقع بنجاح ⚙️');
    }
}
