<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục
     */
    public function index()
    {
        $categories = Category::ordered()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hiển thị form tạo danh mục mới
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Lưu danh mục mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0'
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.max' => 'Tên danh mục không được quá 255 ký tự',
            'image.url' => 'Link hình ảnh không hợp lệ'
        ]);

        $data = $request->only(['name', 'description', 'image', 'sort_order']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->input('is_active', 0);

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }


    /**
     * Hiển thị form chỉnh sửa danh mục
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Cập nhật danh mục
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0'
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.max' => 'Tên danh mục không được quá 255 ký tự',
            'image.url' => 'Link hình ảnh không hợp lệ'
        ]);

        $data = $request->only(['name', 'description', 'image', 'sort_order']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->input('is_active', 0);

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Xóa danh mục
     */
    public function destroy(Category $category)
    {
        // Kiểm tra xem danh mục có sản phẩm không
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục có sản phẩm!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa thành công!');
    }
}
