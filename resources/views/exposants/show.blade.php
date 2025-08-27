<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" charset="UTF-8">
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
            
            <div class="stand-info" data-stand-id="{{ $stand->id }}" data-user-id="{{ $stand->user->id }}">
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
        
        @if($products->count() > 0) 
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
        @else
        <div class="no-products-container">
            <div class="no-products-content">
                <div class="no-products-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                </div>
                <h3 class="no-products-title">Aucun produit disponible</h3>
                <p class="no-products-message">Ce stand ne contient aucun produit pour le moment.</p>
            </div>
        </div>
        @endif

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

            <div class="total-plus-coasts">
                <span>Total + Frais</span>
                <span>0.00 CFA</span>
            </div>
            
            <div class="bouttons">
                <button id="checkout-btn" class="btn btn-disabled" disabled>
                    <i class="fas fa-shopping-cart"></i>
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