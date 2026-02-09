@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-2xl font-bold">تفاصيل الطلب #{{ $order->id }}</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 underline">رجوع للداشبورد</a>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-gray-400 text-sm mb-2">معلومات العميل</h3>
                <p class="font-bold">{{ $order->customer_name }}</p>
                <p class="text-sm">{{ $order->phone }}</p>
                <p class="text-sm text-gray-600">{{ $order->address }}</p>
            </div>
            <div class="text-left">
                <h3 class="text-gray-400 text-sm mb-2">حالة الطلب</h3>
                <span class="bg-black text-white px-3 py-1 rounded-full text-xs font-bold">{{ $order->status }}</span>
            </div>
        </div>

        <table class="w-full text-right mb-8">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">المنتج</th>
                    <th class="p-3 text-center">الكمية</th>
                    <th class="p-3">السعر</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($order->items as $item)
                <tr>
                    <td class="p-3">
                        <div class="font-bold">{{ $item->product->name }}</div>
                        <div class="text-xs text-gray-500">حجم: {{ $item->variant_name }} {{ $item->is_combo ? '(+ كومبو)' : '' }}</div>
                    </td>
                    <td class="p-3 text-center">{{ $item->quantity }}</td>
                    <td class="p-3 font-bold">{{ ($item->unit_price + ($item->is_combo ? $item->combo_price : 0)) * $item->quantity }} LE</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t pt-4 text-left">
            <span class="text-gray-500 ml-4">الإجمالي النهائي:</span>
            <span class="text-2xl font-bold text-red-600">{{ $order->total_price }} LE</span>
        </div>
    </div>
</div>
@endsection