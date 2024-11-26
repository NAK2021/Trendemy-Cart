<?php

use App\Enums\CouponType;
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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('value');
            $table->enum('type', CouponType::getValues());
            $table->string('description')->nullable();
            $table->integer('min_amount')->default(0);
            $table->integer('max_amount')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('expiry_date');
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
