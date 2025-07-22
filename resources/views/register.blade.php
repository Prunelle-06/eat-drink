<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset ('css/register.css') }}">
</head>
<body>
<body>
    @include('layouts.header', ['position' => 'relative'])
    <section>
        <div class="form-container">
            <h1 class="form-title">Demande de stand</h1>
            <form method="POST" action="{{ url('/inscription') }}">
                @csrf          
                {{-- Champs User --}}

                <div class="form-group">
                    <input type="text" name="nom_entreprise" value="{{ old('nom_entreprise') }}" placeholder="Nom de l'entreprise" required>
                </div>
                @error('nom_entreprise')
                    <p>{{ $message }}</p>
                @enderror
                
                <div class="form-group">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Adresse email" required>
                </div>
                @error('email')
                    <p>{{ $message }}</p>
                @enderror
                
                {{-- Champs Stand --}}
                <div class="form-group">
                    <input name="nom_stand" value="{{ old('nom_stand') }}" placeholder="Nom du stand" required>
                </div>
                @error('nom_stand')
                    <p>{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <textarea name="description_stand" value="{{ old('description_stand') }}" placeholder="Decrivez votre stand"></textarea>
                </div>
                @error('description_stand')
                    <p>{{ $message }}</p>
                @enderror
               
                <div class="form-group">
                    <input type="password" name="password" value="{{ old('password') }}" placeholder="Mot de passe" required>
                </div>
                @error('password')
                    <p>{{ $message }}</p>
                @enderror
                
                <div class="form-group">
                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirmer le mot de passe" required>
                </div>
                @error('password_confirmation')
                    <p>{{ $message }}</p>
                @enderror
                
                <button type="submit" class="submit-btn">Soumettre la demande</button>
            </form>
            
            <div class="form-footer">
                Déjà un compte ? <a href="">Connectez-vous</a>
            </div>
        </div>
    </section>

    @include('layouts.footer')


</body>
</html>