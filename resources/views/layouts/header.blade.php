<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <title>Document</title>
</head>
<body>
    <!--header-->
    <header style="background: {{ $position ?? 'sticky' }};">
      <div class="container">
        <nav>
            <div class="logo">
                Eat<span>&</span>Drink
            </div>
            <div class="all-links">
              <div class="nav-links">
                <a href="#">L'evenement</a>
                <a href="#exposants">Exposants</a>
                <a href="#features">Fonctionnalités</a>
              </div>
              <div class="cta-button">
                <a href="/login">Connexion</a>
              </div>
            </div>
        </nav>
      </div>
    </header>
</body>
</html>