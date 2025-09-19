<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Áo sơ mi nam',
                'description' => 'Áo sơ mi nam cao cấp, phong cách công sở',
                'image' => 'https://images.unsplash.com/photo-1594938298605-c04c5d57d3e8?w=400',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Áo sơ mi nữ',
                'description' => 'Áo sơ mi nữ thanh lịch, phù hợp mọi dịp',
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=400',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Áo sơ mi trẻ em',
                'description' => 'Áo sơ mi trẻ em chất lượng cao, thoải mái',
                'image' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=400',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Áo sơ mi thể thao',
                'description' => 'Áo sơ mi thể thao co giãn, thấm hút mồ hôi',
                'image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Áo sơ mi cao cấp',
                'description' => 'Áo sơ mi cao cấp, chất liệu premium',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
