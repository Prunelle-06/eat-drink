<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil eat&drink</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<style>
    .login-form{
        min-height: 100vh;
    }
</style>
<body>
    @include('layouts.header')
    <section class="login-form">
        <h1>Connexion</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf
                    
            <div class="form-group">
                <input type="email" 
                    name="email" 
                    placeholder="Adresse email" 
                    value="{{ old('email') }}"
                    required
                    autofocus>
            </div>
            @error('email')
                <p>{{ $message }}</p>
            @enderror
            
            <div class="form-group">
                <input type="password" 
                    name="password" 
                    placeholder="Mot de passe" 
                    required>
            </div>
            @error('password')
                <p>{{ $message }}</p>
            @enderror

            <div class="form-group remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se souvenir de moi</label>
            </div>
            
            <button type="submit" class="submit-btn">Connexion</button>

            <div class="links">
                <a href="">Mot de passe oublié ?</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}">Créer un compte</a>
                @endif
            </div>
        </form>
    </section>      
  
    @include('layouts.footer')
</body>
</html>
