<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);

        // Tìm kiếm theo mã đơn hàng hoặc tên khách hàng
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhere('customer_name', 'like', '%' . $search . '%')
                  ->orWhere('customer_email', 'like', '%' . $search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $search . '%');
            });
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Lọc theo phương thức thanh toán
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Lọc theo ngày
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sắp xếp
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(15);

        // Thống kê
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $order->status;
        $order->updateStatus($request->status, $request->admin_notes);

        $message = "Đã cập nhật trạng thái đơn hàng từ '{$order->getStatusNameAttribute()}' sang '{$order->getStatusNameAttribute()}'";

        return redirect()->route('admin.orders.show', $order)
            ->with('success', $message);
    }

    /**
     * Cập nhật thông tin đơn hàng
     */
    public function update(Request $request, Order $order)
    {
        if (!$order->canBeUpdated()) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Không thể cập nhật đơn hàng đã giao hoặc đã hủy!');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'customer_city' => 'required|string|max:100',
            'customer_district' => 'required|string|max:100',
            'customer_ward' => 'required|string|max:100',
            'shipping_fee' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_city' => $request->customer_city,
            'customer_district' => $request->customer_district,
            'customer_ward' => $request->customer_ward,
            'shipping_fee' => $request->shipping_fee ?? 0,
            'admin_notes' => $request->admin_notes,
        ]);

        // Tính lại tổng tiền
        $order->total_amount = $order->subtotal + $order->shipping_fee;
        $order->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Đã cập nhật thông tin đơn hàng thành công!');
    }

    /**
     * Xóa đơn hàng
     */
    public function destroy(Order $order)
    {
        if ($order->status === 'delivered') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể xóa đơn hàng đã giao!');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đã xóa đơn hàng thành công!');
    }

    /**
     * Xuất danh sách đơn hàng
     */
    public function export(Request $request)
    {
        // TODO: Implement export functionality
        return redirect()->route('admin.orders.index')
            ->with('info', 'Chức năng xuất file sẽ được phát triển trong tương lai!');
    }

    /**
     * In đơn hàng
     */
    public function print(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.print', compact('order'));
    }
}