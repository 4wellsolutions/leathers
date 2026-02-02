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
        Schema::table('coupons', function (Blueprint $table) {
            $table->integer('usage_limit')->nullable()->comment('Max number of times coupon can be used. Null for unlimited.');
            $table->integer('used_count')->default(0)->comment('Number of times coupon has been used.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['usage_limit', 'used_count']);
        });
    }
};
