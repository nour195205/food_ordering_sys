@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold mb-6">تفاصيل الشحن 🚚</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <form action="{{ route('order.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow">
            @csrf
            <div class="mb-4">
                <label>الاسم بالكامل</label>
                <input type="text" name="customer_name" value="{{ auth()->user()->name }}" class="w-full border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label>رقم التليفون</label>
                <input type="text" name="phone" class="w-full border-gray-300 rounded-lg" placeholder="رقمك عشان نكلمك لما نوصل" required>
            </div>
            <div class="mb-4">
                <label>العنوان بالتفصيل (دمنهور)</label>
                <textarea name="address" class="w-full border-gray-300 rounded-lg" rows="3" required></textarea>
            </div>
            <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg font-bold hover:bg-red-700">
                تأكيد الطلب الآن 🍔
            </button>
        </form>

        <div class="bg-gray-50 p-6 rounded-xl border">
            <h3 class="font-bold mb-4 border-b pb-2">ملخص الحساب</h3>
            <div class="flex justify-between text-xl font-bold">
                <span>الإجمالي الكلي:</span>
                <span class="text-red-600">{{ $total }} LE</span>
            </div>
        </div>
    </div>
</div>
@endsection