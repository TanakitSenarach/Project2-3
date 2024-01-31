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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id')->comment("รหัสสินค้า");
            $table->string('name',255)->comment("ชื่อสินค้า");
            $table->string('price',255)->comment("ราคาสินค้า");
            $table->text('description')->comment("รายระเอียดประเภทสินค้า");
            $table->integer('category_id')->comment("รหัสปรเภทสินค้า");
            $table->string('image',255)->comment("รูปภาพ");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
