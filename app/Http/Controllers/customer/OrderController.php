<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng của user
     */
    public function index(Request $request)
    {
        $query = Order::with('orderItems')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        // Bộ lọc tìm kiếm
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        // Bộ lọc trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Bộ lọc ngày
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(10);

        return view('customer.orders', compact('orders'));
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
