<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->unique()->cascadeOnDelete();
            $table->string('payment_method', 50);
            $table->string('shipping_postal_code', 8);
            $table->string('shipping_address');
            $table->string('shipping_building')->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->dateTime('purchased_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
