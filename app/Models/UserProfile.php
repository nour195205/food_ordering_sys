<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    // الخانات اللي مسموح نكتب فيها
    protected $fillable = ['user_id', 'phone', 'address'];

    // علاقة عكسية: البروفايل ده بتاع مين؟
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}