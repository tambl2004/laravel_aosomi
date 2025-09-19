<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Tự động tạo slug khi tạo hoặc cập nhật category
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Quan hệ với sản phẩm
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope để lấy danh mục đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope để sắp xếp theo thứ tự
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
