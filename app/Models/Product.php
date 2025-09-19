<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'image',
        'price',
        'stock',
        'category_id',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Relationship với Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope cho sản phẩm đang kích hoạt
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope cho sản phẩm nổi bật
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope sắp xếp theo tên
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**
     * Scope tìm kiếm theo tên
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
    }

    /**
     * Tự động tạo slug khi tạo sản phẩm
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Accessor: Giá hiển thị
     */
    public function getDisplayPriceAttribute()
    {
        return $this->price;
    }

    /**
     * Accessor: Kiểm tra còn hàng
     */
    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }

    /**
     * Accessor: Hình ảnh đầu tiên
     */
    public function getFirstImageAttribute()
    {
        if ($this->image) {
            return $this->image;
        }
        return 'https://via.placeholder.com/150?text=No+Image';
    }

    /**
     * Mutator: Tự động tạo slug khi set name
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Phương thức toggle trạng thái kích hoạt
     */
    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
        $this->save();
    }

    /**
     * Phương thức toggle trạng thái nổi bật
     */
    public function toggleFeatured()
    {
        $this->is_featured = !$this->is_featured;
        $this->save();
    }
}