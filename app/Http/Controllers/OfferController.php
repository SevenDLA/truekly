<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;


class OfferController extends Controller
{
    //
    public function offer_formulario($id_oferta = '')
    {
        $oferta = empty($id_oferta) ? new Offer() : Offer::findOrFail($id_oferta);
        $tipo_oper = empty($id_oferta) ? 'Crear oferta' : 'Editar oferta';

        return view('offers.offer_form', compact('oferta', 'tipo_oper'));
    }

    public function almacenar_offer(Request $request)
    {
        $user = auth()->user();
        $maxTokens = $user->tokens;

        $validatedData = $request->validate([
            'tokens' => ['required', 'numeric', 'min:0', 'max:' . $maxTokens],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $oferta = empty($request->id_oferta) ? new Offer() : Offer::findOrFail($request->id_oferta);

        $oferta->user_seller_id = Auth::id();
        $oferta->tokens = $request->tokens;
        $oferta->price = $request->price;


        $oferta->save();

        return redirect()->route('profile.normal')
               ->with('success', 'Oferta '.($request->id_oferta ? 'actualizado' : 'creado').' correctamente');
    }

    public function coger_ofertas_usuario()
    {
        $userId = Auth::id();
        $ofertas = Offer::where('user_seller_id', $userId)->get();

        return response()->json($ofertas);
    }

    public function coger_todas_ofertas()
    {
        $ofertas = Offer::all();
        $ESTADO = Offer::ESTADO;

        return view('marketplace', compact('ofertas', 'ESTADO'));
    }

    public function ver_oferta($id_oferta)
    {
        $oferta = Offer::findOrFail($id_oferta);

        return view('test', compact('oferta'));
    }
    
    public function show($cantidad_tokens, $precio_tokens, $id_seller = null, $id_oferta = null)
    {
        if($id_seller)
            $seller = User::find($id_seller);
        else
            $seller = null;

        if($id_oferta)
            $offer = User::find($id_oferta);
        else
            $offer = null;    

        return view('buy', compact('cantidad_tokens', 'precio_tokens', 'seller', 'offer'));
    }
}
