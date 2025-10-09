<!DOCTYPE html>
<html lang="en">
<head>
    {{-- @auth
        <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
        <script>
            window.OneSignalDeferred = window.OneSignalDeferred || [];
            OneSignalDeferred.push(async function(OneSignal) {
                await OneSignal.init({
                appId: "98be7eba-f9b7-45d9-aaa1-0e63fc3d7263",
                });

                try {
                    // Lier l'utilisateur
                    await OneSignal.login("{{ Auth::id() }}");
                    
                } catch(error) {
                    console.error("Erreur OneSignal:", error);
                }
            });
        </script>
    @endauth --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    {{-- @include('layouts.header') --}}

    @if (Session::has('error'))
        <p class="error-message">{{ Session::get('error') }}</p>
    @endif
    @if (Session::has('success'))
        <p class="flash-message">{{ Session::get('success') }}</p>
    @endif

    <main>
        <a class="logo-link" href="{{ route('home') }}">
            <div class="logo">
                Taste<span>&</span>Stay
            </div>
        </a>
        <section class="login-form">
            <h1>Connexion</h1>
            
            @if($errors->any())
                <div class="error-message">
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
    </main>      
  
    {{-- @include('layouts.footer') --}}
</body>
</html>
