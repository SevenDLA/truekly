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
