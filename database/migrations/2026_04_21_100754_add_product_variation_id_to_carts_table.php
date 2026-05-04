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
        Schema::table('carts', function (Blueprint $table) {

            $table->foreignId('product_variation_id')
                  ->after('product_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('selected_size')
                  ->after('product_variation_id')
                  ->nullable();

            $table->string('selected_color')
                  ->after('selected_size')
                  ->nullable();
                  
            $table->string('selected_variant')
                  ->after('selected_color')
                  ->nullable();

            $table->integer('quantity')
                  ->default(1)
                  ->after('selected_variant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {

            $table->dropColumn([
            'product_variation_id',
            'selected_size',
            'selected_color',
            'selected_variant',
            'quantity'
        ]);

        });
    }
};







