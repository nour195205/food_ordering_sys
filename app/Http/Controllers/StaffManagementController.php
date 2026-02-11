<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffManagementController extends Controller
{
    // عرض قائمة المستخدمين (بدل الموظفين بس)
    public function index()
    {
        // بنجيب كل اليوزرز عشان نقدر نحول يوزر عادي لموظف
        // ممكن نعمل paginate عشان لو العدد كبير
        $users = User::paginate(10);
        return view('admin.staff.index', compact('users'));
    }

    // صفحة تعديل صلاحيات وم role اليوزر
    public function edit(User $staff) // $staff here is actually just a User model instance
    {
        // الصلاحيات المتاحة في السيستم
        $availablePermissions = [
            'manage_orders' => 'إدارة الطلبات',
            'manage_menu' => 'إدارة المنيو',
            'manage_products' => 'إدارة المنتجات',
            'manage_categories' => 'إدارة الأقسام',
            'view_reports' => 'عرض التقارير',
        ];

        // بنجيب صلاحيات اليوزر الحالية كمصفوفة بسيطة
        $userPermissions = $staff->staffPermissions->pluck('permission_key')->toArray();

        return view('admin.staff.edit', compact('staff', 'availablePermissions', 'userPermissions'));
    }

    // حفظ التعديلات
    public function update(Request $request, User $staff)
    {
        $request->validate([
            'role' => 'required|in:admin,staff,user',
            'permissions' => 'array', // مصفوفة فيها المفاتيح المختارة
        ]);

        DB::transaction(function () use ($request, $staff) {
            // 1. تحديث دور اليوزر
            $staff->update(['role' => $request->role]);

            // 2. تظبيط الصلاحيات
            // نمسح الصلاحيات القديمة الأول
            $staff->staffPermissions()->delete();

            // لو الدور الجديد staff، نضيف الصلاحيات المختارة
            if ($request->role === 'staff' && $request->has('permissions')) {
                foreach ($request->permissions as $permission) {
                    $staff->staffPermissions()->create([
                        'permission_key' => $permission
                    ]);
                }
            }
            // لو admin أو user مش محتاجين جدول صلاحيات (Admin ليه كل حاجة، User مالوش حاجة)
        });

        return redirect()->route('admin.staff.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح 🎉');
    }

    // حذف موظف (أو يوزر)
    public function destroy(User $staff)
    {
        // ممكن نكتفي بتغيير دوره لـ user بدل الحذف، بس حسب الطلب
        // هنا هنحذفه نهائي
        $staff->delete(); 
        return redirect()->back()->with('success', 'تم حذف المستخدم من النظام');
    }
}