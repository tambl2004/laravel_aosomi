<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * Relationship với User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship với Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope lấy wishlist của user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Kiểm tra sản phẩm có trong wishlist của user không
     */
    public static function isInWishlist($userId, $productId)
    {
        return static::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->exists();
    }

    /**
     * Thêm sản phẩm vào wishlist
     */
    public static function addToWishlist($userId, $productId)
    {
        return static::firstOrCreate([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    }

    /**
     * Xóa sản phẩm khỏi wishlist
     */
    public static function removeFromWishlist($userId, $productId)
    {
        return static::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->delete();
    }
}