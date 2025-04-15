<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Service;

use App\Http\Controllers\UserController;

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



    public function formulario($oper = '', $id = '')
    {
        // Si hay un ID, buscar la compra; si no, crear una nueva
        $purchase = empty($id) ? new Service() : Service::find($id);
    
        // Opcional: si necesitas cargar información adicional, como usuarios o servicios
        $users = User::all(); 
        $services = Service::all(); 
    
        return view('services.purchase', compact('purchase', 'users', 'services', 'oper'));
    }
    

    public function mostrar($id)
    {
        // Fetch the service by its ID
        $service = Service::findOrFail($id);

        // Pass the service to the view
        return view('services.purchase', compact('service'));
    }


    function actualizar($id)
    {
        return $this->formulario('modi', $id);

    }


    function eliminar($id)
    {
        return $this->formulario('supr', $id);

    }


    function alta()
    {
        return $this->formulario();
    }

    function almacenar(Request $request)
    {

        if ($request->oper == 'supr')
        {

            $user = User::find($request->id);
            $user->delete();

            $salida = redirect()->route('users.listado');
        }
        else
        {
            $validacion_sex = '';
            foreach(User::SEX as $codigo_sex => $texto_sex)
            {
                $validacion_sex .= $codigo_sex .',';
            }

            $validacion_sex = substr($validacion_sex,0,-1);
            
            $validatedData = $request->validate([
                'name'            => 'required|string|max:255',
                'surname'         => 'required|string|max:255',
                'username'        => 'required|string',
                'email'           => 'required|string',
                'sex'             => 'required|in:'.$validacion_sex,
                'date_of_birth'   => 'required|string',
                'phone_number'    => 'required|string',
                'password'    => 'required|string',
            ]);

            
        

            $user = empty($request->id)? new User() : User::find($request->id);

            $user->name          = $request->name;
            $user->surname       = $request->surname;
            $user->username      = $request->username;
            $user->email         = $request->email;
            $user->sex           = $request->sex;
            $user->date_of_birth = $request->date_of_birth;
            $user->phone_number  = $request->phone_number;
            $user->password  = $request->password;


            $user->save();


            $salida = redirect()->route('users.alta')->with([
                    'success'  => 'Usuario insertado correctamente.'
                    ,'formData' => $user
                ]
            );

        }

        return $salida;
    }
    
    /**MANEJO DE SERVICIOS POR PARTE DEL USUARIO**/

    function service_formulario($modi='', $id_servicio='')
    {
        $servicio = empty($id_servicio) ? new Service() : Service::find($id_servicio);
        $a= "hello";

        return view('services.service_form', compact('servicio', 'a'));
    }

    function almacenar_servicio(Request $request)
    {
        $validatedData = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string|max:255',
            'price'            => 'required|integer',
        ]);
      
        $service = empty($request->id_servicio)? new Service() : Service::find($request->id_servicio);

        $service->user_id     = auth()->id();
        $service->title       = $request->title;
        $service->description = $request->description;
        $service->price       = $request->price;

        $service->save();

        return redirect()->route('profile.normal');
    }

    function eliminar_servicio_usuario($id)
    {
        $id = (int) $id;

        $servicio = Service::find($id);


        $servicio->delete();
        
        return redirect()->route('profile.normal')->with('success', 'Service deleted successfully.');
    }

    function modificar_servicio_usuario($id_usuario,$id_servicio)
    {
        $servicio = Service::find($id_servicio);
        return view('services.edit_service', compact('id_usuario', 'id_servicio', 'servicio'));
    }

    
    public function getUserServicesAjax($userId)
    {
        $user = User::with('services')->findOrFail($userId);
        return response()->json($user->services);
    }
    

    public function anhadir_servicio_carrito(Request $request)
    {
        $id_servicio = $request->input('id');
        $servicio = Service::findOrFail($id_servicio);
        $carrito = session('carrito', []);


        if (in_array($id_servicio, $carrito)) {
            return response()->json(["error" => 'Servicio ya en el carrito']);
        }

        $carrito[$id_servicio] = $servicio->precio;
        
        session(['carrito' => $carrito]);

        return response()->json(["exito" => 'Servicio añadido correctamente']);
    }

}
