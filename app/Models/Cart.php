<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
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
     * Scope lấy cart của user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public static function addToCart($userId, $productId, $quantity = 1)
    {
        $cartItem = static::where('user_id', $userId)
                         ->where('product_id', $productId)
                         ->first();

        if ($cartItem) {
            // Nếu đã có trong giỏ, tăng số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
            return $cartItem;
        } else {
            // Nếu chưa có, tạo mới
            return static::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ
     */
    public function updateQuantity($quantity)
    {
        if ($quantity <= 0) {
            return $this->delete();
        }
        
        $this->quantity = $quantity;
        return $this->save();
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public static function removeFromCart($userId, $productId)
    {
        return static::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->delete();
    }

    /**
     * Lấy tổng số sản phẩm trong giỏ của user
     */
    public static function getTotalItems($userId)
    {
        return static::where('user_id', $userId)->sum('quantity');
    }

    /**
     * Lấy tổng tiền trong giỏ của user
     */
    public static function getTotalAmount($userId)
    {
        return static::where('user_id', $userId)
                    ->with('product')
                    ->get()
                    ->sum(function ($item) {
                        return $item->product->price * $item->quantity;
                    });
    }

    /**
     * Xóa tất cả sản phẩm trong giỏ của user
     */
    public static function clearCart($userId)
    {
        return static::where('user_id', $userId)->delete();
    }
}