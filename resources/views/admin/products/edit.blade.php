@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6">تعديل الوجبة: {{ $product->name }}</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-bold">اسم الوجبة</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block font-bold">القسم</label>
                    <select name="category_id" class="w-full border rounded-lg p-2">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-bold">وصف الوجبة</label>
                <textarea name="description" class="w-full border rounded-lg p-2">{{ $product->description }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block font-bold">تغيير الصورة (اختياري)</label>
                <input type="file" name="image" class="w-full">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="w-20 h-20 mt-2 rounded">
                @endif
            </div>

            <div class="bg-gray-50 p-4 rounded-xl mb-6">
                <h3 class="font-bold mb-4">الأحجام والأسعار الحالية</h3>
                <div id="variants-list">
                    @foreach($product->variants as $index => $variant)
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="variants[{{ $index }}][name]" value="{{ $variant->name }}" placeholder="اسم الحجم" class="w-1/2 border rounded p-2" required>
                        <input type="number" name="variants[{{ $index }}][price]" value="{{ $variant->price }}" placeholder="السعر" class="w-1/2 border rounded p-2" required>
                        <button type="button" class="text-red-500" onclick="this.parentElement.remove()">X</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-v" class="text-blue-600 font-bold mt-2">+ إضافة حجم آخر</button>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold">تحديث الوجبة ✨</button>
        </form>
    </div>
</div>

<script>
    let i = {{ $product->variants->count() }};
    document.getElementById('add-v').onclick = function() {
        let html = `<div class="flex gap-2 mb-2">
            <input type="text" name="variants[${i}][name]" placeholder="اسم الحجم" class="w-1/2 border rounded p-2" required>
            <input type="number" name="variants[${i}][price]" placeholder="السعر" class="w-1/2 border rounded p-2" required>
            <button type="button" class="text-red-500" onclick="this.parentElement.remove()">X</button>
        </div>`;
        document.getElementById('variants-list').insertAdjacentHTML('beforeend', html);
        i++;
    }
</script>
@endsection