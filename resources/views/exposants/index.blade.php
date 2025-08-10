<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/724f54335b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/exposant.css') }}">
</head>
<body>
    
    @include('layouts.header', ['position' => 'sticky'])

    <div class="container-exposant">
        <div class="page-header">
            <h1>Nos Exposants</h1>
            <p>Découvrez les stands participants à notre événement culinaire. Chaque stand propose des spécialités uniques préparées avec passion.</p>
        </div>

        <div class="stands-grid">
            @foreach ($users as $user)
            <a href="{{ route('stands.show', $user->stand) }}" class="stand-card">
                <div class="stand-badge">Nouveau</div>
                <div class="stand-image">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80" alt="">
                </div>
                <div class="stand-content">
                    <h3 class="stand-title">{{ $user->stand->nom_stand }}</h3>
                    <div class="stand-owner">
                        <i class="fas fa-user"></i>
                        <span>{{ $user->nom_complet }}</span>
                    </div>
                    <p class="stand-description">
                        {{ $user->stand->description_stand }}
                    </p>
                    <div class="stand-footer">
                        <div class="stand-products-count">
                            <i class="fas fa-utensils"></i>
                            <span>{{ $user->products->count() }} produits</span>
                        </div>
                        <span class="btn btn-primary">Voir le stand</span>
                    </div>
                </div>
            </a>
            @endforeach

        </div>
    </div>
    
      



  @include('layouts.footer')
    



    <script>
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const standCards = document.querySelectorAll('.stand-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                    }
                });
            }, { threshold: 0.1 });

            standCards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>
</html>