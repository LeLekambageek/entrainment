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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('model');
            $table->year('year');
            $table->string('color');
            $table->decimal('price', 12, 2);
            $table->integer('mileage')->nullable();
            $table->string('fuel_type');
            $table->string('transmission');
            $table->integer('horsepower')->nullable();
            $table->decimal('engine_displacement', 4, 1)->nullable();
            $table->text('description');
            $table->string('featured_image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
