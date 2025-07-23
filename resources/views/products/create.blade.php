<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/product-create.css') }}">
    <title>Formulaire Produit</title>
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un produit</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nom">Nom du produit</label>
                <input type="text" id="nom" name="nom_produit" value="{{ old('nom_produit') }}" required>
            </div>
            @error('nom_produit') 
                <p>{{ $message }}</p>
            @enderror

            <div class="form-group">
                <label for="description">Description</label>
             <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            </div>
            @error('description') 
                <p>{{ $message }}</p>
            @enderror

            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="text" id="prix" name="prix" value="{{ old('prix') }}" required>
            </div>
            @error('prix') 
                <p>{{ $message }}</p>
            @enderror

            <div class="form-group">
                <label for="photo">Photo</label>
                <div class="custom-file">
                    <input type="file" id="photo" name="photo" value="{{ old('photo') }}" accept="image/*" required>
                    <span id="file-name">Aucune image sélectionnée</span>
                </div>
            </div>
            @error('photo') 
                <p>{{ $message }}</p>
            @enderror

            <button type="submit">Soumettre</button>
            <a href="{{ route('products.index') }}" class="btn-retour">← Retour</a>

        </form>
    </div>



 
    

    <script>
        document.getElementById('photo').addEventListener('change', function () {
            const fileName = this.files[0]?.name || "Aucune image sélectionnée";
            document.getElementById('file-name').textContent = fileName;
        });
    </script>

</body>
</html>