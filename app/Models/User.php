<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // اليوزر ليه بروفايل واحد فيه بياناته
    public function profile() {
        return $this->hasOne(UserProfile::class);
    }

    // لو هو ستيف، هيكون ليه صلاحيات كتير
    public function staffPermissions() {
        return $this->hasMany(StaffPermission::class);
    }

    // Function سهلة تتشيك بيها على الصلاحية في الـ Blade أو الـ Controller
    public function hasPermission($permission) {
        return $this->staffPermissions()->where('permission_key', $permission)->exists();
    }
}
