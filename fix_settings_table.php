<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Attempting to add columns to settings table..." . PHP_EOL;

try {
    // Check current columns
    $columns = Schema::getColumnListing('settings');
    echo "Current columns: " . implode(', ', $columns) . PHP_EOL;
    
    // Add missing columns directly with SQL
    if (!in_array('key', $columns)) {
        DB::statement('ALTER TABLE settings ADD COLUMN key TEXT');
        echo "Added 'key' column" . PHP_EOL;
    }
    
    if (!in_array('value', $columns)) {
        DB::statement('ALTER TABLE settings ADD COLUMN value TEXT');
        echo "Added 'value' column" . PHP_EOL;
    }
    
    if (!in_array('type', $columns)) {
        DB::statement('ALTER TABLE settings ADD COLUMN type TEXT DEFAULT \'text\'');
        echo "Added 'type' column" . PHP_EOL;
    }
    
    // Verify
    $columns = Schema::getColumnListing('settings');
    echo "Updated columns: " . implode(', ', $columns) . PHP_EOL;
    
    // Add unique constraint to key column
    if (in_array('key', $columns)) {
        try {
            DB::statement('CREATE UNIQUE INDEX settings_key_unique ON settings(key)');
            echo "Added unique index on 'key' column" . PHP_EOL;
        } catch (\Exception $e) {
            echo "Note: Unique index might already exist or there was an issue: " . $e->getMessage() . PHP_EOL;
        }
    }
    
    echo PHP_EOL . "SUCCESS: Settings table schema fixed!" . PHP_EOL;
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
}
