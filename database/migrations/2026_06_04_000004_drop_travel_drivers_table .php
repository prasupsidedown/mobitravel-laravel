<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('travel_drivers');
    }

    public function down(): void
    {
        // Recreate kalau rollback diperlukan
        Schema::create('travel_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('vehicle_type');
            $table->integer('vehicle_capacity');
            $table->integer('price_per_day');
            $table->json('routes')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->boolean('is_available')->default(true);
            $table->string('profile_photo')->nullable();
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            $table->timestamps();
        });
    }
};