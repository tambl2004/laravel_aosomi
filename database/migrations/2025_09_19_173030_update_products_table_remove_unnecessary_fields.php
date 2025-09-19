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
        Schema::table('products', function (Blueprint $table) {
            // Bỏ các trường không cần thiết
            $table->dropColumn(['gallery', 'sale_price', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Khôi phục các trường đã bỏ
            $table->json('gallery')->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('sort_order')->default(0);
        });
    }
};
