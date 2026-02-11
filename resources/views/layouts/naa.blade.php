<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smash Burger Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ open: false, userMenuOpen: false }">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('menu.index') }}" class="text-2xl font-bold text-red-600 flex items-center gap-2">
                    🍔 Smash Burger
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('menu.index') }}" class="text-gray-700 hover:text-red-600 font-bold transition">المنيو</a>
                    
                    @auth
                        @if(Auth::user()->role === 'admin' || Auth::user()->hasPermission('view_reports'))
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-red-600 font-bold transition">لوحة التحكم ⚙️</a>
                        @endif
                        
                        @if(Auth::user()->role === 'admin' || Auth::user()->hasPermission('manage_categories'))
                            <a href="{{ url('admin/categories') }}" class="text-gray-700 hover:text-red-600 font-bold transition">التصنيفات</a>
                        @endif
                        
                        @if(Auth::user()->role === 'admin' || Auth::user()->hasPermission('manage_products'))
                            <a href="{{ url('admin/products') }}" class="text-gray-700 hover:text-red-600 font-bold transition">المنتجات</a>
                        @endif

                        <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-red-600 font-bold transition relative">
                            السلة 🛒
                            @if(session('cart'))
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-gray-700 font-bold hover:text-red-600 focus:outline-none py-2">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div class="absolute left-0 top-full w-48 pt-2 hidden group-hover:block z-50">
                                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 border-b border-gray-100">حسابي (Profile)</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-right px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600">
                                            تسجيل الخروج
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 font-bold transition">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-bold shadow-md hover:shadow-lg">إنشاء حساب</a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-4">
                    @auth
                        <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-red-600 font-bold transition relative">
                            🛒
                            @if(session('cart'))
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    @endauth

                    <button @click="open = !open" class="text-gray-700 focus:outline-none">
                        <svg x-show="!open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" class="md:hidden mt-4 space-y-2 border-t pt-4" style="display: none;">
                <a href="{{ route('menu.index') }}" class="block py-2 text-gray-700 hover:text-red-600 font-bold">المنيو 🍔</a>
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->hasPermission('view_reports'))
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-700 hover:text-red-600 font-bold">لوحة التحكم ⚙️</a>
                    @endif
                    
                    @if(Auth::user()->role === 'admin' || Auth::user()->hasPermission('manage_products'))
                        <a href="{{ url('admin/products') }}" class="block py-2 text-gray-700 hover:text-red-600 font-bold">المنتجات 📦</a>
                    @endif
                    <a href="{{ route('cart.index') }}" class="block py-2 text-gray-700 hover:text-red-600 font-bold">السلة 🛒</a>
                    <a href="{{ route('profile.edit') }}" class="block py-2 text-gray-700 hover:text-red-600 font-bold">حسابي 👤</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-right py-2 text-red-600 font-bold">
                            تسجيل الخروج 🚪
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-red-600 font-bold">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="block py-2 text-red-600 font-bold">إنشاء حساب جديد</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="mb-2">© {{ date('Y') }} Smash Burger. All rights reserved.</p>
            <p class="text-gray-400 text-sm">أفضل برجر في دمنهور 🍔❤️</p>
        </div>
    </footer>
</body>
</html>