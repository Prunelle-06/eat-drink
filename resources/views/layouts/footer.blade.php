<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <title>Document</title>
</head>
<body>
    <!-- Footer -->
    <footer class="main-footer" id="contact">
      <div class="container">
        <div class="footer-content">
          <div class="footer-column">
            <h3>Taste&Stay</h3>
            <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 20px;">
                La plateforme de gestion des stands pour l'événement culinaire annuel.
            </p>
            <div class="contact-info">
                <div class="contact-item">📧 equip@tastestay.com</div>
                <div class="contact-item">📞 +57 96 79 00</div>
                <div class="contact-item">🏢 123 Rue Saint-Michel, Cotonou</div>
            </div>
          </div>
          <div class="footer-column">
            <h3>Navigation</h3>
            <ul class="footer-links">
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ route('stands.index') }}">Exposants</a></li>
                <li><a href="#features">Fonctionnalités</a></li>
            </ul>
          </div>
          <div class="footer-column">
            <h3>Compte</h3>
            <ul class="footer-links">
              <li><a href="{{ route('login') }}">Connexion</a></li>
              <li><a href="{{ route('register') }}">Inscription</a></li>
              <li><a href="#">Mot de passe oublié</a></li>
            </ul>
          </div>
        </div>
        <div class="copyright">
            © 2025 Taste&Stay. Tous droits réservés.
        </div>
      </div>
    </footer>
</body>
</html>