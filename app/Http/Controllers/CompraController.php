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
    function listado_admin(Request $request)
    {
        $ESTADO = Compra::ESTADO;
        $query = Compra::query();

        // Aplicar búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('service', function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('buyer', function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('seller', function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%");
            });
        }

        // Aplicar filtro de estado
        if ($request->filled('filter')) {
            if ($request->filter === 'completed') {
                $query->where('status', 'T');
            } elseif ($request->filter === 'in_process') {
                $query->where('status', 'P');
            }
        }

        $compras = $query->paginate(7);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.compra', ['compras' => $compras, 'ESTADO' => $ESTADO, 'is_ajax' => true])->render(),
                'pagination' => (string) $compras->appends(request()->query())->links()
            ]);
        }

        return view('admin.compra', compact('compras', 'ESTADO'));
    }

    //Conseguir servicios del usuario ya sean los comprados o vendidos
    function user_servicios(Request $request)
    {
        $type = $request->type == 'bought' ? 'user_buyer_id' : 'user_seller_id';

        $compras = Compra::with(['service', 'seller', 'buyer'])
            ->where($type, auth()->id())
            ->get();

        $servicios = $compras->transform(function ($compra) {
        $estado = Compra::ESTADO[$compra->status] ?? 'Unknown';

        $service = $compra->service->replicate();

        // Añadir info de la compra
        $service->compra_id = $compra->id;
        $service->estado = $estado;

        // Coger nombres de los buyers y sellers
        $service->seller_name = $compra->seller ? $compra->seller->username : 'Unknown Seller';
        $service->buyer_name = $compra->buyer ? $compra->buyer->username : 'Unknown Buyer';

        // Añadir datos del vendedor
        $service->seller_email = $compra->seller->email ?? 'Sin email';
        $service->seller_phone = $compra->seller->phone_number ?? 'Sin teléfono';

        // Coger valores del tiempo
        $service->compra_created_at = $compra->created_at->format('Y-m-d H:i');
        $service->compra_updated_at = $compra->updated_at->format('Y-m-d H:i');

        return $service;
    });

        // Ordenar: poner "TERMINADO" al final
        $servicios = $servicios->sortBy(function ($service) {
            return $service->estado === 'TERMINADO' ? 1 : 0;
        })->values(); // Resetear los índices

        return response()->json($servicios);
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
