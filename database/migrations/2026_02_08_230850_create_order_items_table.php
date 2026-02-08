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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->string('variant_name'); // (Single, Chunky, etc.) عشان يثبت في الفاتورة حتى لو السعر اتغير قدام
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2); // سعر القطعة وقت الشراء
            $table->boolean('is_combo')->default(false); // هل العميل اختار يخليه كومبو؟
            $table->decimal('combo_price', 8, 2)->default(45.00); // سعر الكومبو وقت الطلب
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
