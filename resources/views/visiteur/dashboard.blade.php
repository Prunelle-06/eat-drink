<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/724f54335b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard-visiteur.css') }}">
    <title>Document</title>

    <style>
        /* Logique d'affichage des sections */
        .dashboard-sections { 
            display: {{ $current_section === 'profil' ? 'none' : 'block' }}; 
        }
        .updateProfil-section { 
            display: {{ $current_section === 'profil' ? 'block' : 'none' }}; 
        }
    </style>
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
            <div class="name-user">{{ $user->nom_complet }} 123</div>
            <ul class="nav-menu">
                <a href="{{ route('home') }}">
                    <li class="nav-item">
                        <i class="fa-solid fa-home"></i> Accueil
                    </li>
                </a>
                <a href="{{ route('dashboard.visiteur') }}#board">
                    <li class="nav-item active">
                       Tableau de bord
                    </li>
                </a>
                <a href="{{ route('dashboard.visiteur.profil') }}">
                    <li class="nav-item">
                       <i class="fa-solid fa-user"></i> Profil
                    </li>
                </a>
                <a href="{{ route('stands.index') }}">
                    <li class="nav-item">
                        <i class="fas fa-store"></i> Voir stands
                        <span class="badge">{{$stands->count() }}</span>
                    </li>
                </a>
                <a href="{{ route('dashboard.visiteur') }}#favoris">
                    <li class="nav-item">
                        <i class="fa-solid fa-heart"></i> Favoris
                        <span class="badge">5</span>
                    </li>
                </a>
                <a href="{{ route('dashboard.visiteur') }}#commandes">
                    <li class="nav-item">
                        <i class="fa-solid fa-cart-arrow-down"></i> Commandes
                        <span class="badge">{{ $orders->count() }}</span>
                    </li>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <li class="nav-item logout-item">
                        <button class="logout-button" type="submit">
                            <i class="fas fa-sign-out-alt" style="color: #e15b5b;"></i> Déconnexion
                        </button>
                    </li>
                </form>
            </ul>
        </aside>

        <!-- Main Contenu -->
        <main class="main-content dashboard-sections">
            <!-- Header -->
            <header class="header">
                <div class="user-profile">
                    <span>Bonjour, {{ $user->nom_complet }}</span>
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiByeD0iNTAiIGZpbGw9IiNFNUU3RUIiLz4KPHN2ZyB4PSIyNSIgeT0iMjUiIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cGF0aCBkPSJNMTIgMTJDMTQuMjA5MSAxMiAxNiA5Ljc2MTQyIDE2IDdDMTYgNC4yMzg1OCAxNC4yMDkxIDIgMTIgMkM5Ljc5MDg2IDIgOCA0LjIzODU4IDggN0M4IDkuNzYxNDIgOS43OTA4NiAxMiAxMiAxMlpNMTIgMTRDOC42ODYyOSAxNCA2IDE2LjY4NjMgNiAyMEg2VjIySDdWMjBDNyAxNy43OTA5IDkuNzkwODYgMTUgMTIgMTVDMTQuMjA5MSAxNSAxNyAxNy43OTA5IDE3IDIwVjIySDI0VjIwQzE4IDE2LjY4NjMgMTUuMzEzNyAxNCAxMiAxNFoiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+Cjwvc3ZnPgo=" alt="Profil" class="user-avatar">
                </div>
            </header>

            <!-- Statistiques -->
            <h1 style="margin-bottom: 8px" id="board">Tableau de bord</h1>
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
                    <h3>{{ $orders->count() }}</h3>
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

            @if($orders->count() > 0)
            @foreach ($orders as $order)               
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">{{ $order->order_number }}</span>
                        <span class="order-date">{{ $order->created_at->translatedFormat('j F Y à H:i') }}</span>
                    </div>
                    @if($order->status === "pending")
                    <span class="order-status status-delivered">En attente</span>
                    @endif
                </div>
                <div class="order-details">
                    <div class="order-items">
                        @foreach ($order->items as $product)                    
                        <div class="order-item">
                            <span class="item-name">{{ $product->product_name }} @if($product->quantity > 1) x {{ $product->quantity }} @endif</span>
                            <span class="item-price">{{ number_format($product->product_price, 0, ',', ' ') }} CFA</span>
                        </div>
                        @endforeach
                        {{-- <div class="order-item">
                            <span class="item-name">Bouteille Chardonnay</span>
                            <span class="item-price">18,50 CFA</span>
                        </div>
                        <div class="order-item">
                            <span class="item-name">Frais de livraison</span>
                            <span class="item-price">5,00 CFA</span>
                        </div> --}}
                    </div>
                    <div class="order-total">
                        <span class="total-label">Total</span>
                        <span class="total-amount">{{ number_format($order->total_amount, 0, ',', ' ') }} CFA</span>
                    </div>
                    <div class="order-actions">
                        <button class="action-btn btn-primary">Commander à nouveau</button>
                        <button class="action-btn btn-canceled">Annuler la commande</button>
                        <button class="action-btn btn-secondary">Contacter le stand</button>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <h2 class="empty-title">Aucune commande pour le moment</h2>
                <p class="empty-message">Vous n'avez pas encore passé de commande. Découvrez nos stands et trouvez des produits qui vous plaisent !</p>
                <a href="{{ route('stands.index') }}" class="cta-button">
                    <i class="fas fa-store"></i> Découvrir les stands
                </a>
            </div>
            @endif            

            </div>
        </main>

        <div class="updateProfil-section">
            <h1>Mon Profil</h1>
            <form style="margin-top: 22px;" method="POST" action="{{ route('dashboard.visiteur.updateProfil') }}">
                @csrf
                @method('PUT')
                {{-- <input type="hidden" name="form_type" value="visiteur"> --}}

                <div class="form-group">
                    <input type="text" name="visiteur_nom_complet" value="{{ old('visiteur_nom_complet',$user->nom_complet ) }}" placeholder="Nom complet *">
                    @error('visiteur_nom_complet')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="email" name="visiteur_email" value="{{ old('visiteur_email', $user->email) }}" placeholder="Adresse email *">
                    @error('visiteur_email')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="password" name="visiteur_password" placeholder="Mot de passe *">
                    @error('visiteur_password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="password" name="visiteur_password_confirmation" placeholder="Confirmer le mot de passe (optionnel)">
                    @error('visiteur_password_confirmation')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>          
                        
                <button type="submit" class="submit-btn">Mettre à jour</button>
            </form>
        </div>
            
    </div>




    <script src="{{ asset('js/dashboard-visiteur.js') }}"></script>
</body>
</html>