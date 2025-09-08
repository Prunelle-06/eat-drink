<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('layouts.header', ['position' => 'sticky'])
    <!-- section hero -->
    <section class="hero">
      <div class="container">
          <h1>Gérez votre stand culinaire en toute simplicité</h1>
          <p>Découvrez, commandez et gérez votre participation sur Taste&Stay - La plateforme complète pour exposants et visiteurs</p>
          <div class="button-group">
              <a href="{{ route('register') }}" class="btn btn-primary">Demander un stand</a>
              <a href="{{ url('/stands') }}" class="btn btn-secondary">Voir les exposants</a>
          </div>
      </div>
    </section>

    {{-- Section Fonctionnalités --}}
    <section class="features" id="features">
      <div class="container">
        <h2 class="section-title">Comment ça marche ?</h2>
         <div class="user-type-selector">
                <div class="user-card" onclick="location.href='{{ route('register') }}?type='">
                    <div class="user-icon">👨‍🍳</div>
                    <h3>Exposant</h3>
                    <p>Gérez votre stand et vos produits</p>
                    <span class="badge">Professionnel</span>
                </div>
                
                <div class="user-card" onclick="location.href='{{ route('register') }}?type='">
                    <div class="user-icon">👋</div>
                    <h3>Visiteur</h3>
                    <p>Accédez à des avantages exclusifs</p>
                    <span class="badge">Particulier</span>
                </div>
                
                <div class="user-card" onclick="location.href='{{ url('/stands') }}'">
                    <div class="user-icon">🛒</div>
                    <h3>Visiteur anonyme</h3>
                    <p>Commencez à explorer</p>
                    <span class="badge">Sans inscription</span>
                </div>
            </div>
        </div>
      </div>
    </section>

    <!-- Section Statistiques -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3 data-count="150">0</h3>
                    <p>Stands disponibles</p>
                </div>
                <div class="stat-card">
                    <h3 data-count="5000">0</h3>
                    <p>Produits uniques</p>
                </div>
                <div class="stat-card">
                    <h3 data-count="98">0</h3>
                    <p>% de satisfaction</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Fonctionnalités multi-utilisateurs -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Une expérience adaptée à chacun</h2>
            
            <div class="role-tabs">
                <button class="tab-btn active" data-tab="exhibitor">Exposants</button>
                <button class="tab-btn" data-tab="visitor">Visiteurs</button>
            </div>
            
            <div class="tab-content active" id="exhibitor-tab">
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📋</div>
                        <h3>Demande de stand</h3>
                        <p>Inscrivez votre entreprise en ligne. Votre compte sera activé après validation par notre équipe.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📱</div>
                        <h3>Dashboard complet</h3>
                        <p>Gérez vos produits, commandes et statistiques en temps réel et performances de votre stand.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🤝</div>
                        <h3>Réseau professionnel</h3>
                        <p>Connectez-vous avec d'autres exposants et commandez leurs produits.</p>
                    </div>
                </div>
            </div>
            
            <div class="tab-content" id="visitor-tab">
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🛒</div>
                        <h3>Faites vos commandes</h3>
                        <p>Vous pouvez commandez des produits directement via la plateforme.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">💳</div>
                        <h3>Paiement sécurisé</h3>
                        <p>Commandez en quelques clics avec notre système de paiement intégré.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🧾</div>
                        <h3>Historique digital</h3>
                        <p>Conservez trace de tous vos achats et découvertes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section CTA -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <h2>Prêt à vivre l'expérience Taste&Stay ?</h2>
                <p>Inscrivez-vous dès maintenant en tant qu'exposant ou visiteur privilégié</p>
                <div class="cta-buttons">
                    <a href="/inscription#exposant" class="btn btn-primary">Devenir exposant</a>
                    <a href="/inscription#visiteur" class="btn btn-secondary">S'inscrire comme visiteur</a>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Section Info --}}
     <section class="info-section" id="event">
      <div class="container">
        <div class="info-container">
          <div class="info-content">
              <h2>Pour les exposants</h2>
              <p>
                  Notre plateforme digitale vous permet de gérer entièrement votre participation à l'événement Taste&Stay.
                  Plus besoin de paperasse, tout se fait en ligne.
              </p>
              <p>
                  Une fois votre compte approuvé, vous pourrez :
              </p>
              <ul style="margin: 20px 0 35px 20px;">
                  <li>Modifier les informations de votre stand</li>
                  <li>Ajouter vos produits avec photos et descriptions</li>
                  <li>Consulter les commandes passées par les visiteurs</li>
              </ul>
              @auth
                  <a href="{{ route('dashboard.exposant') }}" class="btn btn-primary">Accéder à mon espace</a>
              @else
                  <a href="" class="btn btn-primary">S'inscrire comme exposant</a>
              @endauth
          </div>
          <div class="info-image">
              <img src="{{ asset('images/img.png') }}" alt="">
          </div>
        </div>
      </div>
    </section>

    <!-- Section Témoignages -->
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">Ce qu'ils disent de nous</h2>
            <div class="testimonial-slider">
                {{-- Affichage dynamique des témoignages --}}
            </div>
        </div>
    </section>

    @include('layouts.footer')




    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>