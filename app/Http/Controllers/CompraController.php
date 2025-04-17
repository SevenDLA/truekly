<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function crear_compra(Request $request)
    {
        // Debugging by logging the received data
        \Log::info('Received Data:', $request->all());

        
        return response()->json($request->all());
    }

}
