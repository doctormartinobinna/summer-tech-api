{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mini project -Product/catalogue API')</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f6f8; color: #1f2937; }
        .nav { background: #111827; color: white; padding: 16px 40px; display: flex; align-items: center; gap: 20px; }
        .nav a { color: white; text-decoration: none; font-weight: bold; }
        .brand { margin-right: auto; font-weight: bold; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 10px 28px rgba(0,0,0,0.08); margin-bottom: 22px; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 9px; }
        textarea { min-height: 120px; }
        .btn { border: 0; background: #2563eb; color: white; padding: 11px 15px; border-radius: 9px; cursor: pointer; font-weight: bold; }
        .message { padding: 13px 15px; border-radius: 9px; margin: 14px 0; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .loading { background: #eff6ff; color: #1d4ed8; }
        .muted { color: #6b7280; }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="brand">Lecture Demo</div>
        <a href="{{ route('public.home') }}">Home</a>
        <a href="{{ route('public.catalogue') }}">Catalogue</a>
        <a href="{{ route('public.contact') }}">Contact</a>
        <a href="{{ route('blade.login') }}">Login</a>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>