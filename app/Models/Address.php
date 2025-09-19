<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'city',
        'district',
        'ward',
        'is_default',
        'type',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Quan hệ với User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy địa chỉ đầy đủ
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, {$this->ward}, {$this->district}, {$this->city}";
    }

    /**
     * Lấy tên loại địa chỉ
     */
    public function getTypeNameAttribute(): string
    {
        return match($this->type) {
            'home' => 'Nhà riêng',
            'office' => 'Văn phòng',
            'other' => 'Khác',
            default => 'Nhà riêng',
        };
    }

    /**
     * Scope để lấy địa chỉ mặc định
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope để lấy địa chỉ của user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
