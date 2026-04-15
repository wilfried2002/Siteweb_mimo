<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('phone', 30);
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->enum('type', ['detail', 'gros']);
            $table->decimal('total', 12, 2)->nullable(); // null si gros (prix non public)
            $table->enum('status', ['pending', 'validated', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();         // notes admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
