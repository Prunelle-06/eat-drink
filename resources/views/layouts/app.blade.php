<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Mon Application')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- si tu as un css -->
</head>
<body>
    <header>
        <h1>Mon Application - @yield('title')</h1>
        <nav>
            <a href="{{ route('products.index') }}">Mes produits</a>
            <!-- ajoute d'autres liens utiles -->
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 Mon Application</p>
    </footer>
</body>
</html>
