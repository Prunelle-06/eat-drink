@extends('layouts.app')

@section('title', 'Mes produits')

@section('content')
    <h2>Liste de mes produits</h2>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('products.create') }}">Ajouter un nouveau produit</a>

    @if($products->count() > 0)
        <ul>
            @foreach($products as $product)
                <li>
                    <strong>{{ $product->nom_produit }}</strong> - {{ $product->prix }} €
                    <br>
                    <img src="{{ asset('uploads/products/'.$product->photo) }}" alt="Photo" style="max-width:100px;">
                    <br>
                    <a href="{{ route('products.edit', $product->id) }}">Modifier</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>Vous n'avez pas encore ajouté de produit.</p>
    @endif
@endsection
