<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nama_lengkap',
        'username',
        'email',
        'password',
        'nip_nik',
        'no_hp',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function hasRole(string|array $roleName): bool
    {
        if (is_array($roleName)) {
            return $this->roles->pluck('nama_role')->intersect($roleName)->isNotEmpty();
        }
        return $this->roles->contains('nama_role', $roleName);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isGuru(): bool
    {
        return $this->hasRole('guru') || $this->hasRole('wali_kelas');
    }

    public function isWaliKelas(): bool
    {
        return $this->hasRole('wali_kelas');
    }
}
