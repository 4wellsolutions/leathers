<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('media')) {
            Schema::create('media', function (Blueprint $table) {
                $table->id();
                $table->string('file_name');
                $table->string('file_path');
                $table->string('file_type'); // image, video, document
                $table->string('mime_type');
                $table->integer('file_size'); // in bytes
                $table->string('alt_text')->nullable();
                $table->text('caption')->nullable();
                $table->text('description')->nullable();
                $table->integer('width')->nullable();
                $table->integer('height')->nullable();
                $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
                $table->timestamps();
                
                $table->index('file_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
