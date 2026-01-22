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
        Schema::table('blogs', function (Blueprint $table) {
            // Rename columns if they exist
            if (Schema::hasColumn('blogs', 'author_id')) {
                $table->renameColumn('author_id', 'user_id');
            }

            if (Schema::hasColumn('blogs', 'is_published')) {
                $table->dropColumn('is_published');
            }

            // Add missing columns
            $table->string('status')->default('draft')->after('featured_image');
            $table->boolean('featured')->default(false)->after('views');
            $table->json('tags')->nullable()->after('meta_description');
            $table->json('gallery_images')->nullable()->after('featured_image');
            $table->boolean('allow_comments')->default(true)->after('featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->renameColumn('user_id', 'author_id');
            $table->boolean('is_published')->default(false);
            $table->dropColumn(['status', 'featured', 'tags', 'gallery_images', 'allow_comments']);
        });
    }
};
