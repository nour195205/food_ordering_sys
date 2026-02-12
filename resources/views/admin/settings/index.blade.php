@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4 max-w-4xl">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">إعدادات الموقع ⚙️</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">عودة للوحة التحكم</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <span>✅</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border p-8">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <!-- حالة المطعم -->
            <div class="mb-8 p-6 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-1">حالة المطعم (Status) 🟢🔴</h2>
                        <p class="text-gray-500 text-sm">عند إغلاق المطعم، لن يتمكن العملاء من إتمام الطلبات.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="store_open" value="true" class="sr-only peer" {{ ($settings['store_open'] ?? 'true') === 'true' ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none ring-4 ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-500"></div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- بيانات التواصل -->
                <!-- بيانات التواصل -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">بيانات التواصل 📞</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">اسم المطعم</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Smash Burger' }}" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">العنوان</label>
                        <textarea name="address" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $settings['address'] ?? '' }}</textarea>
                    </div>

                    <!-- أرقام الهواتف (Dynamic) -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">أرقام التواصل</label>
                        <div id="phones-container" class="space-y-2">
                            @php
                                $phones = json_decode($settings['contact_numbers'] ?? '[]', true);
                                if(empty($phones)) $phones = [['label' => 'Hotline', 'number' => '']];
                            @endphp
                            @foreach($phones as $index => $phone)
                            <div class="flex gap-2 phone-row">
                                <input type="text" name="contact_numbers[{{ $index }}][label]" value="{{ $phone['label'] ?? '' }}" placeholder="اللقب (مثل: Hotline)" class="w-1/3 border-gray-300 rounded-lg text-sm">
                                <input type="text" name="contact_numbers[{{ $index }}][number]" value="{{ $phone['number'] ?? '' }}" placeholder="الرقم" class="w-2/3 border-gray-300 rounded-lg text-sm">
                                <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 px-2">✕</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addPhoneRow()" class="mt-2 text-sm text-blue-600 hover:underline">+ إضافة رقم آخر</button>
                    </div>
                </div>

                <!-- إعدادات التشغيل -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">إعدادات التشغيل 🚀</h3>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">مصاريف التوصيل (EGP)</label>
                            <input type="number" name="delivery_fees" value="{{ $settings['delivery_fees'] ?? '20' }}" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">سعر الكومبو (EGP)</label>
                            <input type="number" name="combo_price" value="{{ $settings['combo_price'] ?? '45' }}" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- روابط السوشيال (Dynamic) -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">روابط السوشيال ميديا</label>
                        <div id="social-container" class="space-y-2">
                            @php
                                $socials = json_decode($settings['social_links'] ?? '[]', true);
                                if(empty($socials)) $socials = [['platform' => 'Facebook', 'link' => '']];
                            @endphp
                            @foreach($socials as $index => $social)
                            <div class="flex gap-2 social-row">
                                <input type="text" name="social_links[{{ $index }}][platform]" value="{{ $social['platform'] ?? '' }}" placeholder="المنصة (Facebook)" class="w-1/3 border-gray-300 rounded-lg text-sm">
                                <input type="url" name="social_links[{{ $index }}][link]" value="{{ $social['link'] ?? '' }}" placeholder="الرابط" class="w-2/3 border-gray-300 rounded-lg text-sm text-left" dir="ltr">
                                <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 px-2">✕</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addSocialRow()" class="mt-2 text-sm text-blue-600 hover:underline">+ إضافة رابط آخر</button>
                    </div>
                </div>
            </div>

            <script>
                function removeRow(btn) {
                    btn.closest('div').remove();
                }

                function addPhoneRow() {
                    const container = document.getElementById('phones-container');
                    const index = container.children.length;
                    const html = `
                        <div class="flex gap-2 phone-row">
                            <input type="text" name="contact_numbers[${index}][label]" placeholder="اللقب" class="w-1/3 border-gray-300 rounded-lg text-sm">
                            <input type="text" name="contact_numbers[${index}][number]" placeholder="الرقم" class="w-2/3 border-gray-300 rounded-lg text-sm">
                            <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 px-2">✕</button>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', html);
                }

                function addSocialRow() {
                    const container = document.getElementById('social-container');
                    const index = container.children.length;
                    const html = `
                        <div class="flex gap-2 social-row">
                            <input type="text" name="social_links[${index}][platform]" placeholder="المنصة" class="w-1/3 border-gray-300 rounded-lg text-sm">
                            <input type="url" name="social_links[${index}][link]" placeholder="الرابط" class="w-2/3 border-gray-300 rounded-lg text-sm text-left" dir="ltr">
                            <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 px-2">✕</button>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', html);
                }
            </script>

            <div class="mt-8 pt-6 border-t flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-1">
                    حفظ الإعدادات 💾
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
