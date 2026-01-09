<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display the inventory report interface
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.reports.index', compact('categories'));
    }

    /**
     * Generate inventory report (HTML view)
     */
    public function inventory(Request $request)
    {
        $categoryId = $request->get('category_id');
        $categories = Category::orderBy('name')->get();

        // Build query
        $query = Product::with(['category', 'colors.variants'])
            ->where('is_active', true);

        // Apply category filter if provided
        if ($categoryId && $categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        $products = $query->orderBy('name')->get();

        // Get selected category name for display
        $selectedCategory = null;
        if ($categoryId && $categoryId !== 'all') {
            $selectedCategory = Category::find($categoryId);
        }

        return view('admin.reports.inventory', compact('products', 'categories', 'categoryId', 'selectedCategory'));
    }

    /**
     * Generate and download inventory report PDF
     */
    public function inventoryPdf(Request $request)
    {
        $categoryId = $request->get('category_id');

        // Build query
        $query = Product::with(['category', 'colors.variants'])
            ->where('is_active', true);

        // Apply category filter if provided
        if ($categoryId && $categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        $products = $query->orderBy('name')->get();

        // Get selected category name for display
        $selectedCategory = null;
        if ($categoryId && $categoryId !== 'all') {
            $selectedCategory = Category::find($categoryId);
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.reports.pdf.inventory', compact('products', 'selectedCategory'))
            ->setPaper('a4', 'portrait');

        // Generate filename
        $filename = 'inventory-report-' . date('Y-m-d-His') . '.pdf';

        return $pdf->download($filename);
    }
}
