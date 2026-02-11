@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg border">
        <h2 class="text-2xl font-bold mb-6">تعيين موظف جديد 📋</h2>
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block font-bold mb-1">الاسم</label>
                    <input type="text" name="name" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block font-bold mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block font-bold mb-1">كلمة المرور</label>
                    <input type="password" name="password" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block font-bold mb-1">الوظيفة (Role)</label>
                    <select name="role" class="w-full border rounded-lg p-2">
                        <option value="Manager">مدير</option>
                        <option value="Chef">شيف</option>
                        <option value="Cashier">كاشير</option>
                        <option value="Delivery">طيار</option>
                    </select>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="font-bold mb-2">الصلاحيات الإضافية:</p>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="can_manage_orders" class="rounded text-blue-600">
                        <span class="mr-2 ml-4">إدارة الطلبات</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="can_manage_menu" class="rounded text-blue-600">
                        <span class="mr-2">إدارة المنيو</span>
                    </label>
                </div>
                <button type="submit" class="w-full bg-black text-white py-3 rounded-xl font-bold">تفعيل الحساب</button>
            </div>
        </form>
    </div>
</div>
@endsection