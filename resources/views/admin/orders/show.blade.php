@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4 max-w-5xl">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">تفاصيل الطلب #{{ $order->id }} 🧾</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700 font-bold">عودة للقائمة 🔙</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <span>✅</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info & Items -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h2 class="font-bold text-gray-800">محتويات الطلب 🍔</h2>
                </div>
                <div class="p-6">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0 last:pb-0">
                        <div class="flex gap-4 items-center">
                            <div class="bg-gray-100 w-12 h-12 rounded-lg flex items-center justify-center text-xl">
                                🍔
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $item->product ? $item->product->name : 'منتج محذوف' }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $item->quantity }} x {{ $item->price }} LE
                                    @if($item->is_combo) <span class="text-red-500 font-bold text-xs bg-red-50 px-2 py-0.5 rounded ml-2">كومبو +🍟🥤</span> @endif
                                </div>
                            </div>
                        </div>
                        <div class="font-bold text-gray-800">
                            {{ ($item->price + ($item->is_combo ? 30 : 0)) * $item->quantity }} LE
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Totals -->
                <div class="bg-gray-50 p-6 border-t border-gray-100">
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>المجموع الفرعي</span>
                        <span>{{ $order->total_price }} LE</span>
                    </div>
                    <!-- Delivery Fees (If added to DB, show here. For now assumed included) -->
                    <div class="flex justify-between text-xl font-bold text-gray-900 border-t border-gray-200 pt-2 mt-2">
                        <span>الإجمالي</span>
                        <span>{{ $order->total_price }} LE</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Status & Customer Info -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-800 mb-4 border-b pb-2">حالة الطلب 🚦</h2>
                
                <div class="mb-6 text-center">
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-bold w-full
                        {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order->status == 'preparing' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $order->status == 'delivering' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $order->status == 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ match($order->status) {
                            'pending' => '⏳ قيد الانتظار',
                            'preparing' => '🍳 في المطبخ',
                            'delivering' => '🛵 جاري التوصيل',
                            'delivered' => '✅ تم التسليم',
                            'cancelled' => '❌ ملغي',
                            default => $order->status
                        } }}
                    </span>
                </div>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <label class="block text-sm font-bold text-gray-700 mb-2">تحديث الحالة:</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg mb-4 focus:ring-blue-500 focus:border-blue-500 status-selector">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                        <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>🍳 في المطبخ</option>
                        <option value="delivering" {{ $order->status == 'delivering' ? 'selected' : '' }}>🛵 جاري التوصيل</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ تم التسليم</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ إلغاء الطلب</option>
                    </select>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        حفظ التغيير 💾
                    </button>
                </form>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-800 mb-4 border-b pb-2">بيانات العميل 👤</h2>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-gray-500">الاسم</div>
                        <div class="font-bold text-gray-800">{{ $order->customer_name }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">الهاتف</div>
                        <div class="font-bold text-gray-800" dir="ltr">{{ $order->phone }}</div>
                        <a href="tel:{{ $order->phone }}" class="text-blue-600 text-xs hover:underline">اتصال 📞</a>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">العنوان</div>
                        <div class="font-medium text-gray-700">{{ $order->address }}</div>
                    </div>
                    @if($order->notes)
                    <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-100">
                        <div class="text-xs text-yellow-700 font-bold mb-1">ملاحظات:</div>
                        <div class="text-sm text-gray-700">{{ $order->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
