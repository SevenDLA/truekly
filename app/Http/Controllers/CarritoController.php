<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarritoController extends Controller
{

    public function actualizarCantidad(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        
        // Validar límites
        if ($quantity < 1 || $quantity > 3) {
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