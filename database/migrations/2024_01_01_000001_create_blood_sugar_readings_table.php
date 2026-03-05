<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_sugar_readings', function (Blueprint $table) {
            $table->id();
            $table->decimal('level', 6, 2); // mg/dL
            $table->enum('meal_context', ['fasting', 'before_meal', 'after_meal', 'bedtime', 'random']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_sugar_readings');
    }
};