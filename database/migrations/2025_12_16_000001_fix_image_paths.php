<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix products table - remove 'storage/' prefix from image paths
        DB::table('products')->whereNotNull('image')->each(function ($product) {
            $image = $product->image;

            // Remove 'storage/' prefix if it exists
            if (str_starts_with($image, 'storage/')) {
                $newImage = substr($image, 8); // Remove first 8 characters ('storage/')
                DB::table('products')->where('id', $product->id)->update(['image' => $newImage]);
            }
        });

        // Fix products table - remove 'storage/' prefix from images array
        DB::table('products')->whereNotNull('images')->each(function ($product) {
            $images = json_decode($product->images, true);

            if (is_array($images)) {
                $updated = false;
                $newImages = array_map(function ($image) use (&$updated) {
                    if (str_starts_with($image, 'storage/')) {
                        $updated = true;
                        return substr($image, 8);
                    }
                    return $image;
                }, $images);

                if ($updated) {
                    DB::table('products')->where('id', $product->id)->update(['images' => json_encode($newImages)]);
                }
            }
        });

        // Fix products table - size_guide_image
        DB::table('products')->whereNotNull('size_guide_image')->each(function ($product) {
            $image = $product->size_guide_image;

            if (str_starts_with($image, 'storage/')) {
                $newImage = substr($image, 8);
                DB::table('products')->where('id', $product->id)->update(['size_guide_image' => $newImage]);
            }
        });

        // Fix product_colors table
        DB::table('product_colors')->whereNotNull('image')->each(function ($color) {
            $image = $color->image;

            if (str_starts_with($image, 'storage/')) {
                $newImage = substr($image, 8);
                DB::table('product_colors')->where('id', $color->id)->update(['image' => $newImage]);
            }
        });

        // Fix blogs table - featured_image
        if (Schema::hasTable('blogs')) {
            DB::table('blogs')->whereNotNull('featured_image')->each(function ($blog) {
                $image = $blog->featured_image;

                if (str_starts_with($image, 'storage/')) {
                    $newImage = substr($image, 8);
                    DB::table('blogs')->where('id', $blog->id)->update(['featured_image' => $newImage]);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add 'storage/' prefix back (if needed for rollback)
        DB::table('products')->whereNotNull('image')->each(function ($product) {
            $image = $product->image;

            if (!str_starts_with($image, 'storage/') && !str_starts_with($image, 'http')) {
                DB::table('products')->where('id', $product->id)->update(['image' => 'storage/' . $image]);
            }
        });
    }
};
