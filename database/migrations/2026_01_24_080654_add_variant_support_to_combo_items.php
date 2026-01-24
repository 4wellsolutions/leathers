<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('combo_items', function (Blueprint $table) {
            // Add product_variant_id column
            $table->foreignId('product_variant_id')->nullable()->after('product_id')->constrained()->onDelete('cascade');

            // Make product_id nullable for backward compatibility
            $table->foreignId('product_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('combo_items', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn('product_variant_id');

            // Make product_id required again
            $table->foreignId('product_id')->nullable(false)->change();
        });
    }
};
