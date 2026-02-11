@extends('layouts.naa')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">إدارة فريق العمل 👥</h1>
        <a href="{{ route('admin.staff.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold">إضافة موظف جديد</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4">
                        <div class="font-bold">{{ $user->name }}</div>
                        <div class="text-xs text-gray-400">{{ $user->email }}</div>
                    </td>
                    <td class="p-4">
                        @if($user->role === 'admin')
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">👑 أدمن</span>
                        @elseif($user->role === 'staff')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">👨‍🍳 موظف</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold">👤 مستخدم</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($user->role === 'admin')
                            <span class="text-xs text-gray-400">كامل الصلاحيات</span>
                        @elseif($user->role === 'staff')
                            <div class="flex flex-wrap gap-1 justify-center">
                                @forelse($user->staffPermissions as $perm)
                                    <span class="bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded text-[10px] border border-yellow-200">
                                        {{ str_replace('_', ' ', $perm->permission_key) }}
                                    </span>
                                @empty
                                    <span class="text-gray-300 text-xs">-</span>
                                @endforelse
                            </div>
                        @else
                            <span class="text-gray-300 text-xs">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.staff.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700 font-bold text-sm">تعديل</a>
                            
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.staff.destroy', $user->id) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا المستخدم نهائياً؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">حذف</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection