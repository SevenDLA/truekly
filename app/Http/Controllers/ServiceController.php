<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Compra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function listado(Request $request)
     {
         // Obtener los parámetros de filtrado
         $maxPrice = $request->input('maxPrice');
         $categoriesString = $request->input('categories');
         $userFilter = $request->input('user');

         // Convertir string de categorías a array
         $categories = !empty($categoriesString) ? explode(',', $categoriesString) : [];
         $categories = array_filter($categories); // Eliminar elementos vacíos

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
 
         // Obtener usuarios solo con el campo username para el filtro
         $users = User::select('id', 'username')->orderBy('username')->get();
 
         // Devolver la vista parcial si es una solicitud AJAX
         if ($request->ajax()) {
             return view('services.partials.service_list', compact('services'))->render();
         }
 
         // Devolver la vista completa si no es AJAX
         return view('services.service', compact('services', 'maxPrice', 'categories', 'userFilter', 'users'));
     }

     public function mostrar($id)
     {
        return $this->formulario('cons', $id);
     }

     public function admin_mostrar($id)
     {
         // Fetch the service by its ID
         $service = Service::findOrFail($id);
 
         // Pass the service to the view
         return $this->formulario('cons', $id);
     }

    public function actualizar($id)
    {
        return $this->formulario('modi', $id);
    }

    public function eliminar($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.admin.listado')->with('success', 'Usuario eliminado correctamente');
    }

    public function alta()
    {
        return $this->formulario();
    }

    public function formulario($oper = '', $id = '')
    {
        $service  = empty($id) ? new Service() : Service::findOrFail($id);
        $CONTACT  = Service::CONTACT;
        $CATEGORY = Service::CATEGORY;

        return view('admin.service_form', compact('service', 'oper', 'CONTACT', 'CATEGORY'));
    }

    public function admin_almacenar(Request $request)
    {
        $validacion_contact  = implode(',', array_keys(Service::CONTACT));
        $validacion_category = implode(',', array_keys(Service::CATEGORY));

        if ($request->oper == 'supr') {
            $service = Service::findOrFail($request->id);
            $service->delete();
            return redirect()->route('services.listado')
                   ->with('success', 'Servicio eliminado correctamente');
        }

        $rules = [
            'title'       => ['required', 'string', 'max:75'],
            'description' => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category'    => ['required', 'in:' . $validacion_category],
            'contact'     => ['required', 'in: '. $validacion_contact],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        // Mensajes de error en español
        $messages = [
        'title.required'         => 'El título es obligatorio.',
        'title.string'           => 'El título debe ser una cadena de texto.',
        'title.max'              => 'El título no debe exceder los 75 caracteres.',
        
        'description.required'   => 'La descripción es obligatoria.',
        'description.string'     => 'La descripción debe ser una cadena de texto.',
        
        'price.required'         => 'El precio es obligatorio.',
        'price.numeric'          => 'El precio debe ser un valor numérico.',
        'price.min'              => 'El precio no puede ser negativo.',
        
        'stock.required'         => 'El stock es obligatorio.',
        'stock.integer'          => 'El stock debe ser un número entero.',
        'stock.min'              => 'El stock no puede ser negativo.',
        
        'category.required'      => 'La categoría es obligatoria.',
        'category.in'            => 'La categoría seleccionada no es válida.',
        
        'contact.required'       => 'El tipo de contacto es obligatorio.',
        'contact.in'             => 'El tipo de contacto seleccionado no es válido.',
        
        'image.image'            => 'El archivo debe ser una imagen.',
        'image.mimes'            => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
        'image.max'              => 'La imagen no puede ser mayor a 2MB.',
    ];
    // Validate the request
    $validatedData = $request->validate($rules, $messages);

        $service = empty($request->id) ? new Service() : Service::findOrFail($request->id);

        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->contact = $request->contact;
        $service->category = $request->category;
       if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Store the image in the public directory
            $service->image = $imagePath; // Save the image path in the database
        } else {
            $service->image = 'images/default.jpg'; // Default image
        }

        
        if (empty($request->id)) {
            $service->user_id = Auth::id();
        }

        $service->save();

        if ($request->oper == 'modi') {
            return redirect()->route('admin.services.mostrar', $service->id)
                   ->with('success', 'Servicio actualizado correctamente');
        }

        return redirect()->route('services.admin.listado')
               ->with('success', 'Servicio '.($request->id ? 'actualizado' : 'creado').' correctamente');
    }

    // Métodos para usuarios normales
    public function service_formulario($id_servicio = '')
    {
        $servicio = empty($id_servicio) ? new Service() : Service::findOrFail($id_servicio);
        $tipo_oper = empty($id_servicio) ? 'Crear servicio' : 'Editar servicio';
        $CONTACT = Service::CONTACT;
        $CATEGORY = Service::CATEGORY;

        return view('services.service_form', compact('servicio', 'tipo_oper', 'CONTACT','CATEGORY'));
    }

    public function almacenar_servicio(Request $request)
    {
        $validacion_contact  = implode(',', array_keys(Service::CONTACT));
        $validacion_category = implode(',', array_keys(Service::CATEGORY));

        // Reglas de validación
        $rules = [
            'title'       => ['required', 'string', 'max:75'],
            'description' => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category'    => ['required', 'in:' . $validacion_category],
            'contact'     => ['required', 'in: '. $validacion_contact],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        // Mensajes de error en español
        $messages = [
        'title.required'         => 'El título es obligatorio.',
        'title.string'           => 'El título debe ser una cadena de texto.',
        'title.max'              => 'El título no debe exceder los 75 caracteres.',
        
        'description.required'   => 'La descripción es obligatoria.',
        'description.string'     => 'La descripción debe ser una cadena de texto.',
        
        'price.required'         => 'El precio es obligatorio.',
        'price.numeric'          => 'El precio debe ser un valor numérico.',
        'price.min'              => 'El precio no puede ser negativo.',
        
        'stock.required'         => 'El stock es obligatorio.',
        'stock.integer'          => 'El stock debe ser un número entero.',
        'stock.min'              => 'El stock no puede ser negativo.',
        
        'category.required'      => 'La categoría es obligatoria.',
        'category.in'            => 'La categoría seleccionada no es válida.',
        
        'contact.required'       => 'El tipo de contacto es obligatorio.',
        'contact.in'             => 'El tipo de contacto seleccionado no es válido.',
        
        'image.image'            => 'El archivo debe ser una imagen.',
        'image.mimes'            => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
        'image.max'              => 'La imagen no puede ser mayor a 2MB.',
    ];

        // Validate the request
        $validatedData = $request->validate($rules, $messages);


        $service = empty($request->id_servicio) ? new Service() : Service::findOrFail($request->id_servicio);

        $service->user_id = Auth::id();
        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->stock = $request->stock;
        $service->contact = $request->contact;
        $service->category = $request->category;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Store the image in the public directory
            $service->image = $imagePath; // Save the image path in the database
        } else {
            $service->image = 'images/default.jpg'; // Default image
        }

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

    public function show($id)
    {
        // Find the service by its ID
        $service = Service::findOrFail($id);

        // Pass the service data to the view
        return view('services.purchase', compact('service'));
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
        $max_cantidad = 2;

        if(isset($carrito[$id_servicio]['quantity']))
        {
            $cantidad = $carrito[$id_servicio]['quantity'];
        }
        else
        {
            $cantidad = DB::table('compras')
            ->where('service_id', $id_servicio)  
            ->where('status', 'P')               
            ->where('user_buyer_id', Auth::id())   
            ->count(); 
        }


        if ($cantidad >= $max_cantidad ) 
        {
            $response_data = ["error" => 'Superado la cantidad máxima de servicios: ' . $max_cantidad];
        }
        else
        {
            $carrito[$id_servicio] = [
                'id'        => $servicio->id,
                'title'      => $servicio->title,
                'price'     => $servicio->price,
                'image'     => $servicio->image,
                'quantity'  => $cantidad + 1
            ];
            
            session(['carrito' => $carrito]);
    
            $response_data = 
            [
                "exito"     => 'Servicio añadido correctamente',
                "carrito"   => $carrito
            ];
        }


        return response()->json($response_data);
    }

    public function quitar_servicio_carrito(Request $request)
    {
        $id_servicio = $request->input('id');
        $carrito = session('carrito', []);
        $quantity = $carrito[$id_servicio]['quantity'];

        if (array_key_exists($id_servicio, $carrito)) {
            unset($carrito[$id_servicio]);
            session(['carrito' => $carrito]);

            return response()->json([
                'exito' => 'Servicio eliminado del carrito',
                'carrito' => $carrito,
                'id_servicio'=> $id_servicio,
                'quantity'   => $quantity
            ]);
        }

        return response()->json([
            'error' => 'Servicio no encontrado en el carrito'
        ], 404);
    }

    public function listado_admin(Request $request)
    {
        $CONTACT  = Service::CONTACT;
        $CATEGORY = Service::CATEGORY;

        $query = Service::with('user');

        // Aplicar búsqueda de manera independiente
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('username', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Aplicar filtros de precio
        if ($request->filled('filter')) {
            if ($request->filter === 'high_price') {
                $query->where('price', '>=', 50);
            } elseif ($request->filter === 'low_price') {
                $query->where('price', '<', 50);
            }
        }

        $services = $query->paginate(15);

        // Si es una petición AJAX, devolver vista parcial
        if ($request->ajax()) {
            $view = view('admin.partials.services_table', compact('services'))->render();
            return response()->json([
                'html' => $view,
                'pagination' => view('admin.partials.pagination', compact('services'))->render()
            ]);
        }

        return view('admin.service', compact('services', 'CATEGORY', 'CONTACT'));
    }
}