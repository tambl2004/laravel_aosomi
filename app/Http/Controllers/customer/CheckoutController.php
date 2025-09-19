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
        // Validation rules
        $rules = [
            'payment_method' => 'required|in:cod,bank_transfer,momo,zalopay',
            'notes' => 'nullable|string|max:1000',
        ];

        $messages = [
            'payment_method.required' => 'Phương thức thanh toán không được để trống',
        ];

        // Kiểm tra xem có chọn địa chỉ từ danh sách không
        if ($request->address_id) {
            // Chọn địa chỉ từ danh sách
            $rules['address_id'] = 'required|exists:addresses,id';
            $messages['address_id.required'] = 'Vui lòng chọn địa chỉ giao hàng';
            $messages['address_id.exists'] = 'Địa chỉ không hợp lệ';
        } else {
            // Nhập địa chỉ thủ công
            $rules['customer_name'] = 'required|string|max:255';
            $rules['customer_email'] = 'required|email|max:255';
            $rules['customer_phone'] = 'required|string|max:20';
            $rules['customer_address'] = 'required|string|max:500';
            $rules['customer_city'] = 'required|string|max:100';
            $rules['customer_district'] = 'required|string|max:100';
            $rules['customer_ward'] = 'required|string|max:100';
            $messages['customer_name.required'] = 'Họ tên không được để trống';
            $messages['customer_email.required'] = 'Email không được để trống';
            $messages['customer_email.email'] = 'Email không hợp lệ';
            $messages['customer_phone.required'] = 'Số điện thoại không được để trống';
            $messages['customer_address.required'] = 'Địa chỉ không được để trống';
            $messages['customer_city.required'] = 'Tỉnh/Thành phố không được để trống';
            $messages['customer_district.required'] = 'Quận/Huyện không được để trống';
            $messages['customer_ward.required'] = 'Phường/Xã không được để trống';
        }

        $request->validate($rules, $messages);

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

            // Lấy thông tin địa chỉ
            $addressData = [];
            if ($request->address_id) {
                // Lấy thông tin từ địa chỉ đã chọn
                $address = \App\Models\Address::where('id', $request->address_id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();
                
                $addressData = [
                    'customer_name' => $address->name,
                    'customer_email' => auth()->user()->email, // Lấy email từ user
                    'customer_phone' => $address->phone,
                    'customer_address' => $address->address,
                    'customer_city' => $address->city,
                    'customer_district' => $address->district,
                    'customer_ward' => $address->ward,
                ];
            } else {
                // Sử dụng thông tin nhập thủ công
                $addressData = [
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'customer_address' => $request->customer_address,
                    'customer_city' => $request->customer_city,
                    'customer_district' => $request->customer_district,
                    'customer_ward' => $request->customer_ward,
                ];
            }

            // Tạo đơn hàng
            $order = Order::create(array_merge($addressData, [
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'notes' => $request->notes,
            ]));

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
}