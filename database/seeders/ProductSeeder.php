<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        $productsData = [
            // Áo sơ mi nam
            [
                'name' => 'Áo Sơ Mi Nam Công Sở Cao Cấp',
                'description' => 'Áo sơ mi nam lịch lãm, chất liệu cotton cao cấp, thoáng mát, chống nhăn. Phù hợp cho môi trường công sở và các sự kiện quan trọng.',
                'content' => 'Thiết kế ôm vừa vặn, tôn dáng. Cổ áo cứng cáp, đường may tỉ mỉ. Dễ dàng phối hợp với quần tây, quần kaki.',
                'image' => 'https://images.unsplash.com/photo-1603252109303-275144df1865?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 450000,
                'stock' => 100,
                'category_name' => 'Áo sơ mi nam',
                'is_featured' => true,
            ],
            [
                'name' => 'Áo Sơ Mi Nam Trắng Tinh Tế',
                'description' => 'Áo sơ mi nam màu trắng tinh tế, chất liệu cotton mềm mại, thiết kế đơn giản nhưng sang trọng.',
                'content' => 'Thiết kế cổ điển với cổ áo kiểu classic, phù hợp cho nhiều dịp khác nhau từ công sở đến các sự kiện quan trọng.',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 380000,
                'stock' => 80,
                'category_name' => 'Áo sơ mi nam',
                'is_featured' => false,
            ],
            [
                'name' => 'Áo Sơ Mi Nam Xanh Navy',
                'description' => 'Áo sơ mi nam màu xanh navy thanh lịch, chất liệu cotton cao cấp, thiết kế hiện đại.',
                'content' => 'Màu xanh navy sang trọng, dễ dàng phối hợp với nhiều trang phục khác nhau. Chất liệu cotton thoáng mát.',
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 420000,
                'stock' => 60,
                'category_name' => 'Áo sơ mi nam',
                'is_featured' => true,
            ],
            [
                'name' => 'Áo Sơ Mi Nam Kẻ Sọc',
                'description' => 'Áo sơ mi nam kẻ sọc tinh tế, thiết kế độc đáo, chất liệu cotton cao cấp.',
                'content' => 'Thiết kế kẻ sọc tạo điểm nhấn, phù hợp cho những người yêu thích phong cách cá tính và hiện đại.',
                'image' => 'https://images.unsplash.com/photo-1621184455862-c163dfb30e0f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 400000,
                'stock' => 45,
                'category_name' => 'Áo sơ mi nam',
                'is_featured' => false,
            ],
            [
                'name' => 'Áo Sơ Mi Nam Họa Tiết',
                'description' => 'Áo sơ mi nam có họa tiết nhẹ nhàng, thiết kế trẻ trung, chất liệu cotton mềm mại.',
                'content' => 'Họa tiết tinh tế tạo sự khác biệt, phù hợp cho những dịp không quá trang trọng.',
                'image' => 'https://images.unsplash.com/photo-1617137984095-74e4e5e3613f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 350000,
                'stock' => 70,
                'category_name' => 'Áo sơ mi nam',
                'is_featured' => false,
            ],
            // Áo sơ mi nữ
            [
                'name' => 'Áo Sơ Mi Nữ Công Sở Thanh Lịch',
                'description' => 'Áo sơ mi nữ công sở với thiết kế thanh lịch, chất liệu cotton cao cấp, phù hợp cho môi trường làm việc.',
                'content' => 'Thiết kế tôn dáng, cổ áo kiểu classic, tay dài. Chất liệu cotton thoáng mát, dễ chăm sóc.',
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 420000,
                'stock' => 90,
                'category_name' => 'Áo sơ mi nữ',
                'is_featured' => true,
            ],
            [
                'name' => 'Áo Sơ Mi Nữ Trắng Tinh Khôi',
                'description' => 'Áo sơ mi nữ màu trắng tinh khôi, thiết kế đơn giản nhưng sang trọng, chất liệu cotton mềm mại.',
                'content' => 'Màu trắng tinh khôi tạo vẻ thanh lịch, phù hợp cho nhiều dịp khác nhau.',
                'image' => 'https://images.unsplash.com/photo-1566479179817-c0d9ed0b5d0e?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 380000,
                'stock' => 75,
                'category_name' => 'Áo sơ mi nữ',
                'is_featured' => false,
            ],
            [
                'name' => 'Áo Sơ Mi Nữ Xanh Pastel',
                'description' => 'Áo sơ mi nữ màu xanh pastel nhẹ nhàng, thiết kế nữ tính, chất liệu cotton cao cấp.',
                'content' => 'Màu xanh pastel tạo cảm giác dịu nhẹ, phù hợp cho những người yêu thích phong cách nhẹ nhàng.',
                'image' => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 400000,
                'stock' => 65,
                'category_name' => 'Áo sơ mi nữ',
                'is_featured' => true,
            ],
            [
                'name' => 'Áo Sơ Mi Nữ Hoa Nhí',
                'description' => 'Áo sơ mi nữ có họa tiết hoa nhí tinh tế, thiết kế nữ tính, chất liệu cotton mềm mại.',
                'content' => 'Họa tiết hoa nhí tạo sự nữ tính và trẻ trung, phù hợp cho những dịp không quá trang trọng.',
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 360000,
                'stock' => 55,
                'category_name' => 'Áo sơ mi nữ',
                'is_featured' => false,
            ],
            [
                'name' => 'Áo Sơ Mi Nữ Tay Ngắn',
                'description' => 'Áo sơ mi nữ tay ngắn thoải mái, thiết kế trẻ trung, chất liệu cotton thoáng mát.',
                'content' => 'Thiết kế tay ngắn phù hợp cho thời tiết nóng, tạo cảm giác thoải mái và năng động.',
                'image' => 'https://images.unsplash.com/photo-1566479179817-c0d9ed0b5d0e?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'price' => 320000,
                'stock' => 85,
                'category_name' => 'Áo sơ mi nữ',
                'is_featured' => false,
            ],
        ];

        foreach ($productsData as $productData) {
            $category = $categories->firstWhere('name', $productData['category_name']);

            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'content' => $productData['content'],
                    'image' => $productData['image'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'category_id' => $category->id,
                    'is_active' => 1, // Luôn kích hoạt
                    'is_featured' => $productData['is_featured'],
                ]);
            }
        }
        
        $this->command->info('Đã tạo ' . count($productsData) . ' sản phẩm mẫu thành công!');
    }
}