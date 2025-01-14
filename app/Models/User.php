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
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    protected $table = "tm_user";
    protected $fillable = [
        'user_id',
        'user_name',
        'user_pass',
        'user_hak',
        'user_sts',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'user_pass',
        // 'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'user_pass' => 'hashed',
        ];
    }

    public function peminjaman()
    {
        return $this->hasMany(tm_peminjaman::class, 'user_id', 'user_id');
    }

    // Relasi ke Pengembalian
    public function pengembalian()
    {
        return $this->hasMany(tm_pengembalian::class, 'user_id', 'user_id');
    }
}
