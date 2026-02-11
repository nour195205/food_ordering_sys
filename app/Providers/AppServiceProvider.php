<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // مشاركة الإعدادات مع كل الـ Views عشان نقدر نستخدمها في الـ Footer والـ Navbar
            // بنستخدم try catch عشان لو لسه بنعمل migrate والجداول مش موجودة ميديناش ايرور
            if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                $siteSettings = \App\Models\SiteSetting::pluck('value', 'key')->toArray();
                \Illuminate\Support\Facades\View::share('siteSettings', $siteSettings);
            }
        } catch (\Exception $e) {
            // Silent fail during migration
        }
    }
}
