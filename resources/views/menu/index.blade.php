@extends('layouts.naa')

@section('content')
@section('content')
    <div class="max-w-md mx-auto mt-8 mb-10 px-4">
        <div class="relative">
            <input type="text" id="searchInput" 
                   class="w-full p-4 pl-12 rounded-full border-2 border-red-100 focus:border-red-500 focus:ring-red-200 outline-none shadow-sm transition"
                   placeholder="بتدور على أكلة معينة؟ 🍔 ...">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div id="menu-container">
    @forelse($categories as $category)
        <div class="category-section">
            <h2 class="text-3xl font-bold text-center my-8 text-red-600 uppercase tracking-widest category-title">
                {{ $category->name }}
            </h2>

            <div class="flex flex-wrap justify-center gap-8 products-grid">
                @foreach($category->products as $product)
                    <div class="max-w-sm bg-white border border-gray-200 rounded-2xl shadow-lg overflow-hidden product-item transition-all duration-300" data-name="{{ $product->name }}">
                        <img class="w-full h-56 object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" />
                        
                        <div class="p-5">
                            <h5 class="text-2xl font-bold tracking-tight text-gray-900">{{ $product->name }}</h5>
                            <p class="mb-3 font-normal text-gray-700">{{ $product->description }}</p>

                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                @foreach($product->variants as $variant)
                                    <div class="flex justify-between border-b border-gray-200 py-1 last:border-0">
                                        <span class="text-gray-600">{{ $variant->variant_name }}</span>
                                        <span class="font-bold text-gray-900">{{ $variant->price }} LE</span>
                                    </div>
                                @endforeach
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <select name="variant_id" class="w-full mb-3 rounded-lg border-gray-300">
                                    @foreach($product->variants as $variant)
                                        <option value="{{ $variant->id }}">{{ $variant->variant_name }} - {{ $variant->price }} LE</option>
                                    @endforeach
                                </select>

                                <div class="flex items-center gap-3 mb-3">
                                    <div class="{{ $product->can_be_combo ? 'w-1/3' : 'w-full' }}">
                                        <label class="text-xs text-gray-500 block mb-1">الكمية</label>
                                        <input type="number" name="quantity" value="1" min="1" class="w-full rounded-lg border-gray-300 text-center p-2">
                                    </div>
                                    
                                    @if($product->can_be_combo)
                                    <div class="w-2/3">
                                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 rounded-lg p-2 h-[42px] mt-[18px]">
                                            <input type="checkbox" name="is_combo" class="w-5 h-5 text-red-600 rounded focus:ring-red-500 accent-red-600">
                                            <span class="text-sm font-bold text-gray-700">كومبو (+{{ $comboPrice }}) 🍟🥤</span>
                                        </label>
                                    </div>
                                    @endif
                                </div>

                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 font-bold">
                                    أضف للسلة
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-10" id="empty-message">
            <h2 class="text-2xl font-bold text-gray-600">لا توجد أصناف في القائمة حالياً</h2>
            <p class="text-gray-500 mt-2">يرجى إضافة تصنيفات ومنتجات من لوحة التحكم.</p>
        </div>
    @endforelse
    </div>
    
    <div id="no-results-message" class="hidden text-center py-10">
        <h2 class="text-2xl font-bold text-gray-600">مفيش أكل بالاسم ده 😔</h2>
        <p class="text-gray-500 mt-2">جرب تدور على حاجة تانية!</p>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchText = e.target.value.toLowerCase();
            const categories = document.querySelectorAll('.category-section');
            let hasAnyVisibleProduct = false;

            categories.forEach(category => {
                const products = category.querySelectorAll('.product-item');
                let hasVisibleProductsInCategory = false;

                products.forEach(product => {
                    const productName = product.getAttribute('data-name').toLowerCase();
                    if (productName.includes(searchText)) {
                        product.style.display = 'block';
                        hasVisibleProductsInCategory = true;
                        hasAnyVisibleProduct = true;
                    } else {
                        product.style.display = 'none';
                    }
                });

                // Toggle category visibility
                if (hasVisibleProductsInCategory) {
                    category.style.display = 'block';
                } else {
                    category.style.display = 'none';
                }
            });

            // Toggle "No Results" message
            const noResultsMessage = document.getElementById('no-results-message');
            const emptyMessage = document.getElementById('empty-message');

            if (!hasAnyVisibleProduct && !emptyMessage) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }
        });
    </script>
@endsection