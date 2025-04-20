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
        $servicios = $request->input('servicios');

        $all_compra = [];
        foreach ($servicios as $servicio) 
        {   
            $compra_data = 
            [
                'user_buyer_id'  => auth()->id(),            
                'user_seller_id' => $servicio['user_id'],   
                'service_id'     => $servicio['id'],        
                'status'         => 'P'                     
            ];

            $this->almacenar_compra($compra_data);
            $all_compra[] = $compra_data;

            //Actualiza el stock del servicio comprado
            $service = Service::find($servicio['id']);
            $service->stock = $service->stock-1;
            $service->save();

            //Quita los tokens del usuario quien está comprando el servicio
            $user_buyer = User::find(auth()->id());
            $user_buyer->tokens = $user_buyer->tokens - $service->price;
            $user_buyer->save();
        }

        
        return response()->json(
            [
                'message'   => 'Processed successfully',
                'compras'   => $all_compra
            ]);
    }
    
    public function vaciar_carrito()
    {

        session(['carrito' => []]);

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
    
    function user_servicios(Request $request)
    {
        $type = $request->type == 'bought' ? 'user_buyer_id' : 'user_seller_id';
    
        $compras = Compra::with(['service', 'seller', 'buyer'])  // Eager load service, seller, and buyer
            ->where($type, auth()->id())
            ->get();
    
        $compras->transform(function ($compra) {
            $compra->service->compra_id = $compra->id;
            $compra->service->seller_name = $compra->seller->username;
            $compra->service->buyer_name = $compra->buyer->username; 
    
            return $compra->service;
        });
    
        return response()->json($compras);
    }
    
    

    function pagar_seller($id_compra)
    {
        $compra = Compra::find($id_compra);
        $servicio_vendido = Service::find($compra->service_id);
        $user_seller = User::find($compra->user_seller_id);
        $user_seller->tokens = $user_seller->tokens + $servicio_vendido->price;
    }
}
