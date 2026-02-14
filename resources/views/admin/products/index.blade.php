@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">المنيو (Products) 📋</h1>
        
        <div class="flex gap-4">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث عن وجبة..." class="border rounded-lg px-4 py-2">
                <button type="submit" class="bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">بحث</button>
            </form>
            <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-6 py-2 rounded-lg">إضافة وجبة</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border">
        <table class="w-full text-right">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4">الوجبة</th>
                    <th class="p-4">الأحجام المتاحة</th>
                    <th class="p-4">القسم</th>
                    <th class="p-4">العمليات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('storage/'.$product->image) }}" class="w-12 h-12 rounded-lg object-cover">
                            <span class="font-bold">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="p-4">
                        @foreach($product->variants as $v)
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $v->name }}: {{ $v->price }} LE</span>
                        @endforeach
                    </td>
                    <td class="p-4 text-gray-500">{{ $product->category->name }}</td>
                    <td class="p-4">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 ml-4">تعديل</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('حذف؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection