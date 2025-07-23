<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/exposant.css') }}">
</head>
<body>
    
    @include('layouts.header', ['position' => 'sticky'])
    <section>
        <div class="container">
        <h1>PLONGEZ DANS L'UNIVERS DE NOS STAND</h1>
        <p class="slogan">Laissez vous voyagez à travers chaque stand</p>
        <div class="ex">
            <ul class="categories">
                <li><button>Pâtisseries 🧁</button></li>
                <li><button>Desserts 🥞</button></li>
                <li><button> Boissons 🥤</button></li>
                <li><button>Végétarien 🥗</button></li>
                <li><button>Grillades 🥓</button></li>
                <li><button>Accompagnement 🍟</button></li>
            </ul>
        </div>
        <div class="global">
        @foreach($stands as $stand)
        <div class="card">
            <img src="{{ asset('images/ex5.jpg') }}" alt="stand culinaire">
            <h3>{{ $stand->nom_stand }}</h3>
            <p>⭐⭐⭐⭐👨🏼‍🍳- {{ $stand->nom_description }}</p>
            <div class="btn">
                <button class="produits">Produits</button>
                <button class="add-card">🛒 ajouter au panier</button>
            </div>
        </div>
        @endforeach
        
        
        
        {{-- <div class="card">
            <img src="{{ asset('images/ex4.jpg') }}" alt="stand culinaire">
            <h3>Restaurant l'art culinaire</h3>
            <p>⭐⭐⭐⭐👨🏼‍🍳-Spéliacisé dans la cuisine africaine</p>
            <div class="btn">
                <button class="produits">Produits</button>
                <button class="add-card">🛒 ajouter au panier</button>
            </div>
        </div>


        <div class="card">
            <img src="{{ asset('images/ex2.jpg') }}" alt="stand culinaire">
            <h3>Restaurant l'art culinaire</h3>
            <p>⭐⭐⭐⭐👨🏼‍🍳-Spéliacisé dans la cuisine africaine</p>
            <div class="btn">
                <button class="produits">Produits</button>
                <button class="add-card">🛒 ajouter au panier</button>
            </div>
        </div>
        
        <div class="card">
            <img src="{{ asset('images/ex11.jpg') }}" alt="stand culinaire">
            <h3>Restaurant l'art culinaire</h3>
            <p>⭐⭐⭐⭐🍴-Spéliacisé dans la cuisine africaine</p>
            <div class="btn">
                <button class="produits">Produits</button>
                <button class="add-card">🛒Ajouter au panier </button>
             </div>
            </div>    


        <div class="card">
            <img src="{{ asset('images/ex4.jpg') }}" alt="stand culinaire">
            <h3>Restaurant l'art culinaire</h3>
            <p>⭐⭐⭐⭐👨🏼‍🍳-Spéliacisé dans la cuisine africaine</p>
            <div class="btn">
                <button class="produits">Produits</button>
                <button class="add-card">🛒 ajouter au panier</button>
            </div>
        </div>


            
        <div class="card">
            <img src="{{ asset('images/ex8.jpg') }}" alt="stand culinaire">
            <h3>Restaurant l'art culinaire</h3>
            <p>⭐⭐⭐⭐👨🏼‍🍳-Spéliacisé dans la cuisine africaine</p>
            <div class="btn">
                <button class="produits">Produits</button>
                <button class="add-card">🛒 ajouter au panier</button>
            </div>
        </div>

                
        <div class="card">
            <img src="{{ asset('images/ex13.jpg') }}" alt="stand culinaire">
            <h3>Restaurant l'art culinaire</h3>
            <p>⭐⭐⭐🍱👨🏼‍🍳-Spéliacisé dans la cuisine africaine</p>
            <div class="btn">
                <button class="produits">Prdoduits</button>
                <button class="add-card">🛒 ajouter au panier</button>
            </div>
        </div>
        
        <div class="card">
            <img src="{{ asset('images/ex6.jpg') }}" alt="stand culinaire">
            <h3>Restaurant l'art culinaire</h3>
            <p>⭐⭐🍱👨🏼‍🍳-Spéliacisé dans la cuisine africaine</p>
            <div class="btn">
                <button class="produits">Produits</button>
                <button class="add-card">🛒 ajouter au panier</button>
            </div>
        </div> --}}
        </div>
        </div>

    

        
    </section>
    
      



  @include('layouts.footer')
    
</body>
</html>