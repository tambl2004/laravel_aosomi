<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
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
        'email_verified_at',
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

    /**
     * Kiểm tra xem user có phải admin không
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Kiểm tra xem user có phải user thường không
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Kiểm tra user có role cụ thể không
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Đánh dấu email đã được xác thực
     */
    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Kiểm tra email đã được xác thực chưa
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Lấy email để xác thực
     */
    public function getEmailForVerification(): string
    {
        return $this->email;
    }

    /**
     * Quan hệ với Address
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Quan hệ với Order
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Lấy địa chỉ mặc định
     */
    public function defaultAddress()
    {
        return $this->addresses()->default()->first();
    }
}
