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
        
       $products = Product::where('user_id', auth()->id())->get();
       return view('products.list', compact('products'));
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
            'nom_produit' => 'required|min:3',
            'description' => 'required|min:8|max:255',
            'prix' => 'required|numeric',
        ];

        if($request->image != "") {
            $rules['photo'] = 'photo';
        }

        $validator = Validator::make($request->all(),$rules);

            if($validator->fails()) {
                return redirect()->route('products.create')->withInput()->withErrors($validator);
            }

        $product = new Product();
        $product->nom_produit = $request->nom_produit;
        $product->description = $request->description;
        $product->prix = $request->prix;
        $product->user_id = auth()->id();
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
    public function show($id)
    {
         $product = Product::where('id', $id)
                      ->where('user_id', auth()->id()) // Sécuriser que le produit appartient bien à l'utilisateur
                      ->firstOrFail();

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('products.edit', compact('product'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

            $rules = [
                'nom_produit' => 'required|min:3',
                'description' => 'required|min:8|max:255',
                'prix' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $product->update($request->only(['nom_produit', 'description', 'prix']));

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $imageName = time().'.'.$photo->getClientOriginalExtension();
                $photo->move(public_path('uploads/products'), $imageName);
                $product->photo = $imageName;
                $product->save();
                }

            return redirect()->route('products.index')->with('success', 'Produit mis à jour.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

            if ($product->photo && file_exists(public_path('uploads/products/' . $product->photo))) {
                unlink(public_path('uploads/products/' . $product->photo));
            }

            $product->delete();

            return redirect()->route('products.index')->with('success', 'Produit supprimé.');
     }
}
 

