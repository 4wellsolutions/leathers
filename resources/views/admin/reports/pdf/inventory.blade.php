<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #d4af37;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #1a1a1a;
            margin-bottom: 5px;
        }

        .header .company {
            font-size: 18px;
            color: #d4af37;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .header .meta {
            font-size: 11px;
            color: #666;
        }

        .category-info {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #d4af37;
        }

        .category-info h2 {
            font-size: 14px;
            color: #333;
            margin-bottom: 3px;
        }

        .category-info p {
            font-size: 11px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background: #2a2a2a;
            color: white;
        }

        thead th {
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        tbody tr {
            border-bottom: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody td {
            padding: 10px 8px;
            vertical-align: top;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .product-name {
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 3px;
        }

        .product-sku {
            font-size: 10px;
            color: #999;
        }

        .category-badge {
            display: inline-block;
            background: #d4af37;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .color-item {
            margin-bottom: 5px;
            font-size: 11px;
        }

        .color-swatch {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 1px solid #999;
            margin-right: 5px;
            vertical-align: middle;
        }

        .size-info {
            font-size: 10px;
            margin-bottom: 3px;
        }

        .size-label {
            font-weight: bold;
            color: #333;
        }

        .stock-in {
            color: #28a745;
            font-weight: bold;
        }

        .stock-out {
            color: #dc3545;
            font-weight: bold;
        }

        .no-data {
            color: #999;
            font-style: italic;
            font-size: 11px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company">LEATHERS.PK</div>
        <h1>Inventory Report</h1>
        <div class="meta">
            Generated on {{ date('F d, Y - h:i A') }}
        </div>
    </div>

    @if($selectedCategory)
        <div class="category-info">
            <h2>Category: {{ $selectedCategory->name }}</h2>
            <p>Total Products: {{ $products->count() }}</p>
        </div>
    @else
        <div class="category-info">
            <h2>All Categories</h2>
            <p>Total Products: {{ $products->count() }}</p>
        </div>
    @endif

    @if($products->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="10%">Image</th>
                    <th width="25%">Product</th>
                    <th width="15%">Category</th>
                    <th width="20%">Colors</th>
                    <th width="30%">Sizes & Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->image)
                                <img src="{{ public_path(str_replace(url('/'), '', $product->image_url)) }}"
                                    alt="{{ $product->name }}" class="product-image">
                            @else
                                <div style="width: 50px; height: 50px; background: #e0e0e0; border-radius: 4px;"></div>
                            @endif
                        </td>
                        <td>
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-sku">SKU: {{ $product->id }}</div>
                        </td>
                        <td>
                            <span class="category-badge">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            @if($product->colors->count() > 0)
                                @foreach($product->colors as $color)
                                    <div class="color-item">
                                        <span class="color-swatch" style="background-color: {{ $color->color_code }};"></span>
                                        {{ $color->name }}
                                    </div>
                                @endforeach
                            @else
                                <span class="no-data">No colors</span>
                            @endif
                        </td>
                        <td>
                            @if($product->colors->count() > 0)
                                @foreach($product->colors as $color)
                                    @if($color->variants->count() > 0)
                                        <div style="margin-bottom: 8px;">
                                            <div style="font-weight: bold; font-size: 10px; margin-bottom: 2px;">{{ $color->name }}:</div>
                                            @foreach($color->variants as $variant)
                                                <div class="size-info">
                                                    <span class="size-label">{{ $variant->size }}</span> -
                                                    <span class="{{ $variant->stock > 0 ? 'stock-in' : 'stock-out' }}">
                                                        {{ $variant->stock }} units
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <span class="{{ $product->stock > 0 ? 'stock-in' : 'stock-out' }}">
                                    {{ $product->stock }} units
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 40px; color: #999;">
            <p>No products found for the selected filters.</p>
        </div>
    @endif

    <div class="footer">
        <p>&copy; {{ date('Y') }} LEATHERS.PK - Inventory Report - Page <span class="pagenum"></span></p>
    </div>
</body>

</html>