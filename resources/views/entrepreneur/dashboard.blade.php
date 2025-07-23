<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/724f54335b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <title>Document</title>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Eat&Drink</h2>
                <p>Tableau de bord entrepreneur</p>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item active">
                    <a href="#">
                        <i class="fas fa-home"></i>
                        <span>Tableau de bord</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#">
                        <i class="fas fa-utensils"></i>
                        <span>Mes Produits</span>
                        <span class="badge">3</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Commandes</span>
                        <span class="badge">5</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="">
                        <i class="fas fa-store"></i>
                        <span>Mon Stand</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>
            </div>
        </div>


        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Tableau de bord</h1>
                <div class="user-menu">                  
                    <div class="user-profile">
                        <div class="user-info">
                            <h4> {{ $userStand->nom_entreprise }} </h4>
                            <p> {{ $userStand->stand->nom_stand }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">24</div>
                            <div class="label">Commandes</div>
                        </div>
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">8</div>
                            <div class="label">Produits</div>
                        </div>
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header">
                    <h3>Commandes récentes</h3>
                    <a href="#">Voir tout</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Produits</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ED-2541</td>
                            <td class="products-cell">
                                <div class="product-line">2x Crêpe Nutella <span class="product-price">5.00 €</span></div>
                                <div class="product-line">1x Jus d'Orange <span class="product-price">3.00 €</span></div>
                                <div class="product-line">3x Beignet <span class="product-price">2.50 €</span></div>
                            </td>
                            <td>42,50 CFA</td>
                            <td><span class="status pending">En attente</span></td>
                            <td>12/06/20025</td>
                        </tr>
                        <tr>
                            <td>#ED-2539</td>
                            <td class="products-cell"> 
                                <div class="product-line">3x Beignet <span class="product-price">2.50 €</span></div>
                            </td>
                            <td>35,00 CFA</td>
                            <td><span class="status pending">En attente</span></td>
                            <td>11/06/20025</td>
                        </tr>
                        <tr>
                            <td>#ED-2535</td>
                            <td class="products-cell">
                                <div class="product-line">1x Jus d'Orange <span class="product-price">3.00 €</span></div>
                                <div class="product-line">3x Beignet <span class="product-price">2.50 €</span></div>
                            </td>
                            <td>28,75 CFA</td>
                            <td><span class="status pending">En attente</span></td>
                            <td>10/06/20025</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Top Products -->
            <div class="card">
                <div class="card-header">
                    <h3>Mes produits</h3>
                    <a href="#">Ajouter un produit</a>
                </div>
                <div class="products-grid">
                    <!-- Product 1 -->
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Produit">
                        </div>
                        <div class="product-details">
                            <h3>Crêpe au sucre</h3>
                            <p>Crêpe traditionnelle bretonne avec du beurre et du sucre</p>
                            <div class="product-price">3,50 CFA</div>
                            <div class="product-actions">
                                <button class="btn btn-primary">
                                    <i class="fas fa-pen"></i> Modifier
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 2 -->
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Produit">
                        </div>
                        <div class="product-details">
                            <h3>Crêpe Nutella</h3>
                            <p>Crêpe garnie de Nutella et de bananes fraîches</p>
                            <div class="product-price">5,00 CFA</div>
                            <div class="product-actions">
                                <button class="btn btn-primary">
                                    <i class="fas fa-pen"></i> Modifier
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 3 -->
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1615873968403-89e068629265?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Produit">
                        </div>
                        <div class="product-details">
                            <h3>Galette complète</h3>
                            <p>Galette de blé noir avec jambon, fromage et œuf</p>
                            <div class="product-price">7,50 CFA</div>
                            <div class="product-actions">
                                <button class="btn btn-primary">
                                    <i class="fas fa-pen"></i> Modifier
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>
</html>