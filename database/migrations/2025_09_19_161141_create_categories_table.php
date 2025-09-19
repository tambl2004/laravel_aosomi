<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên danh mục
            $table->string('slug')->unique(); // Slug cho URL
            $table->text('description')->nullable(); // Mô tả danh mục
            $table->string('image')->nullable(); // Hình ảnh danh mục (đường link)
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->integer('sort_order')->default(0); // Thứ tự sắp xếp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
