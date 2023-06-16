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
        Schema::create('attribute_product_values', function (Blueprint $table) {
            $table->id();
            $table->integer('attribute_product_id')->index();
            $table->string('label')->nullable();
            $table->string('value');
            $table->string('price');
            $table->bigInteger('sell_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_product_values');
    }
};
