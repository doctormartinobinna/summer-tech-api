<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blade API Consumption')</title>

    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f8; color: #222; }
        .navbar { background: #111827; color: white; padding: 16px 40px; display: flex; gap: 20px; align-items: center; }
        .navbar a { color: white; text-decoration: none; font-weight: bold; }
        .container { max-width: 1100px; margin: 30px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .message { padding: 12px 14px; border-radius: 8px; margin-bottom: 15px; }
        .loading { background: #eff6ff; }
        .error { background: #fee2e2; color: #991b1b; }
        .empty { background: #fef3c7; color: #92400e; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f9fafb; }
        img.product-image { width: 70px; height: 55px; object-fit: cover; border-radius: 8px; background: #e5e7eb; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 8px 12px; border-radius: 8px; text-decoration: none; }
        .muted { color: #6b7280; }
    </style>
</head>
<body>
    <div class="navbar">
        <strong>Product Catalogue</strong>
        <a href="{{ route('blade.products.index') }}">Products</a>
        <a href="{{ route('blade.categories.index') }}">Categories</a>
    </div>

    <main class="container">
        @yield('content')
    </main>
    
</body>
</html>