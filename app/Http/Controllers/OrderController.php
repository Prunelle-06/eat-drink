<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stand;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'stand_id' => 'required|exists:stands,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Vérifier que le stand est approuvé
            $stand = Stand::findOrFail($request->stand_id);
            if ($stand->statut !== 'approuve') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce stand n\'est plus disponible.'
                ], 400);
            }

            // Récupérer les produits et calculer le total
            $products = Product::whereIn('id', collect($request->items)->pluck('product_id'))
                        ->where('stand_id', $request->stand_id)
                        ->get()
                        ->keyBy('id');

            $totalAmount = 500;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = $products->get($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Produit introuvable: {$item['product_id']}");
                }

                $subtotal = $product->prix * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->nom_produit,
                    'product_price' => $product->prix,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal
                ];
            }

            // Créer la commande
            $order = Order::create([
                'user_id' => Auth::id(),
                'stand_id' => $request->stand_id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // Créer les items de la commande
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Commande passée avec succès !',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => $order->total_amount,
                    'items_count' => count($orderItems)
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la commande: ' . $e->getMessage()
            ], 500);
        }
    }

    // Mettre à jour le statut d'une commande
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,ready'
        ]);

        // Vérifier que c'est bien le propriétaire du stand
        if ($order->stand->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }

        $order->update(['status' => $request->status]);

        // Mettre à jour les timestamps selon le statut
        switch ($request->status) {
            case 'confirmed':
                $order->update(['confirmed_at' => now()]);
                break;
            case 'ready':
                $order->update(['ready_at' => now()]);
                break;
        }

        $clientName = $order->user->nom_complet;
        $orderNumber = $order->order_number;

        $message = match($request->status) {
            'confirmed' => "La commande {$orderNumber} de {$clientName} a été confirmée",
            'ready' => "La commande {$orderNumber} de {$clientName} est en cours de livraison"
        };

        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $request->status,
            'client_name' => $clientName,
            'order_number' => $orderNumber
        ]);
    }

}
