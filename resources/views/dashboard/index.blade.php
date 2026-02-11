@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">لوحة التحكم (Admin Dashboard) 🚀</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
            <div class="text-gray-500 text-sm font-medium">إجمالي المبيعات</div>
            <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_sales'], 2) }} LE</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-yellow-500">
            <div class="text-gray-500 text-sm font-medium">طلبات قيد الانتظار</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['new_orders'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-500">
            <div class="text-gray-500 text-sm font-medium">إجمالي المستخدمين</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-purple-500">
            <div class="text-gray-500 text-sm font-medium">عدد الوجبات</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_items'] }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h2 class="text-xl font-bold text-gray-800">إدارة الطلبات الأخيرة 🍔</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 text-gray-500 text-sm">
                    <tr>
                        <th class="p-4 font-medium">رقم الطلب</th>
                        <th class="p-4 font-medium">العميل</th>
                        <th class="p-4 font-medium">المبلغ</th>
                        <th class="p-4 font-medium">تحديث الحالة</th>
                        <th class="p-4 font-medium">التاريخ</th>
                        <th class="p-4 font-medium text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold">#{{ $order->id }}</td>
                        <td class="p-4">
                            <div class="font-medium text-gray-800">{{ $order->customer_name }}</div>
                            <div class="text-xs text-gray-400">{{ $order->phone }}</div>
                        </td>
                        <td class="p-4 font-bold text-red-600">{{ $order->total_price }} LE</td>

                        <td class="p-4">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg p-1 w-full
                                    {{ $order->status == 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                    {{ $order->status == 'preparing' ? 'bg-blue-50 text-blue-700' : '' }}
                                    {{ $order->status == 'delivering' ? 'bg-purple-50 text-purple-700' : '' }}
                                    {{ $order->status == 'delivered' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $order->status == 'cancelled' ? 'bg-red-50 text-red-700' : '' }}">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                                    <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>🍳 في المطبخ</option>
                                    <option value="delivering" {{ $order->status == 'delivering' ? 'selected' : '' }}>🛵 جاري التوصيل</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ تم الوصول</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ ملغي</option>
                                </select>
                            </form>
                        </td>

                        <td class="p-4 text-gray-500 text-sm">{{ $order->created_at->diffForHumans() }}</td>

                        <td class="p-4 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-block bg-blue-600 text-white px-4 py-1.5 rounded-lg text-xs hover:bg-blue-700 transition font-bold shadow-sm">
                                عرض / تعديل 👁️
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($recentOrders->isEmpty())
        <div class="p-10 text-center text-gray-400">لا توجد طلبات حالياً.</div>
        @endif
    </div>
</div>
@endsection
