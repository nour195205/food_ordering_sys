@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="max-w-3xl mx-auto">
        
        <!-- Header Section -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 text-center">
            <div class="w-24 h-24 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-4xl font-bold mx-auto mb-4">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h2 class="font-bold text-2xl mb-1">{{ $user->name }}</h2>
            <p class="text-gray-500 mb-6">{{ $user->email }}</p>
            
            <form method="POST" action="{{ route('logout') }}" class="inline-block">
                @csrf
                <button type="submit" class="bg-red-50 text-red-600 px-6 py-2 rounded-lg font-bold hover:bg-red-100 transition">
                    تسجيل الخروج 👋
                </button>
            </form>
        </div>

        <!-- Edit Profile Form -->
        <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
            <h3 class="text-xl font-bold mb-6 border-b pb-4">تعديل بياناتي ✏️</h3>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                     <label class="block text-gray-700 font-bold mb-2">الاسم بالكامل</label>
                     <input type="text" name="name" value="{{ $user->name }}" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 p-3" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">رقم التليفون الأساسي</label>
                        <input type="text" name="phone" value="{{ $user->profile->phone ?? '' }}" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 p-3" required>
                    </div>
                     <div>
                        <label class="block text-gray-700 font-bold mb-2">رقم تليفون إضافي (اختياري)</label>
                        <input type="text" name="alt_phone" value="{{ $user->profile->alt_phone ?? '' }}" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 p-3">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 font-bold mb-2">العنوان بالتفصيل</label>
                    <textarea name="address" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 p-3" rows="3" required>{{ $user->profile->address ?? '' }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">العنوان ده اللي هيوصلك عليه الأكل دايماً 🏠</p>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 transition shadow-lg transform hover:-translate-y-0.5">
                    حفظ التعديلات ✅
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
