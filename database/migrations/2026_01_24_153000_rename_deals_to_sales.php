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
        // Rename table
        Schema::rename('deals', 'sales');

        // Rename foreign key column in products table
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('deal_id', 'sale_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('sale_id', 'deal_id');
        });

        Schema::rename('sales', 'deals');
    }
};
