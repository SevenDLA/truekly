<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Compra;
use App\Models\User;
use App\Models\Service;

class CompraController extends Controller
{
    public function crear_compra(Request $request)
    {
        $productos = $request->input('productos');

        $all_compra = [];
        foreach ($productos as $producto) 
        {   
            $compra_data = 
            [
                'user_buyer_id'  => auth()->id(),           // current logged-in user
                'user_seller_id' => $producto['user_id'],   // from the product data
                'service_id'     => $producto['id'],        // the service being bought
                'status'         => 'P'                     
            ];
            $this->almacenar_compra($compra_data);
            $all_compra[] = $compra_data;
        }

        
        return response()->json(
            [
                'message'   => 'Processed successfully',
                'compras'   => $all_compra
            ]);
    }
    

    function almacenar_compra($compra_data)
    {
        $compra = new Compra();

        $compra->user_buyer_id  = $compra_data['user_buyer_id'];
        $compra->user_seller_id = $compra_data['user_seller_id'];
        $compra->service_id     = $compra_data['service_id'];
        $compra->status         = $compra_data['status'];

        $compra->save();
    }

    function listado_compras()
    {
        $compras = Compra::all();

        return view('test', compact('compras'));
    }
}
