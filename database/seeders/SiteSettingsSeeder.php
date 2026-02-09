<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $settings = [
            ['key' => 'combo_price', 'value' => '45', 'type' => 'number'],
            ['key' => 'facebook_link', 'value' => 'https://facebook.com/smash', 'type' => 'text'],
            ['key' => 'restaurant_phone', 'value' => '01012345678', 'type' => 'text'],
            ['key' => 'restaurant_address', 'value' => 'دمنهور - شارع الصيدلية', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            \App\Models\SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
