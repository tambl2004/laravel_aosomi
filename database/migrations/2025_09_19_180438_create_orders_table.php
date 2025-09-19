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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Thông tin khách hàng
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->string('customer_city');
            $table->string('customer_district');
            $table->string('customer_ward');
            
            // Thông tin đơn hàng
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cod', 'bank_transfer', 'momo', 'zalopay'])->default('cod');
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            
            // Ghi chú
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
