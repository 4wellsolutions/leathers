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
        if (Schema::hasTable('redirects')) {
            Schema::table('redirects', function (Blueprint $table) {
                if (Schema::hasColumn('redirects', 'from_url') && !Schema::hasColumn('redirects', 'old_url')) {
                    $table->renameColumn('from_url', 'old_url');
                }
                if (Schema::hasColumn('redirects', 'to_url') && !Schema::hasColumn('redirects', 'new_url')) {
                    $table->renameColumn('to_url', 'new_url');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('redirects')) {
            Schema::table('redirects', function (Blueprint $table) {
                if (Schema::hasColumn('redirects', 'old_url') && !Schema::hasColumn('redirects', 'from_url')) {
                    $table->renameColumn('old_url', 'from_url');
                }
                if (Schema::hasColumn('redirects', 'new_url') && !Schema::hasColumn('redirects', 'to_url')) {
                    $table->renameColumn('new_url', 'to_url');
                }
            });
        }
    }
};
