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
    {{-- @include('layouts.header', ['position' => 'relative']) --}}
    <a class="logo-link" href="{{ route('home') }}">
        <div class="logo">
            Taste<span>&</span>Stay
        </div>
    </a>
    <section id="main-section" 
            data-form-type="{{ old('form_type', 'exposant') }}"
            data-has-exposant-errors="{{ $errors->has('exposant_nom_complet') || $errors->has('exposant_email') || $errors->has('nom_stand') || $errors->has('description_stand') || $errors->has('image_stand') || $errors->has('exposant_password') || $errors->has('exposant_password_confirmation') ? 'true' : 'false' }}"
            data-has-visiteur-errors="{{ $errors->has('visiteur_nom_complet') || $errors->has('visiteur_email') || $errors->has('visiteur_password') || $errors->has('visiteur_password_confirmation') ? 'true' : 'false' }}"  
                >
        
        <div class="tabs">
            <button class="tab-btn active" data-tab="exposant">Demande de stand</button>
            <button class="tab-btn" data-tab="visiteur">Visiteur</button>
        </div>
        <!-- Formulaire Exposant -->
        <div class="tab-content active" id="exposant-tab">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf  
                <input type="hidden" name="form_type" value="exposant">

                {{-- Champs User --}}
                <div class="form-group visitor-form">
                    <input type="text" name="exposant_nom_complet" value="{{ old('exposant_nom_complet') }}" placeholder="Nom complet *">
                    @error('exposant_nom_complet')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group visitor-form">
                    <input type="email" name="exposant_email" value="{{ old('exposant_email') }}" placeholder="Adresse email *">
                    @error('exposant_email')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Champs Stand --}}
                <div class="form-group">
                    <input name="nom_stand" value="{{ old('nom_stand') }}" placeholder="Nom du stand *">
                    @error('nom_stand')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group file-section">
                    <div class="file-input-wrapper">
                        <input type="file" id="file1" name="image_stand" class="file-input">
                        <label for="file1" class="file-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Choisir une image du stand 
                        </label>
                        <div class="file-info" id="info1">Aucune image sélectionnée</div>
                    </div>
                    @error('image_stand')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <textarea name="description_stand" value="{{ old('description_stand') }}" placeholder="Decrivez votre stand *"></textarea>
                    @error('description_stand')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
               
                {{-- Champs mot de passe --}}
                <div class="form-group visitor-form">
                    <input type="password" name="exposant_password" value="{{ old('exposant_password') }}" placeholder="Mot de passe *">
                    @error('exposant_password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group visitor-form">
                    <input type="password" name="exposant_password_confirmation" value="{{ old('exposant_password_confirmation') }}" placeholder="Confirmer le mot de passe">
                    @error('exposant_password_confirmation')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn">Soumettre la demande</button>
            </form>
            
            <div class="form-footer">
                Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a>
            </div>
        </div>

        <!-- Formulaire Visiteur -->
        <div id="visiteur-tab" class="tab-content">
            <form class="visitor-form" action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="visiteur">
                <div class="form-group">
                    <input type="text" name="visiteur_nom_complet" value="{{ old('visiteur_nom_complet') }}" placeholder="Nom complet *">
                    @error('visiteur_nom_complet')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="email" name="visiteur_email" value="{{ old('visiteur_email') }}" placeholder="Adresse email *">
                    @error('visiteur_email')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="password" name="visiteur_password" value="{{ old('visiteur_password') }}" placeholder="Mot de passe *">
                    @error('visiteur_password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="password" name="visiteur_password_confirmation" value="{{ old('visiteur_password_confirmation') }}" placeholder="Confirmer le mot de passe *">
                    @error('visiteur_password_confirmation')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn">S'inscrire</button>
            </form>

            <div class="form-footer">
                Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a>
            </div>
        </div>
    </section>

    {{-- @include('layouts.footer') --}}



    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>