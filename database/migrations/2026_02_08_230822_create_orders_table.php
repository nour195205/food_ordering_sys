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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // مين اللي طلب
            // بيانات التوصيل للطلب ده تحديداً
            $table->string('customer_name'); 
            $table->string('phone');
            $table->string('phone_2')->nullable();
            $table->text('address');
            
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // (pending, preparing, delivered, cancelled)
            $table->timestamps();
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
