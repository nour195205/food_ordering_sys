@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4 max-w-3xl">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">تعديل بيانات المستخدم ✏️</h1>
        <a href="{{ route('admin.staff.index') }}" class="text-gray-500 hover:text-gray-700">عودة للقائمة</a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border p-8">
        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- بيانات أساسية (للقراءة فقط عشان ميتلعبش فيها من هنا) -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم المستخدم</label>
                    <input type="text" value="{{ $staff->name }}" disabled class="w-full bg-gray-100 border-gray-300 rounded-lg py-2 px-4 text-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                    <input type="email" value="{{ $staff->email }}" disabled class="w-full bg-gray-100 border-gray-300 rounded-lg py-2 px-4 text-gray-500">
                </div>
            </div>

            <hr class="my-6 border-gray-100">

            <!-- تحديد الدور -->
            <div class="mb-8">
                <label class="block text-lg font-bold text-gray-800 mb-3">الدور الوظيفي</label>
                <div class="grid grid-cols-3 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="user" class="peer sr-only" {{ $staff->role === 'user' ? 'checked' : '' }} onchange="togglePermissions()">
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-gray-500 peer-checked:bg-gray-50 hover:bg-gray-50 transition-all text-center">
                            <div class="text-2xl mb-2">👤</div>
                            <div class="font-bold text-gray-700">مستخدم عادي</div>
                            <div class="text-xs text-gray-400 mt-1">بدون صلاحيات إدارية</div>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="staff" class="peer sr-only" {{ $staff->role === 'staff' ? 'checked' : '' }} onchange="togglePermissions()">
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 transition-all text-center">
                            <div class="text-2xl mb-2">👨‍🍳</div>
                            <div class="font-bold text-gray-700">موظف (Staff)</div>
                            <div class="text-xs text-gray-400 mt-1">صلاحيات محددة</div>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="admin" class="peer sr-only" {{ $staff->role === 'admin' ? 'checked' : '' }} onchange="togglePermissions()">
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50 transition-all text-center">
                            <div class="text-2xl mb-2">👑</div>
                            <div class="font-bold text-gray-700">مدير (Admin)</div>
                            <div class="text-xs text-gray-400 mt-1">كامل الصلاحيات</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- قائمة الصلاحيات (يظهر فقط لو اخترنا Staff) -->
            <div id="permissions-section" class="mb-8 {{ $staff->role === 'staff' ? '' : 'hidden' }}">
                <label class="block text-lg font-bold text-gray-800 mb-3">تخصيص الصلاحيات</label>
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($availablePermissions as $key => $label)
                        <label class="flex items-center space-x-3 space-x-reverse cursor-pointer p-3 rounded-lg hover:bg-white transition-colors">
                            <input type="checkbox" name="permissions[]" value="{{ $key }}" 
                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300"
                                {{ in_array($key, $userPermissions) ? 'checked' : '' }}>
                            <span class="text-gray-700 font-medium select-none">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.staff.index') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-600 font-bold hover:bg-gray-50">إلغاء</a>
                <button type="submit" class="px-8 py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-1">حفظ التغييرات</button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePermissions() {
        const role = document.querySelector('input[name="role"]:checked').value;
        const section = document.getElementById('permissions-section');
        
        if (role === 'staff') {
            section.classList.remove('hidden');
        } else {
            section.classList.add('hidden');
        }
    }
</script>
@endsection
