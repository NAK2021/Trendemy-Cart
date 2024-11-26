<?php

use App\Enums\OrderState;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('code')->unique();
            $table->unsignedBigInteger('user_id');
            $table->text('promotion')->nullable();
            $table->integer('discount')->default(0);
            $table->bigInteger('total');
            $table->enum('state', OrderState::getValues())->default(OrderState::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
