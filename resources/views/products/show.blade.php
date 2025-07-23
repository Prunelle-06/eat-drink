<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Produit</title>
    <link rel="stylesheet" href="{{ asset('css/product-create.css') }}">
</head>
<body>
    <div class="form-container">
        <h2>Détails du produit</h2>

        <div class="form-group">
            <label>Nom du produit :</label>
            <p>{{ $product->nom_produit }}</p>
        </div>

        <div class="form-group">
            <label>Description :</label>
            <p>{{ $product->description }}</p>
        </div>

        <div class="form-group">
            <label>Prix :</label>
            <p>{{ $product->prix }} €</p>
        </div>

        <div class="form-group">
            <label>Photo :</label><br>
            @if($product->photo)
                <img src="{{ asset('uploads/products/' . $product->photo) }}" alt="Photo du produit" width="300">
            @else
                <p>Aucune photo disponible</p>
            @endif
        </div>

        <a href="{{ route('products.index') }}" class="btn-retour">← Retour à mes produits</a>
    </div>
</body>
</html>
