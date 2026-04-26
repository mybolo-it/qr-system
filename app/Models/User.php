<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'company_id', // Tambahan untuk memetakan user ke perusahaan tertentu
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

    // --- RELASI ---

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // --- PENGECEKAN ROLE ---

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'company_admin']);
    }

    public function isGlobalHR()
    {
        return in_array($this->role, ['superadmin', 'hr_global']);
    }

    // Validasi tambahan untuk mengakomodasi assignment layout dashboard level manajemen
    public function isGM()
    {
        return $this->role === 'GM';
    }

    public function isManager()
    {
        return $this->role === 'Manager';
    }
}
