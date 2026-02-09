@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">سلة المشتريات 🛒</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $key => $item)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-20 h-20 rounded-lg object-cover">
                    
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-900">{{ $item['name'] }}</h3>
                        <p class="text-sm text-gray-500">الحجم: {{ $item['variant_name'] }}</p>
                        <p class="font-bold text-red-600">{{ $item['price'] }} LE</p>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <form action="{{ route('cart.toggleCombo', $key) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1 rounded-full text-xs font-bold transition {{ $item['is_combo'] ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                                {{ $item['is_combo'] ? '✓ Combo Added' : '+ Make it Combo' }}
                            </button>
                        </form>
                        @if($item['is_combo'])
                            <span class="text-xs text-gray-400">+{{ $item['combo_price'] }} LE</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center border-gray-300 rounded-lg p-1 text-sm focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                        </form>
                        <form action="{{ route('cart.remove', $key) }}" method="POST">
                            @csrf
                            <button class="text-gray-400 hover:text-red-600 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 h-fit">
                <h3 class="text-xl font-bold mb-4 border-b pb-2">ملخص الطلب</h3>
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>إجمالي الأصناف</span>
                        <span>{{ $total }} LE</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>خدمة التوصيل</span>
                        <span class="text-green-600">حسب العنوان</span>
                    </div>
                    <hr>
                    <div class="flex justify-between text-2xl font-black text-gray-900">
                        <span>الإجمالي</span>
                        <span>{{ $total }} LE</span>
                    </div>
                </div>
                
                <a href="{{ route('checkout') }}" class="block w-full text-center bg-red-600 text-white py-3 rounded-xl font-bold hover:bg-red-700 transition shadow-lg shadow-red-200">
                    إتمام الطلب 🚀
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-400 text-xl mb-4">سلتك فاضية.. املأها ببرجر سماش! 🍔</p>
            <a href="{{ route('menu.index') }}" class="text-red-600 font-bold underline">ارجع للمنيو من هنا</a>
        </div>
    @endif
</div>
@endsection