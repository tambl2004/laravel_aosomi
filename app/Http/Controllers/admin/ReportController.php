<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Hiển thị trang báo cáo tổng quan
     */
    public function index(Request $request)
    {
        // Lấy tham số thời gian
        $period = $request->get('period', '30'); // Mặc định 30 ngày
        $startDate = $request->get('start_date', Carbon::now('Asia/Ho_Chi_Minh')->subDays($period)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'));

        // Thống kê tổng quan
        $stats = $this->getOverviewStats($startDate, $endDate);
        
        // Thống kê đơn hàng theo thời gian
        $orderStats = $this->getOrderStats($startDate, $endDate);
        
        // Thống kê sản phẩm bán chạy
        $topProducts = $this->getTopProducts($startDate, $endDate);
        
        // Thống kê theo danh mục
        $categoryStats = $this->getCategoryStats($startDate, $endDate);
        
        // Thống kê khách hàng
        $customerStats = $this->getCustomerStats($startDate, $endDate);
        
        // Thống kê thanh toán
        $paymentStats = $this->getPaymentStats($startDate, $endDate);

        return view('admin.reports.index', compact(
            'stats', 
            'orderStats', 
            'topProducts', 
            'categoryStats', 
            'customerStats', 
            'paymentStats',
            'startDate',
            'endDate',
            'period'
        ));
    }

    /**
     * Lấy thống kê tổng quan
     */
    private function getOverviewStats($startDate, $endDate)
    {
        return [
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_revenue' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
            'total_customers' => User::where('role', 'user')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'total_products' => Product::where('is_active', true)->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'delivered_orders' => Order::where('status', 'delivered')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
        ];
    }

    /**
     * Lấy thống kê đơn hàng theo thời gian
     */
    private function getOrderStats($startDate, $endDate)
    {
        $orders = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $orders->pluck('date')->map(function($date) {
                return Carbon::parse($date)->format('d/m');
            })->toArray(),
            'orders' => $orders->pluck('count')->toArray(),
            'revenue' => $orders->pluck('revenue')->toArray(),
        ];
    }

    /**
     * Lấy sản phẩm bán chạy
     */
    private function getTopProducts($startDate, $endDate)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                'products.id',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Lấy thống kê theo danh mục
     */
    private function getCategoryStats($startDate, $endDate)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();
    }

    /**
     * Lấy thống kê khách hàng
     */
    private function getCustomerStats($startDate, $endDate)
    {
        return [
            'new_customers' => User::where('role', 'user')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'active_customers' => User::where('role', 'user')
                ->whereHas('orders', function($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->count(),
            'total_customers' => User::where('role', 'user')->count(),
        ];
    }

    /**
     * Lấy thống kê thanh toán
     */
    private function getPaymentStats($startDate, $endDate)
    {
        return Order::select(
                'payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->groupBy('payment_method')
            ->get()
            ->map(function($item) {
                return [
                    'method' => $item->payment_method,
                    'method_name' => $this->getPaymentMethodName($item->payment_method),
                    'count' => $item->count,
                    'total_amount' => $item->total_amount,
                ];
            });
    }

    /**
     * Lấy tên phương thức thanh toán
     */
    private function getPaymentMethodName($method)
    {
        return match($method) {
            'cod' => 'Thanh toán khi nhận hàng',
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'momo' => 'Ví MoMo',
            'zalopay' => 'ZaloPay',
            default => 'Khác',
        };
    }

    /**
     * Xuất báo cáo Excel
     */
    public function export(Request $request)
    {
        // TODO: Implement Excel export
        return response()->json(['message' => 'Chức năng xuất Excel sẽ được phát triển']);
    }
}
