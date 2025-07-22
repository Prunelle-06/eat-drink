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
    <section style="display: flex; justify-content: center;">
        <section class="login-form">
            <h1>Connexion</h1>
            
            @if($errors->any())
                <div style="color: red; background: lightred; padding: 16px">
                    {{ $errors->first() }}
                </div>
            @endif

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
                
                <div class="form-group">
                    <input type="password" 
                        name="password" 
                        placeholder="Mot de passe" 
                        required>
                </div>

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
    </section>      
  
    @include('layouts.footer')
</body>
</html>
