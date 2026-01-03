<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g. "Red"
            $table->string('color_code')->nullable(); // e.g. "#FF0000"
            $table->string('image')->nullable(); // Main image for this color
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
