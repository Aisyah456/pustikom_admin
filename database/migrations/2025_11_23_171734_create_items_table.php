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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');

            $table->string('serial_number')->unique()->nullable();
            $table->text('specification')->nullable();

            $table->integer('total_stock');
            $table->integer('current_stock');

            $table->string('location');
            $table->enum('status', ['Good', 'Fair', 'Needs Repair', 'Broken'])->default('Good');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
