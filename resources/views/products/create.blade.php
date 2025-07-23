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
    <a href="{{ route('dashboard.entrepreneur') }}" class="btn-retour">Retour</a>
    <div class="form-container">
        <h2>Ajouter un produit</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nom">Nom du produit</label>
                <input type="text" class="@error('nom_produit')
                    is-invalid
                @enderror" id="nom" name="nom_produit" value="{{ old('nom_produit') }}">
                @error('nom_produit') 
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" class="@error('description')
                    is-invalid
                @enderror" name="description" value="{{ old('description') }}" rows="4"></textarea>
                @error('description') 
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="text" class="@error('prix')
                    is-invalid
                @enderror" id="prix" name="prix" value="{{ old('prix') }}">
                @error('prix') 
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <div class="custom-file">
                    <input type="file" class="@error('photo')
                    is-invalid
                @enderror" id="photo" name="photo" value="{{ old('photo') }}" accept="image/*">
                    <span id="file-name">Aucune image sélectionnée</span>
                </div>
                @error('photo') 
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">Soumettre</button>
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