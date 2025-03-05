<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Service;

use App\Http\Controllers\UserController;

class ServiceController extends Controller
{   
    function listado()
    {

        $services = Service::with('user')->paginate(7);
        return view('services.service', compact('services'));
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
    

    function mostrar($id)
    {
        return $this->formulario('cons', $id);
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
    
    /**SERVICIOS ACTUALES**/
    
    function service_formulario($id_usuario)
    {
        return view('services.create_new_service',compact('id_usuario'));
    }

    function almacenar_servicio(Request $request)
    {
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
   
}
