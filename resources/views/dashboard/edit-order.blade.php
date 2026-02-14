@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-sm border">
        <h1 class="text-2xl font-bold mb-6">تعديل الأوردر #{{ $order->id }}</h1>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full text-right mb-6">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="p-3">المنتج</th>
                        <th class="p-3">الكمية</th>
                        <th class="p-3">السعر الحالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td class="p-3">
                            <span class="font-bold">{{ $item->product->name }}</span>
                            <span class="text-xs text-gray-500">({{ $item->variant_name }})</span>
                        </td>
                        <td class="p-3">
                            <input type="number" name="items[{{ $item->id }}][quantity]" value="{{ old('items.'.$item->id.'.quantity', $item->quantity) }}" class="w-20 border rounded p-1">
                        </td>
                        <td class="p-3">{{ ($item->unit_price + ($item->is_combo ? $item->combo_price : 0)) * $item->quantity }} LE</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-between">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold">حفظ التغييرات</button>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 px-6 py-2 rounded-lg">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection