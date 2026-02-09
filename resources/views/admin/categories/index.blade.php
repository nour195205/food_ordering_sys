@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">إدارة أقسام المنيو 📂</h1>

        <div class="bg-white p-6 rounded-2xl shadow-sm border mb-8">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-4">
                @csrf
                <div class="flex-1">
                    <input type="text" name="name" placeholder="اسم القسم الجديد (مثلاً: Extras)" class="w-full border rounded-lg p-2" required>
                </div>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold">إضافة</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border">
            <table class="w-full text-right">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="p-4">اسم القسم</th>
                        <th class="p-4 text-center">عدد المنتجات</th>
                        <th class="p-4 text-center">العمليات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-bold">{{ $category->name }}</td>
                        <td class="p-4 text-center">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                                {{ $category->products_count }} منتج
                            </span>
                        </td>
                        <td class="p-4 flex justify-center gap-4">
                            <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}')" class="text-blue-600">تعديل</button>
                            
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function editCategory(id, name) {
        let newName = prompt("تعديل اسم القسم:", name);
        if (newName && newName !== name) {
            let form = document.createElement('form');
            form.action = `/admin/categories/${id}`;
            form.method = 'POST';
            form.innerHTML = `
                @csrf
                @method('PUT')
                <input type="hidden" name="name" value="${newName}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection