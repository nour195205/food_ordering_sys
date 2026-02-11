<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPermission extends Model
{
    // الخانات المسموح بالكتابة فيها
    // الخانات المسموح بالكتابة فيها
    protected $fillable = [
        'user_id', 
        'permission_key'
    ];

    // علاقة عكسية: الصلاحية دي بتاعة مين؟
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}