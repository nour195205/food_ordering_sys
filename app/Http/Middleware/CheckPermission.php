<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // 1. لو مش مسجل دخول، ده بيحله الـ auth middleware بس زيادة تأكيد
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // 2. الأدمن بيعدي علطول
        if ($user->role === 'admin') {
            return $next($request);
        }

        // 3. لو staff، لازم يكون عنده الصلاحية المطلوبة
        if ($user->role === 'staff') {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        // 4. غير كده (يوزر عادي أو ستاف معهوش صلاحية) -> ممنوع
        abort(403, 'ليس لديك صلاحية للوصول لهذه الصفحة ⛔');
    }
}
