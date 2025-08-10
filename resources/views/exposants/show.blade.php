<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/724f54335b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/exposant-show.css') }}">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <!-- En-tête du stand -->
        <div class="stand-header">
            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1200&q=80" class="stand-banner" alt="Crêperie Bretonne">
            
            <div class="stand-info">
                <h1 class="stand-title">{{ $stand->nom_stand }}</h1>
                
                <div class="stand-owner">
                    <i class="fa-solid fa-user"></i>
                    <span>{{ $stand->user->nom_complet }}</span>
                </div>
                
                <p class="stand-description">
                    {{ $stand->description_stand }}
                </p>
                
                <div class="stand-meta">
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Stand B12</span>
                    </div>
                    {{-- <div class="meta-item">
                        <i class="fas fa-star"></i>
                        <span>4.8/5 (124 avis)</span>
                    </div> --}}
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>Ouvert jusqu'à 22h</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des produits -->
        <h2 class="section-title">Nos Spécialités</h2>
        
        <div class="products-grid">
            @foreach ($products as $product)
            <div class="product-card" data-id="{{ $product->id }}">
                <div class="product-image">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80" alt="Crêpe Nutella">
                </div>
                <div class="product-content">
                    <h3 class="product-title">{{ $product->nom_produit }}</h3>
                    <p class="product-description">
                        {{ $product->description }}
                    </p>
                    <div class="product-footer">
                        <span class="product-price">{{ $product->prix }} CFA</span>
                        <div class="quantity-selector">
                            <button class="quantity-btn minus">-</button>
                            <input type="number" class="quantity-input" value="0" min="0">
                            <button class="quantity-btn plus">+</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Panier -->
        <div class="cart-section">
            <div class="cart-header">
                <h3 class="cart-title">Votre Commande</h3>
                <span class="cart-count">0 article(s)</span>
            </div>
            
            <div class="cart-items">
                <!-- Affichage des articles du panier dynamiquement -->
                <p class="empty-cart-message">Votre panier est vide</p>
            </div>

            <div class="msg-order-success"></div>
            
            <div class="cart-total">
                <span>Total</span>
                <span>0.00 CFA</span>
            </div>
            
            <div class="bouttons">
                <button id="checkout-btn" class="btn btn-disabled" disabled>
                    Passer la commande
                </button>

                <button id="clear-cart" class="btn btn-clear btn-disabled" disabled>
                    Vider le panier
                </button>
            </div>
        </div>
    </div>




    <script src="{{ asset('js/stand-show.js') }}"></script>
</body>
</html>