<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class CartController extends Controller
{

    public function actualizarCantidad(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $servicio = Service::find($id);
        
        if (!$servicio) {
            return response()->json(['success' => false]);
        }

        // Validar cantidad máxima
        $maxQuantity = min(3, $servicio->stock);
        if ($quantity < 1 || $quantity > $maxQuantity) {
            return response()->json(['success' => false]);
        }

        $carrito = session('carrito', []);
        if (isset($carrito[$id])) {
            $carrito[$id]['quantity'] = $quantity;
            session(['carrito' => $carrito]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

}