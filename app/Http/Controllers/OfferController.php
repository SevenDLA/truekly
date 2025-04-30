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
        $validatedData = $request->validate([
            'tokens' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
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

    public function coger_todas_ofertas_()
    {
        $ofertas = Offer::all();
    
        return view('ofertas.index', compact('ofertas'));
    }
    
}
