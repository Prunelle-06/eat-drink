<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/724f54335b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard-visiteur.css') }}">
    <title>Document</title>
</head>
<body>
    <div class="dashboard">
        @if (Session::has('success'))
            <p class="flash-message">{{ Session::get('success') }}</p>
        @endif
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                Taste<span>&</span>Stay
            </div>
            <ul class="nav-menu">
                <li class="nav-item active">
                    Tableau de bord
                </li>
                <li class="nav-item">
                    <i class="fa-solid fa-home"></i> Accueil
                </li>
                <li class="nav-item">
                    <i class="fa-solid fa-user"></i> Profil
                </li>
                <a href="#favoris">
                    <li class="nav-item">
                        <i class="fa-solid fa-heart"></i> Favoris
                        <span class="badge">5</span>
                    </li>
                </a>
                <a href="#commandes">
                    <li class="nav-item">
                        <i class="fa-solid fa-cart-arrow-down"></i> Commandes
                        <span class="badge">5</span>
                    </li>
                </a>
                <li class="nav-item" style="color: #FA003F;">
                    <i class="fas fa-sign-out-alt" style="color: #FA003F;"></i> Déconnexion
                </li>
            </ul>
        </aside>

        <!-- Main Contenu -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="user-profile">
                    <span>Bonjour, Emma!</span>
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profil" class="user-avatar">
                </div>
            </header>

            <!-- Statistiques -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>12</h3>
                    <p>Stands visités</p>
                </div>
                <div class="stat-card">
                    <h3>7</h3>
                    <p>Favoris</p>
                </div>
                <div class="stat-card">
                    <h3>3</h3>
                    <p>Commandes en cours</p>
                </div>
            </div>
            
            <!-- Stands Favoris -->
            <h2 class="section-title" id="favoris">
                <i class="fa-solid fa-heart" style="color: #eb0a0a;"></i> Vos stands favoris
            </h2>
            <div class="stands-grid">
            <a href="" class="stand-card">
                <div class="stand-image">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80" alt="">
                </div>
                <div class="stand-content">
                    <h3 class="stand-title">Fromagerie du Val</h3>
                    <div class="stand-owner">
                        <i class="fas fa-user"></i>
                        <span>Georges Junior</span>
                    </div>
                    <p class="stand-description">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit placeat omnis blanditiis repellendus, fugit iure modi fugiat ipsa. Mollitia, aliquid.
                    </p>
                    <div class="stand-footer">
                        <div class="stand-products-count">
                            <i class="fas fa-utensils"></i>
                            <span>10 produits</span>
                        </div>
                        <span class="btn btn-primary">Voir le stand</span>
                    </div>
                </div>
            </a>
            </div>

        <div class="orders-container" id="commandes">
            <h1 class="section-title">
                <i class="fa-solid fa-cart-arrow-down"></i> Mes Commandes
            </h1>

            <!-- Commande 1 -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">Commande #ED-48921</span>
                        <span class="order-date">12 août 2023 à 10:30</span>
                    </div>
                    <span class="order-status status-delivered">Livrée</span>
                </div>
                <div class="order-details">
                    <div class="order-items">
                        <div class="order-item">
                            <span class="item-name">Assortiment fromages AOP</span>
                            <span class="item-price">24,90 CFA</span>
                        </div>
                        <div class="order-item">
                            <span class="item-name">Bouteille Chardonnay</span>
                            <span class="item-price">18,50 CFA</span>
                        </div>
                        <div class="order-item">
                            <span class="item-name">Frais de livraison</span>
                            <span class="item-price">5,00 CFA</span>
                        </div>
                    </div>
                    <div class="order-total">
                        <span class="total-label">Total</span>
                        <span class="total-amount">48,40 CFA</span>
                    </div>
                    <div class="order-actions">
                        <button class="action-btn btn-primary">Commander à nouveau</button>
                        <button class="action-btn btn-secondary">Contacter le stand</button>
                    </div>
                </div>
            </div>

            <!-- Commande 2 -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">Commande #ED-48765</span>
                        <span class="order-date">11 août 2023 à 15:15</span>
                    </div>
                    <span class="order-status status-pending">En attente</span>
                </div>
                <div class="order-details">
                    <div class="order-items">
                        <div class="order-item">
                            <span class="item-name">Pizza Napolitaine</span>
                            <span class="item-price">14,90 CFA</span>
                        </div>
                        <div class="order-item">
                            <span class="item-name">Tiramisu</span>
                            <span class="item-price">7,50 CFA</span>
                        </div>
                    </div>
                    <div class="order-total">
                        <span class="total-label">Total</span>
                        <span class="total-amount">22,40 CFA</span>
                    </div>
                    <div class="order-actions">
                        <button class="action-btn btn-primary">Suivre ma commande</button>
                        <button class="action-btn btn-secondary">Contacter le stand</button>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>




    <script src="{{ asset('js/dashboard-visiteur.js') }}"></script>
</body>
</html>