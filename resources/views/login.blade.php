<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil eat&drink</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<style>
    .login-form{
        min-height: 100vh;
    }
</style>
<body>
    @include('layouts.header')
     <section class="login-form">
           <h1>Page Login</h1>
           <form method="POST" action="{{ url('/inscription') }}">
                @csrf          
                <div class="form-group">
                    <input type="text" name="nom" placeholder="Nom complet" required>
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" placeholder="Adresse email" required>
                </div>
                
                <div class="form-group">
                    <input type="text" name="nom_entreprise" placeholder="Nom de l'entreprise" required>
                </div>
                
                <div class="form-group">
                    <textarea name="description_produit" placeholder="Décris tes produits en quelques mots..." required></textarea>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                </div>
                
                <button type="submit" class="submit-btn">Soumettre la demande</button>
            </form>
     
        </section>       
  
    @include('layouts.footer')
</body>
</html>
