<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Table 'settings' exists: " . (Schema::hasTable('settings') ? 'Yes' : 'No') . PHP_EOL;

if (Schema::hasTable('settings')) {
    $columns = Schema::getColumnListing('settings');
    echo "Columns: " . implode(', ', $columns) . PHP_EOL;
    
    // Check create statement
    // SQLite specific
    $result = DB::select("SELECT sql FROM sqlite_master WHERE type='table' AND name='settings'");
    if (!empty($result)) {
        echo "Create SQL: " . $result[0]->sql . PHP_EOL;
    }
}
