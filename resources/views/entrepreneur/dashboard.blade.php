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
                        {{-- <i class="fas fa-home"></i> --}}
                        <span>Tableau de bord</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i>
                        <span>Acceuil</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#produits">
                        <i class="fas fa-utensils"></i>
                        <span>Mes Produits</span>
                        <span class="badge">{{ $products->count() }}</span>
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
                <form action="{{ route('logout') }}" method="POST">
                    <div class="menu-item">
                        <button type="submit">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </button>
                    </div>
                </form>
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
                            <div class="value">{{ $products->count() }}</div>
                            <div class="label">Produits</div>
                        </div>
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header">
                    <h3>Commandes</h3>
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
                                <div class="product-line">2x Crêpe Nutella <span class="product-price">500 CFA</span></div>
                                <div class="product-line">1x Jus d'Orange <span class="product-price">300 CFA</span></div>
                                <div class="product-line">3x Beignet <span class="product-price">250 CFA</span></div>
                            </td>
                            <td>42,50 CFA</td>
                            <td><span class="status pending">En attente</span></td>
                            <td>12/06/20025</td>
                        </tr>
                        <tr>
                            <td>#ED-2539</td>
                            <td class="products-cell"> 
                                <div class="product-line">3x Beignet <span class="product-price">250 CFA</span></div>
                            </td>
                            <td>35,00 CFA</td>
                            <td><span class="status pending">En attente</span></td>
                            <td>11/06/20025</td>
                        </tr>
                        <tr>
                            <td>#ED-2535</td>
                            <td class="products-cell">
                                <div class="product-line">1x Jus d'Orange <span class="product-price">300 CFA</span></div>
                                <div class="product-line">3x Beignet <span class="product-price">250 CFA</span></div>
                            </td>
                            <td>28,75 CFA</td>
                            <td><span class="status pending">En attente</span></td>
                            <td>10/06/20025</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Top Products -->
            <div class="card" id="produits">
                <div class="card-header">
                    <h3>Mes produits</h3>
                    <a href="{{ route('products.create') }}">Ajouter un produit</a>
                </div>
                <div class="products-grid">
                    @foreach ($products as $product)                    
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('uploads/products/'.$product->iphoto) }}" alt="">
                        </div>
                        <div class="product-details">
                            <h3>{{ $product->nom_produit }}</h3>
                            <p>{{ $product->description  }}</p>
                            <div class="product-price">{{ $product->prix }} CFA</div>
                            <div class="product-actions">
                                <button class="btn btn-primary">
                                    <i class="fas fa-pen"></i> Modifier
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



</body>
</html>