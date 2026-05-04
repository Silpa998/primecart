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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
        
            // Category Type (electronics, clothing, etc.)
            $table->string('type');
        
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('variant')->nullable();

            $table->decimal('price', 10, 2)->default(0);
            $table->integer('stock')->default(0);

            $table->string('sku')->unique()->nullable(); // Stock Keeping Unit (easily identifiable code for each variation)
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
