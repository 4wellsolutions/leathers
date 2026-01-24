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
        // Rename main table
        Schema::rename('combos', 'deals');

        // Rename items table
        Schema::rename('combo_items', 'deal_items');

        // Rename foreign key column
        Schema::table('deal_items', function (Blueprint $table) {
            $table->renameColumn('combo_id', 'deal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deal_items', function (Blueprint $table) {
            $table->renameColumn('deal_id', 'combo_id');
        });

        Schema::rename('deal_items', 'combo_items');
        Schema::rename('deals', 'combos');
    }
};
