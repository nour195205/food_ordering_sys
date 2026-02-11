@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">إدارة الطلبات 📝</h1>
        
        <!-- Filter Buttons (To be implemented later or ignored for now) -->
        <div class="flex gap-2">
            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-bold">الكل: {{ $orders->total() }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <span>✅</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 text-gray-500 text-sm">
                    <tr>
                        <th class="p-4 font-medium">رقم الطلب</th>
                        <th class="p-4 font-medium">العميل</th>
                        <th class="p-4 font-medium">المبلغ</th>
                        <th class="p-4 font-medium">الحالة</th>
                        <th class="p-4 font-medium">التاريخ</th>
                        <th class="p-4 font-medium text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold">#{{ $order->id }}</td>
                        <td class="p-4">
                            <div class="font-medium text-gray-800">{{ $order->customer_name }}</div>
                            <div class="text-xs text-gray-400">{{ $order->phone }}</div>
                        </td>
                        <td class="p-4 font-bold text-red-600">{{ $order->total_price }} LE</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded text-xs font-bold
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
                        </td>
                        <td class="p-4 text-gray-500 text-sm">{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                        <td class="p-4 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-block bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-blue-700 transition font-bold shadow-sm">
                                عرض التفاصيل 👁️
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-400">لا توجد طلبات حتى الآن.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
