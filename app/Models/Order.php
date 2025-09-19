<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_city',
        'customer_district',
        'customer_ward',
        'subtotal',
        'shipping_fee',
        'total_amount',
        'payment_method',
        'status',
        'notes',
        'admin_notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Relationship với User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship với OrderItems
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope lấy đơn hàng của user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope lấy đơn hàng theo trạng thái
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope lấy đơn hàng gần đây
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Tạo mã đơn hàng tự động
     */
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $lastOrder = static::whereDate('created_at', now()->toDateString())
                          ->orderBy('id', 'desc')
                          ->first();
        
        $sequence = $lastOrder ? (intval(substr($lastOrder->order_number, -4)) + 1) : 1;
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus($status, $adminNotes = null)
    {
        $this->status = $status;
        if ($adminNotes) {
            $this->admin_notes = $adminNotes;
        }
        $this->save();
    }

    /**
     * Kiểm tra có thể hủy đơn hàng không
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Kiểm tra có thể cập nhật không
     */
    public function canBeUpdated()
    {
        return !in_array($this->status, ['delivered', 'cancelled']);
    }

    /**
     * Lấy tên trạng thái bằng tiếng Việt
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Lấy tên phương thức thanh toán bằng tiếng Việt
     */
    public function getPaymentMethodNameAttribute()
    {
        $methods = [
            'cod' => 'Thanh toán khi nhận hàng (COD)',
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'momo' => 'Ví MoMo',
            'zalopay' => 'Ví ZaloPay',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    /**
     * Lấy địa chỉ đầy đủ
     */
    public function getFullAddressAttribute()
    {
        return $this->customer_address . ', ' . $this->customer_ward . ', ' . $this->customer_district . ', ' . $this->customer_city;
    }
}