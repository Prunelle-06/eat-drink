<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/pending.css') }}">
</head>
<body>
    @include('layouts.header')

    @if (Session::has('success'))
        <p class="flash-message">{{ Session::get('success') }}</p>
    @endif
    
    <div class="waiting-container">
        <div class="waiting-header">
            <h1>Votre demande est en cours de traitement</h1>
        </div>
        
        <div class="waiting-content">
            <div class="status-card">
                <div class="status-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                    </svg>
                </div>
                
                <div class="status-message">
                    <p>Votre demande de stand a bien été enregistrée.</p>
                    <p>Notre équipe examine actuellement votre profil et vos informations.</p>
                </div>
            </div>
            
            <div class="admin-contact">
                <h3>Besoin d'aide ?</h3>
                <p>Contactez notre équipe à <a href="">equip@eatdrink.com</a> pour toute question concernant votre demande.</p>
                <p>Temps de traitement moyen : 24-48 heures</p>
            </div>
        </div>
    </div>


    
</body>
</html>