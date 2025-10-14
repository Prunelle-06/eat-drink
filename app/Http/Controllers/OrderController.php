<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Berkayk\OneSignal\OneSignal;
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

    // Recommander une commande
    public function reOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Vérifier que le stand existe toujours
        if ($order->stand->statut !== 'approuve') {
            return response()->json([
                'success' => false,
                'message' => 'Ce stand n\'est plus disponible'
            ], 400);
        }
        
        // Vérifier disponibilité des produits
        foreach ($order->items as $item) {
            if (!Product::where('id', $item->product_id)->where('stand_id', $order->stand_id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certains produits ne sont plus disponibles'
                ], 400);
            }
        }
        
        // Créer nouvelle commande
        try {
            DB::beginTransaction();

            $newOrder = Order::create([
                'user_id' => Auth::id(),
                'stand_id' => $order->stand_id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $order->total_amount,
                'status' => 'pending'
            ]);
            
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                $newOrder->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $product->nom_produit,
                    'product_price' => $product->prix,
                    'quantity' => $item->quantity,
                    'subtotal' => $product->prix * $item->quantity
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Nouvelle commande créée avec succès !'
                // 'redirect_url' => route('orders.show', $newOrder->id)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la commande'
            ], 500);
        }
    }

    // Annuler une commande
    public function cancelOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Vérifier si annulation possible
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cette commande ne peut plus être annulée'
            ], 400);
        }
        
        $order->update(['status' => 'cancelled']);
        
        // Notification à l'exposant
        \OneSignal::sendNotificationUsingTags(
            "Commande annulée : {$order->order_number} par {$order->user->nom_complet}",
            [
                ["field" => "tag", "key" => "user_id", "relation" => "=", "value" => (string)$order->stand->user_id]
            ],
            // route('exposant.orders'),
            [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->user->nom_complet,
                'type' => 'order_cancelled_by_customer'
            ]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Commande annulée avec succès'
        ]);
    }

    public function confirmOrder(Request $request, Order $order)
    {
        if ($order->stand->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }

        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'La commande doit être en attente pour être marquée comme confirmé'
            ], 400);
        }

        $order->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);    
        
        // Notification au client
        \OneSignal::sendNotificationToExternalUser(
            "Votre commande #{$order->order_number} de chez {$order->stand->nom_stand} est confirmée !",
            (string)$order->user_id,
            route('home'),
            [
                'order_id' => $order->id,
                'type' => 'order_confirmed',
                'stand_name' => $order->stand->nom_stand
            ]
        );

        $clientName = $order->user->nom_complet;
        $orderNumber = $order->order_number;

        return response()->json([
            'success' => true,
            'message' => "La commande {$orderNumber} de {$clientName} a été confirmée",
        ]);
    }

    public function markOrderReady(Request $request, Order $order)
    {
        if ($order->stand->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }

        if ($order->status !== 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'La commande doit être confirmée avant d\'être marquée comme prête'
            ], 400);
        }

        // Générer code unique
        $pickupCode = Order::generateUniqueCode();

        $order->update([
            'status' => 'ready',
            'pickup_code' => $pickupCode,
            'code_generated_at' => now(),
            'ready_at' => now()
        ]);

        // Envoyer notification au client
        \OneSignal::sendNotificationToExternalUser(
            "Votre commande {$order->order_number} de chez {$order->stand->nom_stand} est prête! Code de retrait: {$pickupCode}",
            (string)$order->user_id, 
            route('home'),
            [
                'order_id' => $order->id,
                'pickup_code' => $pickupCode,
                'type' => 'order_ready'
            ]
        );

        return response()->json([
            'success' => true,
            'message' => "Commande prête! Code envoyé au client"
        ]);
    }

}
