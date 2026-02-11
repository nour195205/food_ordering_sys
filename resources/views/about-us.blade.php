@extends('layouts.naa')

@section('content')
<div class="bg-red-600 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">من نحن 🍔</h1>
        <p class="text-xl md:text-2xl text-red-100">تعرف على قصة Smash Burger</p>
    </div>
</div>

<div class="container mx-auto px-4 py-16 max-w-5xl">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- معلومات المطعم -->
        <div class="space-y-6">
            <h2 class="text-3xl font-bold text-gray-800">أهلاً بك في {{ $siteSettings['site_name'] ?? 'Smash Burger' }} ❤️</h2>
            <p class="text-gray-600 leading-relaxed text-lg">
                نحن نقدم أفضل تجربة برجر في المدينة. نستخدم أجود المكونات الطازجة لنصنع لك برجر لا يُقاوم.
                هدفنا هو تقديم طعام بجودة عالية وخدمة ممتازة تجعلك تعود إلينا دائماً.
            </p>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 mb-4">تواصل معنا 📞</h3>
                
                @if(!empty($siteSettings['address']))
                <div class="flex items-start gap-3 mb-4">
                    <span class="text-2xl">📍</span>
                    <div>
                        <div class="font-bold text-gray-700">العنوان</div>
                        <p class="text-gray-600">{{ $siteSettings['address'] }}</p>
                    </div>
                </div>
                @endif

                @php
                    $phones = json_decode($siteSettings['contact_numbers'] ?? '[]', true);
                    // Fallback for old single phone
                    if(empty($phones) && !empty($siteSettings['phone'])) {
                        $phones = [['label' => 'المطعم', 'number' => $siteSettings['phone']]];
                    }
                @endphp

                @if(!empty($phones))
                <div class="flex items-start gap-3 mb-4">
                    <span class="text-2xl">📱</span>
                    <div>
                        <div class="font-bold text-gray-700">الهاتف</div>
                        <div class="space-y-1">
                            @foreach($phones as $phone)
                                <div class="flex justify-between w-full gap-4">
                                    <span class="text-gray-600">{{ $phone['number'] }}</span>
                                    <span class="text-xs bg-gray-200 px-2 py-0.5 rounded text-gray-500">{{ $phone['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex items-start gap-3">
                    <span class="text-2xl">🕒</span>
                    <div>
                        <div class="font-bold text-gray-700">حالة العمل</div>
                        @if(($siteSettings['store_open'] ?? 'true') === 'true')
                            <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">مفتوح الآن ✅</span>
                        @else
                            <span class="inline-block bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-bold">مغلق حالياً ⛔</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- سوشيال ميديا -->
            @php
                $socials = json_decode($siteSettings['social_links'] ?? '[]', true);
                // Fallback for old fields
                if(empty($socials)) {
                   if(!empty($siteSettings['facebook_link'])) $socials[] = ['platform' => 'Facebook', 'link' => $siteSettings['facebook_link']];
                   if(!empty($siteSettings['instagram_link'])) $socials[] = ['platform' => 'Instagram', 'link' => $siteSettings['instagram_link']];
                }
            @endphp
            
            @if(!empty($socials))
            <div class="mt-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">تابعنا على السوشيال ميديا</h3>
                <div class="flex gap-4">
                    @foreach($socials as $social)
                        <a href="{{ $social['link'] }}" target="_blank" class="bg-white border border-gray-200 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-50 hover:border-gray-300 hover:text-red-600 transition shadow-sm font-bold text-center min-w-[120px]">
                            {{ $social['platform'] }} ↗
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- صورة أو خريطة -->
        <div class="relative">
            <div class="aspect-square bg-gray-100 rounded-3xl overflow-hidden shadow-2xl rotate-3 hover:rotate-0 transition duration-500">
                <!-- صورة توضيحية (ممكن تبقى ديناميكية برضه لو حبينا نرفع صور) -->
                <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=1000&auto=format&fit=crop" alt="Burger" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</div>
@endsection
