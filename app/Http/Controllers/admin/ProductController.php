<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', 0);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', 1);
            }
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $products = $query->paginate(10)->withQueryString();
        $categories = Category::active()->orderBy('name')->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Hiển thị form tạo sản phẩm mới
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Lưu sản phẩm mới
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|url',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'nullable|boolean'
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.max' => 'Tên sản phẩm không được quá 255 ký tự',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0',
            'stock.required' => 'Số lượng tồn kho không được để trống',
            'stock.integer' => 'Số lượng tồn kho phải là số nguyên',
            'stock.min' => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại',
            'image.url' => 'Link hình ảnh không hợp lệ'
        ]);

        try {
            // Chuẩn bị dữ liệu
            $data = $request->only([
                'name', 'description', 'content', 'image', 
                'price', 'stock', 'category_id'
            ]);
            
            // Tạo slug từ tên sản phẩm
            $data['slug'] = Str::slug($request->name);
            
            // Xử lý checkbox
            $data['is_active'] = 1; // Luôn kích hoạt
            $data['is_featured'] = $request->input('is_featured', 0);
            
            // Tạo sản phẩm
            Product::create($data);
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được tạo thành công!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị form chỉnh sửa sản phẩm
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        
        // Chuyển gallery từ JSON thành array nếu có
        if ($product->gallery && is_string($product->gallery)) {
            $product->gallery = json_decode($product->gallery, true);
        }
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, Product $product)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|url',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'nullable|boolean'
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.max' => 'Tên sản phẩm không được quá 255 ký tự',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0',
            'stock.required' => 'Số lượng tồn kho không được để trống',
            'stock.integer' => 'Số lượng tồn kho phải là số nguyên',
            'stock.min' => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại',
            'image.url' => 'Link hình ảnh không hợp lệ'
        ]);

        try {
            // Chuẩn bị dữ liệu
            $data = $request->only([
                'name', 'description', 'content', 'image', 
                'price', 'stock', 'category_id'
            ]);
            
            // Tạo slug từ tên sản phẩm
            $data['slug'] = Str::slug($request->name);
            
            // Xử lý checkbox
            $data['is_active'] = 1; // Luôn kích hoạt
            $data['is_featured'] = $request->input('is_featured', 0);
            
            // Cập nhật sản phẩm
            $product->update($data);
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được cập nhật thành công!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được xóa thành công!');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Thay đổi trạng thái sản phẩm
     */
    public function toggleStatus(Product $product)
    {
        try {
            $product->update(['is_active' => !$product->is_active]);
            
            $status = $product->is_active ? 'kích hoạt' : 'vô hiệu hóa';
            
            return redirect()->route('admin.products.index')
                ->with('success', "Sản phẩm đã được {$status} thành công!");
                
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Có lỗi xảy ra khi thay đổi trạng thái: ' . $e->getMessage());
        }
    }

    /**
     * Thay đổi trạng thái nổi bật
     */
    public function toggleFeatured(Product $product)
    {
        try {
            $product->update(['is_featured' => !$product->is_featured]);
            
            $status = $product->is_featured ? 'đánh dấu nổi bật' : 'bỏ đánh dấu nổi bật';
            
            return redirect()->route('admin.products.index')
                ->with('success', "Sản phẩm đã được {$status} thành công!");
                
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Có lỗi xảy ra khi thay đổi trạng thái nổi bật: ' . $e->getMessage());
        }
    }
}