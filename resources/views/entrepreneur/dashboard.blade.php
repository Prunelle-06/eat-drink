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
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <title>Document</title>

    <style>
        /* Logique d'affichage des sections */
        .dashboard-sections { 
            display: {{ $current_section === 'index' ? 'block' : 'none' }}; 
        }
        .updateProfil-section { 
            display: {{ $current_section === 'profil' ? 'block' : 'none' }}; 
        }
        .validateCode-section { 
            display: {{ $current_section === 'fastCodeValidation' ? 'block' : 'none' }}; 
        }
    </style>
</head>

<body class="{{ $current_section === 'profil' ? 'show-profil' : '' }}">

    <div id="alert-notification" class="alert"></div>

    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    Taste<span>&</span>Stay
                </div>
                <p>Tableau de bord entrepreneur</p>
                <div>
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiByeD0iNTAiIGZpbGw9IiNFNUU3RUIiLz4KPHN2ZyB4PSIyNSIgeT0iMjUiIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cGF0aCBkPSJNMTIgMTJDMTQuMjA5MSAxMiAxNiA5Ljc2MTQyIDE2IDdDMTYgNC4yMzg1OCAxNC4yMDkxIDIgMTIgMkM5Ljc5MDg2IDIgOCA0LjIzODU4IDggN0M4IDkuNzYxNDIgOS43OTA4NiAxMiAxMiAxMlpNMTIgMTRDOC42ODYyOSAxNCA2IDE2LjY4NjMgNiAyMEg2VjIySDdWMjBDNyAxNy43OTA5IDkuNzkwODYgMTUgMTIgMTVDMTQuMjA5MSAxNSAxNyAxNy43OTA5IDE3IDIwVjIySDI0VjIwQzE4IDE2LjY4NjMgMTUuMzEzNyAxNCAxMiAxNFoiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+Cjwvc3ZnPgo=" alt="Profil" class="user-avatar">
                    <span class="name-user">{{ $userInfo->nom_complet }}</span>
                </div>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <span>Acceuil</span>
                    </a>
                </div>
                <div class="menu-item active">
                    <a href="{{ route('dashboard.exposant') }}#board">
                        {{-- <i class="fas fa-home"></i> --}}
                        <i class="fas fa-columns"></i>
                        <span>Tableau de bord</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('dashboard.exposant.profil') }}" class="{{ $current_section === 'profil' ? 'active' : '' }}">
                        <i class="fa-solid fa-user"></i>
                        <span>Profil</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('dashboard.exposant') }}#produits" class="{{ !$current_section ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i>
                        <span>Mes Produits</span>
                        <span class="badge">{{ $userInfo->products->count() }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('dashboard.exposant') }}#commandes" class="{{ !$current_section ? 'active' : '' }}">
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
                <div class="menu-item">
                    <a href="{{ route('dashboard.exposant.fastCodeValidation') }}" class="{{ $current_section === 'codeValidation' ? 'active' : '' }}">
                        <i class="fa-solid fa-bolt"></i>
                        <span>Code rapide</span>
                    </a>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div class="menu-item logout-item">
                        <button type="submit">
                            <i class="fas fa-sign-out-alt" style="color: #e15b5b"></i>
                            <span>Déconnexion</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Main Content -->
        <div class="main-content dashboard-sections">
            @if (Session::has('success'))
                <p class="flash-message">{{ Session::get('success') }}</p>
            @endif

            <!-- Header -->
            <div id="board" class="header">
                <h1 class="section-title">
                    Tableau de bord
                </h1>
                <div class="user-menu">                  
                    <div class="user-profile">
                        <div class="user-info">
                            <p> {{ $userInfo->stand->nom_stand }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ number_format($stats['ca_réalisé'], 0, ',', ' ') }}</div>
                            <div class="label">Commandes livrées ({{ $stats['delivered'] }})</div>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ number_format($stats['ca_confirmé'], 0, ',', ' ') }}</div>
                            <div class="label">Commandes confirmées ({{ $stats['confirmed'] }})</div>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ number_format($stats['ca_pret'], 0, ',', ' ') }}</div>
                            <div class="label">Commandes pretes ({{ $stats['ready'] }})</div>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ number_format($stats['ca_non_confirmé'], 0, ',', ' ') }}</div>
                            <div class="label">Commandes non confirmées ({{ $stats['pending'] }})</div>
                        </div>
                        <i style="font-weight: bold; font-size: 17px">CFA</i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ $orders->count() }}</div>
                            <div class="label">Total commandes recues</div>
                        </div>
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ $userInfo->products->count() }}</div>
                            <div class="label">Vos produits</div>
                        </div>
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ $stats['produit_plus_rentable']->nom_produit ?? 'Aucun produit' }}</div>
                            <div class="label">Produit le plus rentable</div>
                        </div>
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ $totalFavorites }}</div>
                            <div class="label">Favoris totaux</div>
                        </div>
                        <i class="fas fa-heart"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">+{{ $favoritesThisWeek }}</div>
                            <div class="label">Favoris cette semaine</div>
                        </div>
                        <i class="fas fa-chart-line"></i>
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
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">{{ $allVisits->count() }}</div>
                            <div class="label">Visites totales</div>
                        </div>
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="header">
                        <div>
                            <div class="value">+{{ $visitesToday }}</div>
                            <div class="label">Visites aujourd'hui</div>
                        </div>
                         <i class="fas fa-calendar-week fa-2x"></i>
                    </div>
                </div>
                
            </div>

            <!-- Commandes -->
            <div class="card" id="commandes">
                <h1 class="section-title">
                    <i class="fa-solid fa-cart-arrow-down"></i> Commandes
                </h1>
                @if($orders->count() > 0) 
                <table class="table" style="font-style: italic">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Client</th>
                            <th>Produits</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)                     
                        <tr> 
                            <td style="color: #4A5568; font-weight: 500;">#{{ $order->order_number }}</td>
                            <td>{{ $order->user->nom_complet }}</td>
                            <td class="products-cell">
                                <div class="products-container">
                                    <div class="products-preview" data-order-id="{{ $order->id }}">
                                        @foreach ($order->items as $index => $product)
                                            <div class="product-line" 
                                                @if($index >= 2) style="display: none;" @endif>
                                                {{ $product->quantity }}x {{ $product->product_name }}
                                                {{-- <span class="price-product">{{ number_format($product->product_price, 0, ',', ' ') }}</span> --}}
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
                            <td class="total-amount">
                                {{ number_format($order->total_amount, 0, ',', ' ') }} CFA
                            </td>
                            <td style="white-space: nowrap">
                                @if($order->status === "pending")
                                <span class="status {{ $order->status }}">
                                    En attente
                                </span>
                                @elseif($order->status === "confirmed")
                                <span class="status {{ $order->status }}">
                                    Confirmée
                                </span>
                                @elseif($order->status === "ready")
                                <span class="status {{ $order->status }}">
                                    Prête
                                </span>
                                @elseif($order->status === "delivered")
                                <span class="status {{ $order->status }}">
                                    Livrée
                                </span>
                                @elseif($order->status === "cancelled")
                                <span class="status {{ $order->status }}">
                                    Annulée
                                </span>
                                @endif
                            </td>
                            <td>
                                {{ $order->created_at->translatedFormat('j M Y') }}
                            </td>
                            <td>
                                @if($order->status === "pending")
                                    <button class="btn-pending" onclick="confirmOrder({{ $order->id }}, this)">Confirmer</button>
                                @elseif($order->status === "confirmed")
                                    <button class="btn-confirmed" onclick="markOrderReady({{ $order->id }}, this)">Pret</button>
                                @elseif($order->status === "ready")
                                    <span class="btn-ready" style="white-space: nowrap;">En cours</span>
                                @elseif($order->status === "delivered")
                                    <span class="btn-delivered">Terminé</span>
                                @elseif($order->status === "cancelled")
                                    <span class="btn-cancelled">Annulée</span>
                                @endif
                            </td>
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
                    <h1 class="section-title">
                        <i class="fas fa-utensils"></i> Mes Produits
                    </h1>
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
                            <div class="product-price">{{ number_format($product->prix, 0, ',', ' ') }} CFA</div>
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

        <!-- Profil -->
        <div class="updateProfil-section">
            <h1>Mon Profil</h1>
            <form method="POST" action="{{ route('dashboard.exposant.updateProfil') }}" enctype="multipart/form-data">
                @csrf  
                @method('PUT')
                {{-- <input type="hidden" name="form_type" value="exposant"> --}}

                {{-- Champs User --}}
                <div class="form-group visitor-form">
                    <input type="text" name="exposant_nom_complet" value="{{ old('exposant_nom_complet',$userInfo->nom_complet ) }}" placeholder="Nom complet *">
                    @error('exposant_nom_complet')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group visitor-form">
                    <input type="email" name="exposant_email" value="{{ old('exposant_email',$userInfo->email) }}" placeholder="Adresse email *">
                    @error('exposant_email')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Champs Stand --}}
                <div class="form-group">
                    <input name="nom_stand" value="{{ old('nom_stand',$userInfo->stand->nom_stand) }}" placeholder="Nom du stand *">
                    @error('nom_stand')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group file-section">
                    @if($userInfo->stand && $userInfo->stand->image_stand)
                        <div>
                            <img src="{{ asset('uploads/img_stands/'.$userInfo->stand->image_stand) }}" alt="" style="max-width: 200px;">
                        </div>
                    @endif
                    <div class="file-input-wrapper">
                        <input type="file" id="file1" name="image_stand" class="file-input">
                        <label for="file1" class="file-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Choisir une image du stand 
                        </label>
                        <div class="file-info" id="info1">Aucune image sélectionnée</div>
                    </div>
                    @error('image_stand')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <textarea name="description_stand" placeholder="Decrivez votre stand *">{{ old('description_stand',$userInfo->stand->description_stand) }}</textarea>
                    @error('description_stand')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
            
                {{-- Champs mot de passe --}}
                <div class="form-group">
                    <input type="password" name="exposant_password" placeholder="Mot de passe *">
                    @error('exposant_password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="password" name="exposant_password_confirmation" placeholder="Confirmer le mot de passe">
                    @error('exposant_password_confirmation')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn">Mettre à jour le profil</button>
            </form>
        </div>

        <!-- Validation rapide de code -->
        <div class="validateCode-section quick-pickup-section">
            <h3><i class="fas fa-bolt"></i> Validation rapide par code</h3>
            <p style="text-align: center; color: #64748b; margin-bottom: 20px;">
                Saisissez le code à 4 chiffres fourni par le client pour valider rapidement la livraison
            </p>
            <div class="quick-pickup-form">
                <input type="text" 
                        id="quick-code-input"
                        placeholder="Ex: 7294" 
                        maxlength="4" 
                        class="quick-code-input">
                <button class="btn-quick-validate" onclick="quickValidate()">
                    <i class="fas fa-search"></i> Chercher et valider
                </button>
            </div>
            
            <div id="quick-result" class="quick-result">
                <!-- Résultat de la recherche -->
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