<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang thanh toán
     */
    public function index()
    {
        $cartItems = Cart::with('product.category')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingFee = 0; // Miễn phí vận chuyển
        $totalAmount = $subtotal + $shippingFee;

        return view('customer.checkout', compact('cartItems', 'subtotal', 'shippingFee', 'totalAmount'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'customer_city' => 'required|string|max:100',
            'customer_district' => 'required|string|max:100',
            'customer_ward' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,bank_transfer,momo,zalopay',
            'notes' => 'nullable|string|max:1000',
        ], [
            'customer_name.required' => 'Họ tên không được để trống',
            'customer_email.required' => 'Email không được để trống',
            'customer_email.email' => 'Email không hợp lệ',
            'customer_phone.required' => 'Số điện thoại không được để trống',
            'customer_address.required' => 'Địa chỉ không được để trống',
            'customer_city.required' => 'Tỉnh/Thành phố không được để trống',
            'customer_district.required' => 'Quận/Huyện không được để trống',
            'customer_ward.required' => 'Phường/Xã không được để trống',
            'payment_method.required' => 'Phương thức thanh toán không được để trống',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Kiểm tra tồn kho
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', "Sản phẩm {$item->product->name} không đủ tồn kho!");
            }
        }

        DB::beginTransaction();
        try {
            // Tính toán tổng tiền
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
            $shippingFee = 0; // Miễn phí vận chuyển
            $totalAmount = $subtotal + $shippingFee;

            // Tạo đơn hàng
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'customer_city' => $request->customer_city,
                'customer_district' => $request->customer_district,
                'customer_ward' => $request->customer_ward,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_image' => $item->product->image,
                    'product_price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'total_price' => $item->product->price * $item->quantity,
                ]);

                // Cập nhật tồn kho
                $item->product->decrement('stock', $item->quantity);
            }

            // Xóa giỏ hàng
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('checkout')
                ->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!');
        }
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show(Order $order)
    {
        // Kiểm tra quyền truy cập
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('customer.order-detail', compact('order'));
    }

    /**
     * Hiển thị danh sách đơn hàng của user
     */
    public function index()
    {
        $orders = Order::with('orderItems')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }
}