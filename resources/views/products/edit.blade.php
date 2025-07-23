<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Produit</title>
    <link rel="stylesheet" href="{{ asset('css/product-create.css') }}">
</head>
<body>
    <div class="form-container">
        <h2>Modifier le produit</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Nom du produit</label>
                <input type="text" id="nom" name="nom_produit" value="{{ old('nom_produit', $product->nom_produit) }}" required>
            </div>
            @error('nom_produit') 
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
            </div>
            @error('description') 
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="text" id="prix" name="prix" value="{{ old('prix', $product->prix) }}" required>
            </div>
            @error('prix') 
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="form-group">
                <label>Image actuelle :</label><br>
                @if($product->photo)
                    <img src="{{ asset('uploads/products/' . $product->photo) }}" width="200" alt="Image actuelle">
                @else
                    <p>Aucune image</p>
                @endif
            </div>

            <div class="form-group">
                <label for="photo">Changer la photo (facultatif)</label>
                <div class="custom-file">
                    <input type="file" id="photo" name="photo" accept="image/*">
                    <span id="file-name">Aucune image sélectionnée</span>
                </div>
            </div>
            @error('photo') 
                <p class="error">{{ $message }}</p>
            @enderror

            <button type="submit">Mettre à jour</button>
        </form>

        <a href="{{ route('products.index') }}" class="btn-retour">← Retour à mes produits</a>
    </div>

    <script>
        document.getElementById('photo').addEventListener('change', function () {
            const fileName = this.files[0]?.name || "Aucune image sélectionnée";
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>
