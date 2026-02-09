@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold mb-6">تفاصيل الشحن 🚚</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <form action="{{ route('order.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow" id="checkoutForm">
            @csrf
            
            @php
                $userProfile = auth()->user()->profile;
            @endphp

            @if($userProfile)
            <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h4 class="font-bold text-blue-800 mb-2">بيانات التوصيل 📍</h4>
                
                <div class="flex items-center mb-2">
                    <input type="radio" id="use_saved" name="delivery_option" value="saved" class="w-4 h-4 text-blue-600 focus:ring-blue-500" checked onchange="toggleDeliveryOptions()">
                    <label for="use_saved" class="mr-2 text-sm font-medium text-gray-900 cursor-pointer">
                        استخدام البيانات المحفوظة
                    </label>
                </div>
                <div class="mr-6 text-sm text-gray-600 mb-4">
                    <p><strong>العنوان:</strong> {{ $userProfile->address }}</p>
                    <p><strong>التليفون:</strong> {{ $userProfile->phone }}</p>
                    <input type="hidden" name="saved_address" value="{{ $userProfile->address }}">
                    <input type="hidden" name="saved_phone" value="{{ $userProfile->phone }}">
                </div>

                <div class="flex items-center">
                    <input type="radio" id="use_new" name="delivery_option" value="new" class="w-4 h-4 text-blue-600 focus:ring-blue-500" onchange="toggleDeliveryOptions()">
                    <label for="use_new" class="mr-2 text-sm font-medium text-gray-900 cursor-pointer">
                        استخدام بيانات جديدة
                    </label>
                </div>
            </div>
            @endif

            <div class="mb-4">
                <label>الاسم بالكامل</label>
                <input type="text" name="customer_name" value="{{ auth()->user()->name }}" class="w-full border-gray-300 rounded-lg" required>
            </div>

            <div id="new_details_section" class="{{ $userProfile ? 'hidden' : '' }}">
                <div class="mb-4">
                    <label>رقم التليفون</label>
                    <input type="text" name="phone" id="phone_input" class="w-full border-gray-300 rounded-lg" placeholder="رقمك عشان نكلمك لما نوصل" {{ $userProfile ? '' : 'required' }}>
                </div>
                <div class="mb-4">
                    <label>العنوان بالتفصيل (دمنهور)</label>
                    <textarea name="address" id="address_input" class="w-full border-gray-300 rounded-lg" rows="3" {{ $userProfile ? '' : 'required' }}></textarea>
                </div>
            </div>
            
            <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg font-bold hover:bg-red-700">
                تأكيد الطلب الآن 🍔
            </button>
        </form>

        <script>
            function toggleDeliveryOptions() {
                const useSaved = document.getElementById('use_saved').checked;
                const newDetailsSection = document.getElementById('new_details_section');
                const phoneInput = document.getElementById('phone_input');
                const addressInput = document.getElementById('address_input');

                if (useSaved) {
                    newDetailsSection.classList.add('hidden');
                    phoneInput.removeAttribute('required');
                    addressInput.removeAttribute('required');
                    phoneInput.value = ''; // Clear value to ensure backend knows we are using saved
                    addressInput.value = '';
                } else {
                    newDetailsSection.classList.remove('hidden');
                    phoneInput.setAttribute('required', 'required');
                    addressInput.setAttribute('required', 'required');
                }
            }
        </script>

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