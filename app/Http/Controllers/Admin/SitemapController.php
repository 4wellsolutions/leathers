<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category};
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::where('is_active', true)->count(),
            'categories' => Category::count(),
            'pages' => 3, // Static pages count
            'total_urls' => Product::where('is_active', true)->count() + Category::count() + 3,
            'sitemaps_generated' => $this->countGeneratedSitemaps(),
        ];

        return view('admin.sitemap.index', compact('stats'));
    }

    protected function countGeneratedSitemaps()
    {
        $count = 0;
        $sitemaps = ['sitemap.xml', 'sitemap-pages.xml', 'sitemap-categories.xml', 'sitemap-products.xml'];
        foreach ($sitemaps as $sitemap) {
            if (file_exists(public_path($sitemap))) {
                $count++;
            }
        }
        return $count;
    }

    public function generate()
    {
        $baseUrl = config('app.url');
        
        // Generate Categories Sitemap
        $this->generateCategoriesSitemap();
        
        // Generate Products Sitemap
        $this->generateProductsSitemap();
        
        // Generate Pages Sitemap
        $this->generatePagesSitemap();
        
        // Generate Sitemap Index
        $this->generateSitemapIndex();

        return redirect()->route('admin.sitemap.index')->with('success', 'All sitemaps generated successfully');
    }

    protected function generateCategoriesSitemap()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . route('category.show', $category->slug) . '</loc>';
            $sitemap .= '<lastmod>' . $category->updated_at->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
        }

        $sitemap .= '</urlset>';
        file_put_contents(public_path('sitemap-categories.xml'), $sitemap);
    }

    protected function generateProductsSitemap()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $products = Product::where('is_active', true)->get();
        foreach ($products as $product) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . route('products.show', $product->slug) . '</loc>';
            $sitemap .= '<lastmod>' . $product->updated_at->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.7</priority>';
            $sitemap .= '</url>';
        }

        $sitemap .= '</urlset>';
        file_put_contents(public_path('sitemap-products.xml'), $sitemap);
    }

    protected function generatePagesSitemap()
    {
        $baseUrl = config('app.url');
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . $baseUrl . '</loc>';
        $sitemap .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
        $sitemap .= '<changefreq>daily</changefreq>';
        $sitemap .= '<priority>1.0</priority>';
        $sitemap .= '</url>';

        // Static pages
        $pages = [
            ['url' => '/about', 'priority' => '0.6'],
            ['url' => '/contact', 'priority' => '0.6'],
            ['url' => '/shop', 'priority' => '0.9'],
        ];

        foreach ($pages as $page) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . $baseUrl . $page['url'] . '</loc>';
            $sitemap .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>monthly</changefreq>';
            $sitemap .= '<priority>' . $page['priority'] . '</priority>';
            $sitemap .= '</url>';
        }

        $sitemap .= '</urlset>';
        file_put_contents(public_path('sitemap-pages.xml'), $sitemap);
    }

    protected function generateSitemapIndex()
    {
        $baseUrl = config('app.url');
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $sitemaps = [
            'sitemap-pages.xml',
            'sitemap-categories.xml',
            'sitemap-products.xml',
        ];

        foreach ($sitemaps as $sitemapFile) {
            $filePath = public_path($sitemapFile);
            if (file_exists($filePath)) {
                $sitemap .= '<sitemap>';
                $sitemap .= '<loc>' . $baseUrl . '/' . $sitemapFile . '</loc>';
                $sitemap .= '<lastmod>' . date('c', filemtime($filePath)) . '</lastmod>';
                $sitemap .= '</sitemap>';
            }
        }

        $sitemap .= '</sitemapindex>';
        file_put_contents(public_path('sitemap.xml'), $sitemap);
    }

    public function download()
    {
        $filePath = public_path('sitemap.xml');
        
        if (!file_exists($filePath)) {
            return redirect()->route('admin.sitemap.index')->with('error', 'Sitemap not found. Please generate it first.');
        }

        return response()->download($filePath);
    }
}
