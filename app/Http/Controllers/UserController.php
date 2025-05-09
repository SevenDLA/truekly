<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Service;
use App\Models\Compra;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{   

    function listado()
    {

        $users = User::paginate(7);

        $SEX     = User::SEX;


        return view('admin.user',compact('users','SEX'));
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

    public function eliminar($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('users.listado')->with('success', 'Usuario eliminado correctamente');
    }

    function alta()
    {
        return $this->formulario();
    }


    
    public function almacenar(Request $request)
    {
        if ($request->oper == 'supr') {
            // Eliminación de usuario
            $user = User::findOrFail($request->id);
            $user->delete();

            return redirect()->route('users.listado')
                ->with('success', 'Usuario eliminado correctamente');
        }

        // Validación de campos
        $validacion_sex = implode(',', array_keys(User::SEX));

        // Define validation rules
        $rules = [
            'name'            => ['required', 'string', 'max:255'],
            'surname'         => ['required', 'string', 'max:255'],
            'username'        => ['required', 'string', 'max:255', 'unique:users,username,' . $request->id],
            'email'           => ['required', 'email', 'unique:users,email,' . $request->id],
            'sex'             => ['required', 'in:' . $validacion_sex],
            'date_of_birth'   => ['required', 'date_format:d/m/Y'],
            'phone_number'    => ['required', 'numeric', 'digits:10'],
            'password'        => $request->id ? ['nullable', 'string', 'min:8'] : ['required', 'string', 'min:8'],
            'tokens'          => ['numeric']
        ];

        // Custom error messages
        $messages = [
            'name.required'             => 'El nombre es obligatorio.',
            'surname.required'          => 'Los apellidos son obligatorios.',
            'username.required'         => 'El nombre de usuario es obligatorio.',
            'username.unique'           => 'Este nombre de usuario ya está en uso.',
            'email.required'            => 'El correo electrónico es obligatorio.',
            'email.email'               => 'Introduce un correo electrónico válido.',
            'email.unique'              => 'Este correo ya está registrado.',
            'sex.required'              => 'El sexo es obligatorio.',
            'sex.in'                    => 'Selecciona una opción válida para el sexo.',
            'date_of_birth.required'    => 'La fecha de nacimiento es obligatoria.',
            'date_of_birth.date_format' => 'La fecha de nacimiento debe tener el formato DD/MM/AAAA.',
            'phone_number.required'     => 'El número de teléfono es obligatorio.',
            'phone_number.numeric'      => 'El número de teléfono debe contener solo números.',
            'phone_number.digits'       => 'El número de teléfono debe tener exactamente 10 dígitos.',
            'password.required'         => 'La contraseña es obligatoria.',
            'password.min'              => 'La contraseña debe tener al menos 8 caracteres.',
            'tokens.numeric'            => 'Los tokens son numéricos.'
        ];

        // Validate the request data
        $validatedData = $request->validate($rules, $messages);

        // Create or update user
        $user = empty($request->id) ? new User() : User::findOrFail($request->id);

        // Update user fields
        $user->name          = $request->name;
        $user->surname       = $request->surname;
        $user->username      = $request->username;
        $user->email         = $request->email;
        $user->sex           = $request->sex;
        $user->date_of_birth = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d'); // Format conversion
        $user->phone_number  = $request->phone_number;
        $user->tokens        = $request->tokens;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the user
        $user->save();

        // Redirect after save based on the operation type (create or update)
        if ($request->oper == 'modi') {
            return redirect()->route('users.mostrar', $user->id)
                ->with('success', 'Usuario actualizado correctamente');
        }

        return redirect()->route('users.listado')
            ->with('success', 'Usuario ' . ($request->id ? 'actualizado' : 'creado') . ' correctamente');
    }



    function perfil ()
    {
        $current_logged_in_user = Auth::user();
        $SEX = User::SEX;

        return view('normal_profile',compact('current_logged_in_user', 'SEX'));
    }


    //Para cambiar el email o teléfono del usuario.
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

        if ($request->has('tokens')){
            $rules['tokens'] = 'required|numeric';
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

        if($request->has('tokens'))
        {
            $user->tokens = $request->tokens;
        }
        
        $user->save();

        return response()->json(['message' => 'User info updated successfully!']);
    }

    //Actualizar la cantidad de tokens que un usuario tiene al comprar
    public function updateTokens(Request $request)
    {
        $user = Auth::user();
        $user->tokens = $request->tokens;
        $user->save();

        return response()->json(['message' => 'Tokens updated successfully']);
    }

    //Comprobar si un usuario existe mediante su email o username

    public function userExists($userInfo)
    {
        $user = User::where('email', $userInfo)
            ->orWhere('username', $userInfo)
            ->first();
        $exists = (is_null($user));

        

        return view('test', compact('user', 'exists',));
    }
    
    //Cambiar foto de perfil del usuario
    public function updateImage(Request $request){
        Log::info("Image upload request received", [
            'user_id' => Auth::id(), 
            'has_file' => $request->hasFile('image')
        ]);

        // Validate the uploaded image
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        Log::info("Validation passed");

        $user = Auth::user();

        try {
            // Ensure a file is present
            if (!$request->hasFile('image')) {
                Log::error("No file found in the request.");
                return response()->json([
                    'success' => false,
                    'error' => 'No file uploaded.',
                ], 400);
            }

            $file = $request->file('image');

            // Delete old image if it exists
            if (!empty($user->profile_pic) && Storage::disk('public')->exists($user->profile_pic)) {
                Log::info("Deleting old image: " . $user->profile_pic);
                Storage::disk('public')->delete($user->profile_pic);
            }

            // Generate a unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Store the image
            $path = $file->storeAs('profile_pictures', $filename, 'public');

            Log::info("File stored successfully at: " . $path);

            // Update user profile picture
            $user->profile_pic = $path;
            $user->save();

            Log::info("User profile updated successfully");

            return response()->json([
                'success' => true,
                'image_url' => asset('storage/' . $path),
            ]);
        } catch (Exception $e) {
            Log::error("Image upload failed: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Image upload failed. Please try again.',
            ], 500);
        }
    }

    


    //Coger compras hechas por el usuario
    public function user_bought_compras()
    {
        $user-> User::find(auth()->user());

        $compras = Compra::with(['seller', 'service'])
                ->where('user_buyer_id', $user->id)
                ->get();

        return response()->json([
            'success' => true,
            'compras' => $compras
        ]);
    }
}
