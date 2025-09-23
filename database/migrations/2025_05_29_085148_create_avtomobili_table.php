<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграции.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained('salons')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('car_brands')->onDelete('cascade');
            $table->foreignId('model_id')->constrained('car_models')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('car_statuses')->onDelete('cascade');
            $table->string('vin')->unique();
            $table->string('registration_number')->nullable()->unique();
            $table->integer('year');
            $table->string('color')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('mileage', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('car_option')->nullable(); // доп опции к авто
            $table->timestamps();
        });
    }

    /**
     * Откат миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};