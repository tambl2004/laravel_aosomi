<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ customer
     */
    public function index()
    {
        // Lấy sản phẩm nổi bật và mới nhất
        $featuredProducts = Product::active()->featured()->orderBy('created_at', 'desc')->take(8)->get();
        $latestProducts = Product::active()->orderBy('created_at', 'desc')->take(8)->get();
        $categories = Category::active()->orderBy('name')->get();
        
        return view('customer.home', compact('featuredProducts', 'latestProducts', 'categories'));
    }
    
    /**
     * Hiển thị trang sản phẩm
     */
    public function products(Request $request)
    {
        $query = Product::active()->with('category');
        
        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }
        
        // Lọc theo danh mục
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort', 'name');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }
        
        $products = $query->paginate(12);
        $categories = Category::active()->orderBy('name')->get();
        
        return view('customer.products', compact('products', 'categories'));
    }
    
    /**
     * Hiển thị trang giới thiệu
     */
    public function about()
    {
        return view('customer.about');
    }
    
    /**
     * Hiển thị trang liên hệ
     */
    public function contact()
    {
        return view('customer.contact');
    }
}