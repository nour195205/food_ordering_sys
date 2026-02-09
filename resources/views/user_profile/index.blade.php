@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-3">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h2 class="font-bold text-xl">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                </div>
                <nav class="space-y-2">
                    <a href="#" class="block px-4 py-2 bg-red-50 text-red-600 rounded-lg font-bold text-sm">طلباتي السابقة</a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg text-sm">إعدادات الحساب (Breeze)</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-right px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg text-sm">تسجيل الخروج</button>
                    </form>
                </nav>
            </div>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" class="mb-8 p-4 bg-gray-50 rounded-lg">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label>رقم التليفون</label>
                    <input type="text" name="phone" value="{{ $user->profile->phone ?? '' }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label>العنوان بالتفصيل</label>
                    <input type="text" name="address" value="{{ $user->profile->address ?? '' }}" class="w-full border rounded p-2" required>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded">حفظ البيانات</button>
        </form>
        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold mb-6">سجل الطلبات 🍔</h3>

                @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                    <div class="border rounded-xl p-4 hover:border-red-200 transition">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-lg">رقم الطلب: #{{ $order->id }}</span>
                            <span class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                الحالة:
                                <span class="font-bold {{ $order->status == 'pending' ? 'text-yellow-600' : 'text-green-600' }}">
                                    {{ $order->status == 'pending' ? 'جاري التحضير' : 'تم التوصيل' }}
                                </span>
                            </div>
                            <div class="font-bold text-red-600">{{ $order->total_price }} LE</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-10">
                    <p class="text-gray-400">مفيش طلبات قديمة.. جعت؟</p>
                    <a href="{{ route('menu.index') }}" class="text-red-600 font-bold">اطلب برجر دلوقتي 🚀</a>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
