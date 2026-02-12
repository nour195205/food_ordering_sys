@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6">إضافة وجبة جديدة 🍔</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-bold">اسم الوجبة</label>
                    <input type="text" name="name" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block font-bold">القسم</label>
                    <select name="category_id" class="w-full border rounded-lg p-2">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-bold">وصف الوجبة</label>
                <textarea name="description" class="w-full border rounded-lg p-2"></textarea>
            </div>

            <div class="mb-6">
                <label class="block font-bold">صورة الوجبة</label>
                <input type="file" name="image" class="w-full">
            </div>

            <div class="flex gap-6 mb-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" class="w-5 h-5" checked>
                    <span class="font-bold">متاح للطلب (Active)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="can_be_combo" class="w-5 h-5" checked>
                    <span class="font-bold">متاح كـ كومبو (Combo Available)</span>
                </label>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl mb-6">
                <h3 class="font-bold mb-4">الأحجام والأسعار (Variants)</h3>
                <div id="variants-list">
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="variants[0][name]" placeholder="مثلاً: سنجل" class="w-1/2 border rounded p-2" required>
                        <input type="number" name="variants[0][price]" placeholder="السعر" class="w-1/2 border rounded p-2" required>
                    </div>
                </div>
                <button type="button" id="add-v" class="text-blue-600 font-bold mt-2">+ إضافة حجم آخر</button>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-bold">حفظ ونشر الوجبة</button>
        </form>
    </div>
</div>

<script>
    let i = 1;
    document.getElementById('add-v').onclick = function() {
        let html = `<div class="flex gap-2 mb-2">
            <input type="text" name="variants[${i}][name]" placeholder="اسم الحجم" class="w-1/2 border rounded p-2">
            <input type="number" name="variants[${i}][price]" placeholder="السعر" class="w-1/2 border rounded p-2">
            <button type="button" class="text-red-500" onclick="this.parentElement.remove()">X</button>
        </div>`;
        document.getElementById('variants-list').insertAdjacentHTML('beforeend', html);
        i++;
    }
</script>
@endsection