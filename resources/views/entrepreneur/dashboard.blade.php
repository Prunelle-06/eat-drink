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
                <h2>Taste&Stay</h2>
                <p>Tableau de bord entrepreneur</p>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <span>{{ $userInfo->nom_complet }}</span>
                </div>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item active">
                    <a href="#board">
                        {{-- <i class="fas fa-home"></i> --}}
                        <span>Tableau de bord</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <span>Acceuil</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#produits">
                        <i class="fas fa-utensils"></i>
                        <span>Mes Produits</span>
                        <span class="badge">{{ $userInfo->products->count() }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#commandes">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Commandes</span>
                        <span class="badge">{{ $orders->count() }}</span>
                    </a>
                </div>
                {{-- <div class="menu-item">
                    <a href="{{ route('dashboard.stand.show', $userInfo->stand) }}">
                        <i class="fas fa-store"></i>
                        <span>Mon Stand</span>
                    </a>
                </div> --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div class="menu-item logout-item">
                        <button type="submit">
                            <i class="fas fa-sign-out-alt" style="color: #b80000;"></i>
                            <span>Déconnexion</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Main Content -->
        <div class="main-content">
            @if (Session::has('success'))
                <p class="flash-message">{{ Session::get('success') }}</p>
            @endif
            <!-- Header -->
            <div id="board" class="header">
                <h1>Tableau de bord</h1>
                <div class="user-menu">                  
                    <div class="user-profile">
                        <div class="user-info">
                            <p> {{ $userInfo->stand->nom_stand }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Stats Cards -->
            <div class="stats-cards" id="commandes">
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} CFA</div>
                            <div class="label">Chiffre d'affaires</div>
                        </div>
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 65%"></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ $orders->count() }}</div>
                            <div class="label">Commandes</div>
                        </div>
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ $userInfo->products->count() }}</div>
                            <div class="label">Produits</div>
                        </div>
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">4.8</div>
                            <div class="label">Note moyenne</div>
                        </div>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 96%"></div>
                    </div>
                </div>
            </div>

            <!-- Commandes -->
            <div class="card">
                <div class="card-header">
                    <h3>Commandes</h3>
                </div>
                @if($orders->count() > 0) 
                <table class="table">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Client</th>
                            <th>Produits</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)                     
                        <tr> 
                            <td>#{{ $order->order_number }}</td>
                            <td>{{ $order->user->nom_complet }}</td>
                            <td class="products-cell">
                                <div class="products-container">
                                    <div class="products-preview" data-order-id="{{ $order->id }}">
                                        @foreach ($order->items as $index => $product)
                                            <div class="product-line" 
                                                @if($index >= 2) style="display: none;" @endif>
                                                {{ $product->quantity }}x {{ $product->product_name }}
                                                <span class="price-product">{{ number_format($product->product_price, 0, ',', ' ') }} CFA</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($order->items->count() > 2)
                                        <button class="expand-button" onclick="toggleProducts(this)">
                                            <span class="expand-text">
                                                Voir plus ({{ $order->items->count() - 2 }} produit{{ $order->items->count() - 2 > 1 ? 's' : '' }})
                                            </span>
                                            <span class="expand-icon">▼</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                            <td class="total-amount">{{ number_format($order->total_amount, 0, ',', ' ') }} CFA</td>
                            <td><span class="status {{ $order->status }}">
                                {{ $order->status }}</span>
                            </td>
                            <td>{{ $order->created_at->translatedFormat('j F Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="card-empty">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h2 class="empty-title">Aucune commande pour le moment</h2>
                    <p class="empty-message">Votre stand n'a pas encore reçu de commandes. Vos commandes apparaîtront ici lorsqu'elles seront passées.</p>
                    <a href="#" class="button">
                        <i class="fas fa-store"></i> Voir mon stand
                    </a>
                </div>
                @endif
            </div>

            <!-- Produits -->
            <div class="card" id="produits">
                <div class="card-header">
                    <h3>Mes produits</h3>
                    <a href="{{ route('products.create') }}">Ajouter un produit</a>
                </div>
                @if($userInfo->products->count() > 0) 
                <div class="products-grid">
                    @foreach ($userInfo->products as $product)                    
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('uploads/products/'.$product->photo) }}" alt="">
                        </div>
                        <div class="product-details">
                            <h3>{{ $product->nom_produit }}</h3>
                            <p>{{ $product->description }}</p>
                            <div class="product-price">{{ $product->prix }} CFA</div>
                            <div class="product-actions">
                                <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}"> <i class="fa-regular fa-pen-to-square"></i> </a>
                                <button class="btn btn-primary btn-delete" onclick="deleteProduct({{ $product->id }})"> <i class="fa-solid fa-trash"></i> </button>
                                <form id="delete-product-form-{{ $product->id }}" action="{{ route('products.destroy',$product->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="card-empty">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h2 class="empty-title">Aucun produit enregistré</h2>
                    <p class="empty-message">Vous n'avez pas encore de produits pour votre stand. Ajoutez vos premiers produits pour commencer à vendre.</p>
                    <a href="{{ route('products.create') }}" class="button">
                        <i class="fas fa-plus"></i> Ajouter un produit
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal de confirmation de suppression de produit --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="modal-title">Confirmation</h3>
            </div>
            <div class="modal-body">
                <p class="modal-message">Êtes-vous sûr de vouloir supprimer ce produit ?</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-cancel" onclick="closeModal()">Annuler</button>
                <button class="modal-btn modal-btn-delete" onclick="confirmDelete()">Supprimer</button>
            </div>
        </div>
    </div>





    <script src="{{ asset('js/dashboard-user.js') }}"></script>
</body>
</html>