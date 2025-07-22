<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nom_produit' => ['required', 'min:3', 'max:50', 'regex:/^(?!\d+$)[\pL\pN\s\-]+$/u'],
            'description' => 'required|min:8|max:255',
            'prix' => 'required|numeric',
            'photo' => 'required|image',
        ];

        $messages = [
            'nom_produit.required' => 'Le nom du produit est requis',
            'nom_produit.min' => 'Ce champ doit contenir au moins :min caractères',
            'nom_produit.max' => 'Ce champ doit contenir au plus :max caractères',
            'nom_produit.regex' => 'Le nom du produit doit contenir au moins une lettre',
            
            'description.required' => 'Le nom du produit est requis',
            'description.min' => 'Ce champ doit contenir au moins :min caractères',
            'description.max' => 'Ce champ doit contenir au plus :max caractères',

            'prix.required' => 'Le prix est obligatoire',
            'prix.numeric' => 'Le prix doit etre un nombre',

            'photo.required' => 'Une image du produit est requise',
            'photo.image' => 'Le fichier sélectionné doit etre une image',
        ];

        if($request->image != "") {
            $rules['photo'] = 'photo';
        }

        $validator = Validator::make($request->all(),$rules, $messages);

            if($validator->fails()) {
                return redirect()->route('products.create')->withInput()->withErrors($validator);
            }

        $product = new Product();
        $product->nom_produit = $request->nom_produit;
        $product->description = $request->description;
        $product->prix = $request->prix;
        $product->photo = $request->photo;
        $product->save();

        // Gestion de l'insertion de l'image
        if($request->photo != "") {
            $photo = $request->photo;
            $ext = $photo->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            
            // Enregistrement d'images dans le dossier uploads/products
            $photo->move(public_path('uploads/products'), $imageName);
    
            // Sauvegarde de l'image dans la BD
            $product->photo = $imageName;
            $product->save();
        }
        
        return redirect()->route('products.index')->with('success', 'Votre produit a été ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
