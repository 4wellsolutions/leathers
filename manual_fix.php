<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Running manual fix...\n";

// 1. Create product_colors if not exists
if (!Schema::hasTable('product_colors')) {
    echo "Creating product_colors table...\n";
    Schema::create('product_colors', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->string('name'); 
        $table->string('color_code')->nullable();
        $table->string('image')->nullable();
        $table->timestamps();
    });
    echo "product_colors created.\n";
    
    // Mark as migrated
    DB::table('migrations')->insert([
        'migration' => '2025_12_09_160000_create_product_colors_table',
        'batch' => DB::table('migrations')->max('batch') + 1
    ]);
} else {
    echo "product_colors already exists.\n";
}

// 2. Update product_variants if needed
// Check for product_color_id column
if (Schema::hasTable('product_variants')) {
    if (!Schema::hasColumn('product_variants', 'product_color_id')) {
        echo "Adding product_color_id to product_variants...\n";
        Schema::table('product_variants', function (Blueprint $table) {
            $table->foreignId('product_color_id')->nullable()->constrained('product_colors')->onDelete('cascade');
        });
        
        // Remove 'color' column if exists
        if (Schema::hasColumn('product_variants', 'color')) {
             Schema::table('product_variants', function (Blueprint $table) {
                $table->dropColumn('color');
             });
        }
        
        echo "product_variants updated.\n";

         DB::table('migrations')->insert([
            'migration' => '2025_12_09_160100_update_product_variants_structure',
            'batch' => DB::table('migrations')->max('batch') + 1
        ]);
        
    } else {
        echo "product_variants already has product_color_id.\n";
    }
}

echo "Done.\n";
