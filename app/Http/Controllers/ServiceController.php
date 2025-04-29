<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Compra;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function listado(Request $request)
     {
         // Obtener los parámetros de filtrado
         $maxPrice = $request->input('maxPrice');
         $categories = $request->input('categories', []);
         $userFilter = $request->input('user');
 
         // Consulta base
         $query = Service::with('user');
 
         // Aplicar filtros
         if ($maxPrice && $maxPrice > 0) { // Solo aplicar filtro si el precio máximo es mayor que 0
             $query->where('price', '<=', $maxPrice);
         }
         if (!empty($categories)) {
             $query->whereIn('category', $categories);
         }
         if ($userFilter) {
             $query->where('user_id', $userFilter); // Filtrar por ID de usuario
         }
 
         // Paginar los resultados
         $services = $query->paginate(9);
 
         // Obtener todos los usuarios para el filtro de usuario
         $users = User::all();
 
         // Devolver la vista parcial si es una solicitud AJAX
         if ($request->ajax()) {
             return view('services.partials.service_list', compact('services'))->render();
         }
 
         // Devolver la vista completa si no es AJAX
         return view('services.service', compact('services', 'maxPrice', 'categories', 'userFilter', 'users'));
     }

     public function mostrar($id)
     {
         // Fetch the service by its ID
         $service = Service::findOrFail($id);
 
         // Pass the service to the view
         return view('services.purchase', compact('service'));
     }

    public function actualizar($id)
    {
        return $this->formulario('modi', $id);
    }

    public function eliminar($id)
    {
        return $this->formulario('supr', $id);
    }

    public function alta()
    {
        return $this->formulario();
    }

    public function formulario($oper = '', $id = '')
    {
        $service = empty($id) ? new Service() : Service::findOrFail($id);
        return view('admin.service_form', compact('service', 'oper'));
    }

    public function almacenar(Request $request)
    {
        if ($request->oper == 'supr') {
            $service = Service::findOrFail($request->id);
            $service->delete();
            return redirect()->route('services.listado')
                   ->with('success', 'Servicio eliminado correctamente');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|string'
        ]);

        $service = empty($request->id) ? new Service() : Service::findOrFail($request->id);

        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->is_active = $request->has('is_active');
        $service->image = $request->image;
        
        if (empty($request->id)) {
            $service->user_id = Auth::id();
        }

        $service->save();

        if ($request->oper == 'modi') {
            return redirect()->route('services.mostrar', $service->id)
                   ->with('success', 'Servicio actualizado correctamente');
        }

        return redirect()->route('services.listado')
               ->with('success', 'Servicio '.($request->id ? 'actualizado' : 'creado').' correctamente');
    }

    // Métodos para usuarios normales
    public function service_formulario($id_servicio = '')
    {
        $servicio = empty($id_servicio) ? new Service() : Service::findOrFail($id_servicio);
        $tipo_oper = empty($id_servicio) ? 'Crear servicio' : 'Editar servicio';

        return view('services.service_form', compact('servicio', 'tipo_oper'));
    }

    public function almacenar_servicio(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string'
        ]);

        $service = empty($request->id_servicio) ? new Service() : Service::findOrFail($request->id_servicio);

        $service->user_id = Auth::id();
        $service->name = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->stock = $request->stock;
        $service->image = $request->image;
        $service->is_active = true;

        $service->save();

        return redirect()->route('profile.normal')
               ->with('success', 'Servicio '.($request->id_servicio ? 'actualizado' : 'creado').' correctamente');
    }

    public function eliminar_servicio_usuario($id)
    {
        $servicio = Service::findOrFail($id);
        
        // Verificar que el servicio pertenece al usuario autenticado
        if ($servicio->user_id != Auth::id()) {
            abort(403, 'No autorizado');
        }

        $servicio->delete();
        
        return redirect()->route('profile.normal')
               ->with('success', 'Servicio eliminado correctamente');
    }

    public function modificar_servicio_usuario($id_usuario, $id_servicio)
    {
        $servicio = Service::findOrFail($id_servicio);
        
        // Verificar que el servicio pertenece al usuario
        if ($servicio->user_id != $id_usuario) {
            abort(403, 'No autorizado');
        }

        return view('services.edit_service', compact('servicio'));
    }

    // Métodos AJAX
    public function getUserServicesAjax($userId)
    {
        $user = User::with('services')->findOrFail($userId);
        $option = request()->query('option');

        switch ($option) {
            case 'bought':
                $compras = Compra::where('user_buyer_id', $userId)
                    ->with('service')
                    ->get();
                $services = $compras->pluck('service')->unique('id')->values();
                break;
            case 'sold':
                $compras = Compra::where('user_seller_id', $userId)
                    ->with('service')
                    ->get();
                $services = $compras->pluck('service')->unique('id')->values();
                break;
            default:
                $services = $user->services;
        }

        return response()->json($services);
    }

    public function anhadir_servicio_carrito(Request $request)
    {
        $id_servicio = $request->input('id');
        $servicio = Service::findOrFail($id_servicio);
        $carrito = session('carrito', []);

        if (array_key_exists($id_servicio, $carrito)) {
            return response()->json(["error" => 'Servicio ya en el carrito']);
        }

        $carrito[$id_servicio] = [
            'id' => $servicio->id,
            'name' => $servicio->name,
            'price' => $servicio->price,
            'image' => $servicio->image
        ];
        
        session(['carrito' => $carrito]);

        return response()->json([
            "exito" => 'Servicio añadido correctamente',
            "carrito" => $carrito
        ]);
    }

    public function quitar_servicio_carrito(Request $request)
    {
        $id_servicio = $request->input('id');
        $carrito = session('carrito', []);

        if (array_key_exists($id_servicio, $carrito)) {
            unset($carrito[$id_servicio]);
            session(['carrito' => $carrito]);

            return response()->json([
                'exito' => 'Servicio eliminado del carrito',
                'carrito' => $carrito
            ]);
        }

        return response()->json([
            'error' => 'Servicio no encontrado en el carrito'
        ], 404);
    }

    public function listado_admin(Request $request)
    {
        $services = Service::with('user')->paginate(15);
        return view('admin.service', compact('services'));
    }
}