<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'product_price',
        'quantity',
        'total_price',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Relationship với Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship với Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor cho hình ảnh sản phẩm
     */
    public function getProductImageAttribute($value)
    {
        return $value ?: 'https://via.placeholder.com/150?text=No+Image';
    }
}