<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil eat&drink</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!--header-->
    <header>
      <div class="container">
        <nav>
            <div class="logo">
                Eat<span>&</span>Drink
            </div>
            <div class="all-links">
              <div class="nav-links">
              <a href="#features">Fonctionnalités</a>
              <a href="#">L'evenement</a>
              <a href="#exposants">Exposants</a>
              </div>
              <div class="cta-button">
                <a href="">Connexion</a>
              </div>
            </div>
        </nav>
      </div>
    </header>

    <!-- section hero -->
    <section class="hero">
      <div class="container">
          <h1>Gérez votre stand culinaire en toute simplicité</h1>
          <p>La plateforme complète pour les exposants et visiteurs de l'événement Eat&Drink. Inscrivez votre stand, gérez vos produits et recevez des commandes en ligne.</p>
          <div class="button-group">
              <a href="" class="btn btn-primary">Demander un stand</a>
              <a href="#exposants" class="btn btn-secondary">Voir les exposants</a>
          </div>
      </div>
    </section>

    {{-- Section Fonctionnalités --}}
    <section class="features" id="features">
      <div class="container">
        <h2 class="section-title">Comment ça marche ?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <h3>1. Demande de stand</h3>
                <p>Inscrivez votre entreprise en ligne. Votre compte sera activé après validation par notre équipe.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🍽️</div>
                <h3>2. Gestion des produits</h3>
                <p>Ajoutez, modifiez ou supprimez vos produits depuis votre espace personnel.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛒</div>
                <h3>3. Recevez des commandes</h3>
                <p>Les visiteurs peuvent réserver vos produits directement via la plateforme.</p>
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
                  Notre plateforme digitale vous permet de gérer entièrement votre participation à l'événement Eat&Drink.
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
                  <a href="" class="btn btn-primary">Accéder à mon espace</a>
              @else
                  <a href="" class="btn btn-primary">S'inscrire comme exposant</a>
              @endauth
          </div>
          <div class="info-image">
              <img src="{{ asset('images/ex5.jpg') }}" alt="Stand culinaire">
          </div>
        </div>
      </div>
    </section>
  


  <footer>
    <div class="footer-content">
      <p>&copy; 2025 Fête des Gourmandises. Tous droits réservés.</p>
      <div class="socials">
        <a href="#">Instagram</a>
        <a href="#">Facebook</a>
        <a href="#">Contact</a>
      </div>
    </div>
  </footer> 
</body>
</html>