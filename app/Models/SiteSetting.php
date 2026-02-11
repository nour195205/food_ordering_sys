<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    /**
     * Get a setting value by key, or return a default.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Check if a boolean setting is true (e.g., store_open).
     */
    public static function isTrue($key)
    {
        return filter_var(self::get($key, false), FILTER_VALIDATE_BOOLEAN);
    }
}