<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset ('css/style.css') }}">
</head>
<body>
<body>
    <header>
      <nav class="navbar">
      <div class="logo">  
        <img src="{{ asset('images/edlogo1.png') }}" alt="un logo" id="logo" width="300">
      </div>
       <ul class="nav-links">
        <li><a href="{{ url('/inscription') }}" class="btn ">S'inscrire</a></li>
        <li><a href="#" class="btn ">View stand</a></li>
      </ul>
    </nav>
  </header>
      <main class="main-inscription">
    <div class="formulaire">
    <h1>Formulaire d'inscription</h1>
    <form method="POST" action="{{ url('/inscription') }}">
        @csrf
        <input type="text" name="nom" placeholder="Nom complet" required><br><br>
        <input type="email" name="email" placeholder="Adresse email" required><br><br>
        <input type="text" name="nom_entreprise" placeholder="Nom de l'entreprise" required><br><br>
        <textarea name="description_produit" placeholder="Décris tes produits ici..." required></textarea><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <input type="password" name="password_confirmation" placeholder="Confirmer mot de passe" required><br><br>
        <button type="submit">Soumettre la demande</button>
    </form>
</div>
<main>

</body>
</html>