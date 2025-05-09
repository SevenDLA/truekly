<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Compra;
use App\Models\User;
use App\Models\Service;

class CompraController extends Controller
{

    //Crear una compra por cada servicio del carrito.
    public function crear_compra(Request $request)
    {
        $servicios = $request->input('servicios');

        $all_compra = [];
        
        foreach ($servicios as $servicio) 
        {   
            $quantity = session('carrito.' . $servicio['id'] . '.quantity', 1);
            for ($i = 0; $i < $quantity; $i++)
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




    //Conseguir todas las compras en la BBDD.
    function listado_admin()
    {
        
        $compras = Compra::paginate(7);

        return view('admin.compra', compact('compras'));
    }
    

    //Conseguir servicios del usuario ya sean los comprados o vendidos
    function user_servicios(Request $request)
    {
        // Determine if we're fetching bought or sold services based on the request
        $type = $request->type == 'bought' ? 'user_buyer_id' : 'user_seller_id';
    
        // Fetch the purchases with their related models
        $compras = Compra::with(['service', 'seller', 'buyer'])
            ->where($type, auth()->id())
            ->get();
    
        // Transform the collection, but ensure that each compra is handled separately
        $compras->transform(function ($compra) {
            // Get the estado from the predefined constants
            $estado = Compra::ESTADO[$compra->status] ?? 'Unknown';  // Default to 'Unknown' if status is not found
    
            // Create a copy of the service to avoid shared reference issues
            $service = $compra->service->replicate();  // `replicate()` creates a new instance of the service
            
            // Modify the service for this specific compra
            $service->compra_id = $compra->id;  // Set unique compra_id for this specific compra
            $service->estado = $estado;
    
            // Handle missing seller/buyer gracefully
            $service->seller_name = $compra->seller ? $compra->seller->username : 'Unknown Seller';
            $service->buyer_name = $compra->buyer ? $compra->buyer->username : 'Unknown Buyer';
            
            // Return the transformed service for this compra
            return $service;
        });
    
        // Return the transformed services as a JSON response
        return response()->json($compras);
    }
    
    


    //Pagar los tokens al vendedor
    public function pagar_seller($id_compra)
    {
        $compra = Compra::find($id_compra);
        $compra->status = 'T';
        $compra->save();
        $servicio_vendido = Service::find($compra->service_id);
        $user_seller = User::find($compra->user_seller_id);
        $user_seller->tokens = $user_seller->tokens + $servicio_vendido->price;
        $user_seller->save();
        
        return view('/welcome');
    }
}
