<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{   

    function listado()
    {

        $users = User::paginate(7);

        $SEX     = User::SEX;


        return view('users.user',compact('users','SEX'));
    }

    function formulario($oper='', $id='')
    {
        $user = empty($id)? new User() : User::find($id);
        
        $SEX     = User::SEX;

        return view('users.formulario',compact('SEX','user','oper'));
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

            if($request->oper == 'register')
            {
                redirect(route('dashboard', absolute: false));
            }

        }

        return $salida;
    }

    function perfil ()
    {
        $current_logged_in_user = Auth::user();
        $SEX = User::SEX;

        return view('normal_profile',compact('current_logged_in_user', 'SEX'));
    }

    public function updateUserInfo(Request $request)
    {
        \Log::info('Request received:', $request->all()); // Debugging

        $rules = [
            'user_id' => 'required|exists:users,id'
        ];

        if ($request->has('email')) {
            $rules['email'] = 'required|email|unique:users,email';
        }

        if ($request->has('phone')) {
            $rules['phone'] = 'required|digits_between:9,15|unique:users,phone_number';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('phone')) {
            $user->phone_number = $request->phone;
        }

        $user->save();

        return response()->json(['message' => 'User info updated successfully!']);
    }

    
}
