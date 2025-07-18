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

      <!--main content-->
    <main>
        <div class="global">
            <div class="description">
                <h1>WELCOME TO EAT&DRINK</h1>
                <p>Venez découvrir une variété de stands proposant des plats délicieux et des spécialités locales.Que vous soyez amateur de sucré ou de salé, il y en a pour tous les goûts !!</p><br><br> 
                <p> Plongez au coeur d'une experience sensorielle inoubliable.Notre évènement vous invite à explorer un univers de saveurs et de créations, où chaque stand raconte une histoire et chaque dégustation est une invitation au voyage. Laissez-vous surprendre </p>
            
            </div>
      <section class="gallery">
    <img src="{{ asset('images/ex11.jpg') }}" alt="Cupcake">
    <img src="{{ asset('images/ex2.jpg') }}" alt="Bonbons">
    <img src="{{ asset('images/ex3.jpg') }}" alt="Glace">
    <img src="{{ asset('images/ex4.jpg') }}" alt="Food Truck">
    <img src="{{ asset('images/ex5.jpg') }}" alt="Crêpes">
    <img src="{{ asset('images/ex6.jpg') }}" alt="Popcorn">
    <img src="{{ asset('images/ex7.jpg') }}" alt="Popcorn">
    <img src="{{ asset('images/ex8.jpg') }}" alt="Popcorn">
    <img src="{{ asset('images/ex12.jpg') }}" alt="pizza">
    <img src="{{ asset ('images/ex13.jpg') }}" alt="la">
  </section>
</div>
</main>
  


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