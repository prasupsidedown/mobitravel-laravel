<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->boolean('is_driver')->default(false)->after('ktp_photo');
            $table->string('vehicle_type')->nullable()->after('is_driver');
            $table->integer('vehicle_capacity')->nullable()->after('vehicle_type');
            $table->integer('price_per_day')->nullable()->after('vehicle_capacity');
            $table->json('routes')->nullable()->after('price_per_day');
            $table->decimal('rating', 3, 2)->default(0)->after('routes');
            $table->integer('total_reviews')->default(0)->after('rating');
            $table->boolean('is_available')->default(true)->after('total_reviews');
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'is_driver',
                'vehicle_type',
                'vehicle_capacity',
                'price_per_day',
                'routes',
                'rating',
                'total_reviews',
                'is_available',
            ]);
        });
    }
};