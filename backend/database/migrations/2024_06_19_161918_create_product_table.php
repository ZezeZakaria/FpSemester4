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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->longText('description')->nullable();
            $table->text('photo');
            $table->integer('stock')->default(1);
            $table->string('size')->default('M')->nullable();
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->float('price');
            $table->boolean('is_featured')->deault(false);
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
