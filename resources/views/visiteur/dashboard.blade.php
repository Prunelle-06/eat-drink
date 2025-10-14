<!DOCTYPE html>
<html lang="en">
<head>
    @auth
        <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
        <script>
            window.OneSignalDeferred = window.OneSignalDeferred || [];
            OneSignalDeferred.push(async function(OneSignal) {
                await OneSignal.init({
                appId: "98be7eba-f9b7-45d9-aaa1-0e63fc3d7263",
                });

                try {
                    // Lier l'utilisateur
                    await OneSignal.login("{{ Auth::id() }}");
                    
                } catch(error) {
                    console.error("Erreur OneSignal:", error);
                }
            });
        </script>
    @endauth
    <meta name="csrf-token" content="{{ csrf_token() }}" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/724f54335b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard-visiteur.css') }}">
    <title>Document</title>

    <style>
        /* Logique d'affichage des sections */
        .dashboard-sections { 
            display: {{ $current_section === 'index' ? 'block' : 'none' }}; 
        }
        .updateProfil-section { 
            display: {{ $current_section === 'profil' ? 'block' : 'none' }}; 
        }
        .ordersReady-section { 
            display: {{ $current_section === 'ordersReady' ? 'block' : 'none' }}; 
        }
        .ordersConfirmed-section { 
            display: {{ $current_section === 'ordersConfirmed' ? 'block' : 'none' }}; 
        }
        
    </style>
</head>
<body>
    <div id="alert-notification" class="alert"></div>

    <div class="dashboard">
        @if (Session::has('success'))
            <p class="flash-message">{{ Session::get('success') }}</p>
        @endif
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                Taste<span>&</span>Stay
            </div>
            <p>Tableau de bord client</p>
            <div class="name-user">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiByeD0iNTAiIGZpbGw9IiNFNUU3RUIiLz4KPHN2ZyB4PSIyNSIgeT0iMjUiIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cGF0aCBkPSJNMTIgMTJDMTQuMjA5MSAxMiAxNiA5Ljc2MTQyIDE2IDdDMTYgNC4yMzg1OCAxNC4yMDkxIDIgMTIgMkM5Ljc5MDg2IDIgOCA0LjIzODU4IDggN0M4IDkuNzYxNDIgOS43OTA4NiAxMiAxMiAxMlpNMTIgMTRDOC42ODYyOSAxNCA2IDE2LjY4NjMgNiAyMEg2VjIySDdWMjBDNyAxNy43OTA5IDkuNzkwODYgMTUgMTIgMTVDMTQuMjA5MSAxNSAxNyAxNy43OTA5IDE3IDIwVjIySDI0VjIwQzE4IDE2LjY4NjMgMTUuMzEzNyAxNCAxMiAxNFoiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+Cjwvc3ZnPgo=" alt="Profil" class="user-avatar">
                <span>{{ $user->nom_complet }}</span>
            </div>
            <ul class="nav-menu">
                <a href="{{ route('home') }}">
                    <li class="nav-item">
                        <i class="fa-solid fa-home"></i> Accueil
                    </li>
                </a>
                <a href="{{ route('dashboard.visiteur') }}#board">
                    <li class="nav-item active" style="color: #00A699">
                       <i class="fas fa-columns"></i> Tableau de bord
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
                        <span class="badge">{{ $stands->count() }}</span>
                    </li>
                </a>
                <a href="{{ route('dashboard.visiteur') }}#favoris">
                    <li class="nav-item">
                        <i class="fa-solid fa-heart"></i> Favoris
                        <span class="badge">{{ $favorites->total() }}</span>
                    </li>
                </a>
                <a href="{{ route('dashboard.visiteur') }}#commandes">
                    <li class="nav-item">
                        <i class="fa-solid fa-cart-arrow-down"></i> Commandes
                        <span class="badge">{{ $orders->count() }}</span>
                    </li>
                </a>

                <div class="sidebar-section" onclick="toggleOrdersMenu()">
                    <div id="orders-toggle-icon" class="section-header">
                        <i class="fa-solid fa-shopping-bag"></i>
                        <span>Commandes Actives</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    
                    <div class="submenu" id="orders-submenu">
                        <!-- Sous-section Commandes confirmées -->
                        <a href="{{ route('dashboard.visiteur.ordersConfirmed') }}" class="submenu-item {{ $current_section === 'ordersConfirmed' ? 'active' : '' }}">
                            <i class="fa-solid fa-check-circle"></i>
                            <span>Confirmées</span>
                            @if($ordersConfirmed->count() > 0)
                                <span class="badge">{{ $ordersConfirmed->count() }}</span>
                            @endif
                        </a>
                        
                        <!-- Sous-section Prêtes à retirer -->
                        <a href="{{ route('dashboard.visiteur.ordersReady') }}" class="submenu-item {{ $current_section === 'ordersReady' ? 'active' : '' }}">
                            <i class="fa-solid fa-bell"></i>
                            <span>Prêtes à retirer</span>
                            @if($ordersReady->count() > 0)
                            <span class="badge">{{ $ordersReady->count() }}</span>
                            @endif
                        </a>
                    </div>
                </div>
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
            <!-- Statistiques -->
            <div class="header">
                <h1 id="board">Tableau de bord</h1>
                <span>Bonjour, {{ $user->nom_complet }}</span>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <h3>{{ $myVisits }}</h3>
                            <p>Stands visités</p>
                        </div>
                        <i class="fas fa-eye stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <h3>+{{ $myVisitsThisWeek }}</h3>
                            <p>Stands visités cette semaine</p>
                        </div>
                        <i class="fas fa-calendar-week stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <h3>{{ $favorites->total() }}</h3>
                            <p>Favoris</p>
                        </div>
                        <i class="fas fa-heart stat-icon"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <h3>{{ number_format($statsOrders['myOrdersPending'], 0, ',', ' ') }}</h3>
                            <p>Commandes non confirmées({{ $statsOrders['pending'] }})</p>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <h3>{{ number_format($statsOrders['myOrdersConfirmed'], 0, ',', ' ') }}</h3>
                            <p>Commandes confirmées({{ $statsOrders['confirmed'] }})</p>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <h3>{{ number_format($statsOrders['myOrdersReady'], 0, ',', ' ') }}</h3>
                            <p>Commandes en cours({{ $statsOrders['ready'] }})</p>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <h3>{{ number_format($statsOrders['myOrdersDelivered'], 0, ',', ' ') }}</h3>
                            <p>Commandes livrées({{ $statsOrders['delivered'] }})</p>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <h3>{{ number_format($statsOrders['myOrdersCancelled'], 0, ',', ' ') }}</h3>
                            <p>Commandes annulées({{ $statsOrders['cancelled'] }})</p>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                           <h3>{{ $orders->count() }}</h3>
                            <p>Commandes total envoyées</p>
                        </div>
                        <i class="fas fa-list-alt stat-icon"></i>
                    </div>
                </div> 
            </div>
            
            <!-- Stands Favoris -->
            <h2 class="section-title" id="favoris">
                <i class="fa-solid fa-heart" style="color: #eb0a0a;"></i> Mes stands favoris
            </h2>
            @if($favorites->count() > 0)
            <div class="stands-grid">
                @foreach($favorites as $favorite)                  
                <a href="{{ route('stands.show', $favorite) }}" data-stand-id="{{ $favorite->id }}" class="stand-card favorite-stand-card">

                    <button class="favorite-btn {{ Auth::check() && Auth::user()->hasFavorited($favorite->id) ? 'favorited' : '' }}"
                        onclick="toggleFavorite({{ $favorite->id }}, event)"
                        {{ Auth::guest() ? 'disabled' : '' }}>
                        ★
                    </button>
                    <div class="stand-image">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80" alt="">
                    </div>
                    <div class="stand-content">
                        <h3 class="stand-title">{{ $favorite->nom_stand }}</h3>
                        <div class="stand-owner">
                            <i class="fas fa-user"></i>
                            <span>{{ $favorite->user->nom_complet }}</span>
                        </div>
                        <p class="stand-description">
                            {{ $favorite->description_stand }}
                        </p>
                        <div class="stand-footer">
                            <div class="stand-products-count">
                                <i class="fas fa-utensils"></i>
                                <span>{{ $favorite->products->count() }} produits</span>
                            </div>
                            <span class="btn btn-primary">Voir le stand</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
                <div class="no-favorites">
                    <div class="no-favorites-icon">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <h3>Aucun stand en favori</h3>
                    <p>Explorez nos exposants et ajoutez vos stands préférés</p>
                    <a href="{{ route('stands.index') }}" class="cta-button">
                        <i class="fas fa-store"></i> Découvrir les stands
                    </a>
                </div>
            @endif

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
                        <span class="order-status status-{{ $order->status }}"><i class="fas fa-clock"></i> En attente</span>
                    @elseif($order->status === "confirmed")
                        <span class="order-status status-{{ $order->status }}"><i class="fas fa-check-circle"></i> Confirmée</span>
                    @elseif($order->status === "ready")
                        <span class="order-status status-{{ $order->status }}"><i class="fas fa-check"></i> En cours</span>
                    @elseif($order->status === "delivered")
                        <span class="order-status status-{{ $order->status }}"><i class="fas fa-check-double"></i> Livrée</span>
                    @elseif($order->status === "cancelled")
                        <span class="order-status status-{{ $order->status }}"><i class="fas fa-ban"></i> Annulée</span>
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
                    </div>
                    <div class="order-total">
                        <span class="total-label">Total</span>
                        <span class="total-amount">{{ number_format($order->total_amount, 0, ',', ' ') }} CFA</span>
                    </div>
                    <div class="order-actions">
                        <button class="action-btn btn-primary" 
                            onclick="reorder({{ $order->id }})"> 
                            Commander à nouveau
                        </button>
                        @if(!in_array($order->status, ['cancelled', 'delivered', 'ready']))
                        <button 
                          class="action-btn btn-canceled"
                          onclick="cancelOrder({{ $order->id }})" 

                          @if(!in_array($order->status, ['pending', 'confirmed'])) disabled @endif>

                          Annuler la commande
                        </button>
                        @endif
                        <button 
                            class="action-btn btn-secondary" 
                            onclick="contactStand({{ $order->stand_id }}, '{{ $order->stand->nom_stand }}')" >
                            
                            Contacter le stand
                        </button>
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
                    <input type="password" name="visiteur_password" placeholder="Mot de passe (optionnel)">
                    @error('visiteur_password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="password" name="visiteur_password_confirmation" placeholder="Confirmer le mot de passe">
                    @error('visiteur_password_confirmation')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>          
                        
                <button type="submit" class="submit-btn">Mettre à jour</button>
            </form>
        </div>

        {{-- Commandes pretes --}}
        <div id="ordersReadySlider" class="ordersReady-section">
            <div class="section-header">
                <h2><i class="fa-solid fa-bell"></i> Commandes Pretes</h2>
                <p class="section-subtitle">Verifiez la commande et présentez le code ci-dessous</p>
            </div>

            <div class="orders-stats">
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <div class="stat-info">
                        <span class="stat-number">{{ $ordersReady->count() }}</span>
                        <span class="stat-label">En cours de livraison</span>
                    </div>
                </div>
            </div>
            <div class="orders-slider" style="position: relative;">
                @if(count($ordersReady) > 1)
                    <button class="slider-nav prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
            
                    <button class="slider-nav next">
                        <i class="fas fa-chevron-right"></i>
                    </button> 
                @endif     
                @foreach($ordersReady as $orderReady) 
                <div class="order-ready-card slider-card">
                    <div class="ready-header-container">
                       <div class="ready-header">
                         <i class="fas fa-bell fa-shake"></i>
                         <h3>Commande prête !</h3>
                       </div>
                       <span class="order-date">
                            {{ $orderReady->ready_at->diffForHumans() }}
                        </span>
                    </div>
                    
                    <div class="order-ready-details">
                        <p><strong><i class="fas fa-store"></i> Stand:</strong> {{ $orderReady->stand->nom_stand }}</p>
                        <p><strong><i class="fas fa-receipt"></i> Commande:</strong> {{ $orderReady->order_number }}</p>
                        <p><strong><i class="fas fa-cube"></i> Articles:</strong> {{ $orderReady->items->count() }} produit(s)</p>
                        <p><strong><i class="fas fa-money-bill-wave"></i> Montant:</strong> {{ number_format($orderReady->total_amount, 0, ',', ' ') }} CFA</p>                                  
                        <p><strong><i class="fas fa-clock"></i>
                        Prete depuis: </strong> {{ $orderReady->ready_at->format('H:i') }} </p>
                    </div>
                    
                    <div class="pickup-code-display">
                        <h4><i class="fas fa-qrcode"></i> Code de retrait</h4>
                        <div class="code-large">{{ $orderReady->pickup_code }}</div>
                        <p class="code-instruction">
                            Présentez ce code à l'exposant pour récupérer votre commande
                        </p>
                    </div>                
                </div>
                @endforeach
                
                @if(count($ordersReady) > 1)
                <div class="slider-indicators">
                    @foreach ($ordersReady as $index => $orderReady)
                    <div class="indicator {{ $index === 0 ? 'active' : '' }}"></div>
                    @endforeach
                </div>
                @endif
            </div>
            @if($ordersReady->isEmpty())
                <div class="empty-orders-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox fa-4x"></i>
                    </div>
                    <h3 class="empty-title">Aucune commande à retirer</h3>
                    <p class="empty-message">
                        Vos commandes apparaîtront ici lorsqu'elles seront prêtes chez les exposants.
                    </p>
                    <div class="empty-actions">
                        <button class="btn-refresh" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> Actualiser
                        </button>
                        <a href="{{ route('stands.index') }}" class="cta-button btn-browse">
                            <i class="fas fa-store"></i> Découvrir les stands
                        </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- Commandes confirmées --}}
        <div id="ordersConfirmedSlider" class="ordersConfirmed-section">
            <div class="section-header">
                <h2><i class="fas fa-check-circle"></i> Commandes Confirmées</h2>
                <p class="section-subtitle">Vos commandes confirmées par les exposants</p>
            </div>

            <div class="orders-stats">
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <div class="stat-info">
                        <span class="stat-number">{{ $ordersConfirmed->count() }}</span>
                        <span class="stat-label">En attente de préparation</span>
                    </div>
                </div>
            </div>

            <div class="orders-grid">
                @if(count($ordersConfirmed) > 1)
                    <button class="slider-nav prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
            
                    <button class="slider-nav next">
                        <i class="fas fa-chevron-right"></i>
                    </button> 
                @endif  
                <div class="orders-slider">                  
                    @foreach($ordersConfirmed as $orderConfirmed)
                    <div class="order-card confirmed slider-card">
                        <div class="card-header">
                            <div class="order-meta">
                                <span class="order-number">{{ $orderConfirmed->order_number }}</span>
                                <span class="order-date">
                                    Confirmée {{ $orderConfirmed->confirmed_at->diffForHumans() }}
                                </span>
                            </div>
                            <span class="status-badge confirmed">
                                <i class="fas fa-check-circle"></i> Confirmée
                            </span>
                        </div>
    
                        <div class="card-body">
                            <div class="vendor-info">
                                <div class="vendor-avatar">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="vendor-details">
                                    <h4 class="vendor-name">{{ $orderConfirmed->stand->nom_stand }}</h4>
                                    <p class="vendor-location">
                                        <i class="fas fa-map-marker-alt"></i> Allée A, Stand 12
                                    </p>
                                </div>
                            </div>
    
                            <div class="order-details">
                                <div class="detail-item">
                                    <i class="fas fa-cube"></i>
                                    <span>{{ $orderConfirmed->items->count() }} article(s)</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>
                                    {{ number_format($orderConfirmed->total_amount, 0, ',', ' ') }} CFA
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Confirmée à {{ $orderConfirmed->confirmed_at->format('H:i') }}</span>
                                </div>
                            </div>
    
                            <div class="estimation-info">
                                <i class="fas fa-hourglass-half"></i>
                                <span>Préparation estimée : 25 min</span>
                            </div>
                        </div>
    
                        <div class="card-footer">
                            <button class="btn btn-secondary">
                                <i class="fas fa-comment"></i> Contacter
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>  

            </div>
            @if(count($ordersConfirmed) > 1)
                <div class="slider-indicators">
                    @foreach ($ordersConfirmed as $index => $orderConfirmed)
                    <div class="indicator {{ $index === 0 ? 'active' : '' }}"></div>
                    @endforeach
                </div>
            @endif
            @if($ordersConfirmed->isEmpty())
                <div class="empty-orders-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox fa-4x"></i>
                    </div>
                    <h3 class="empty-title">Aucune commande confirmée par un exposant pour l'instant</h3>
                    <p class="empty-message">
                        Vos commandes apparaîtront ici lorsqu'elles seront confirmées chez les exposants.
                    </p>
                    <div class="empty-actions">
                        <button class="btn-refresh" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> Actualiser
                        </button>
                        <a href="{{ route('stands.index') }}" class="cta-button btn-browse">
                            <i class="fas fa-store"></i> Découvrir les stands
                        </a>
                    </div>
                </div>
            @endif
        </div>

            
    </div>




    <script src="{{ asset('js/dashboard-visiteur.js') }}"></script>
    <script src="{{ asset('js/stand-index.js') }}"></script>

</body>
</html>