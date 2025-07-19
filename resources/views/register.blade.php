<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset ('css/style.css') }}">
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
                {{-- <div class="form-group">
                    <input type="text" name="nom" placeholder="Nom complet" required>
                </div> --}}

                <div class="form-group">
                    <input type="text" name="mon_entreprise" placeholder="Nom de l'entreprise" required>
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" placeholder="Adresse email" required>
                </div>
                
                <div class="form-group">
                    <input name="nom_stand" placeholder="Nom du stand" required>
                </div>

                <div class="form-group">
                    <textarea name="description_stand" placeholder="Decrivez votre stand" required></textarea>
                </div>
               
                <div class="form-group">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                </div>
                
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