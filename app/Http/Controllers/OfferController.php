<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OfferController extends Controller
{
    public function index(Request $request)
    {
        $ofertas = Oferta::with('seller')
            ->where('status', 'E')
            ->when($request->maxPrice, function($query, $maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->when($request->minTokens, function($query, $minTokens) {
                return $query->where('tokens', '>=', $minTokens);
            })
            ->when($request->seller, function($query, $sellerId) {
                return $query->where('seller_id', $sellerId);
            })
            ->get();
    
        if ($request->ajax()) {
            return view('marketplace.partials.offer_list', [
                'ofertas' => $ofertas,
                'ESTADO' => Oferta::ESTADO
            ])->render();
        }
    
        return view('marketplace', [
            'ofertas' => $ofertas,
            'ESTADO' => Oferta::ESTADO
        ]);
    }
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

        // Validación con mensajes personalizados
        $validatedData = $request->validate([
            'tokens' => ['required', 'numeric', 'min:0', 'max:' . $maxTokens],
            'price'  => ['required', 'numeric', 'min:0'],
        ], [
            'tokens.required' => 'Debes ingresar la cantidad de TokenSkills.',
            'tokens.numeric'  => 'La cantidad de TokenSkills debe ser un valor numérico.',
            'tokens.min'      => 'Los tokens no pueden ser negativos.',
            'tokens.max'      => 'No puedes ofrecer más tokens de los que tienes (' . $maxTokens . ').',

            'price.required'  => 'El precio es obligatorio.',
            'price.numeric'   => 'El precio debe ser un valor numérico.',
            'price.min'       => 'El precio no puede ser negativo.',
        ]);

        $oferta = empty($request->id_oferta) ? new Offer() : Offer::findOrFail($request->id_oferta);

        $oferta->user_seller_id = Auth::id();
        $oferta->tokens = $validatedData['tokens'];
        $oferta->price  = $validatedData['price'];

        if (empty($request->id_oferta)) {
            $oferta->status = 'E'; // P = Pendiente
        }

        $oferta->save();

        return redirect()->route('profile.normal')
            ->with('success', 'Oferta ' . ($request->id_oferta ? 'actualizada' : 'creada') . ' correctamente');
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
            $offer = Offer::find($id_oferta);
        else
            $offer = null;    



        return view('buy', compact('cantidad_tokens', 'precio_tokens', 'seller', 'offer'));
    }

    public function actualizar_estado_oferta(Request $request)
    {
        $oferta = Offer::findOrFail($request->offerId);

        $oferta->status = ($oferta->status == 'V') ? 'E' : 'V';

        $oferta->save();
    }

    public function listado_admin(Request $request)
    {
        $query = Offer::query();

        // Aplicar búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tokens', 'LIKE', "%{$search}%")
                ->orWhere('price', 'LIKE', "%{$search}%")
                ->orWhereHas('seller', function($q) use ($search) {
                    $q->where('username', 'LIKE', "%{$search}%");
                });
            });
        }

        // Aplicar filtros
        if ($request->filled('filter')) {
            if ($request->filter === 'sold') {
                $query->where('status', 'V');
            } elseif ($request->filter === 'on_sale') {
                $query->where('status', 'E');
            }
        }

        $ofertas = $query->paginate(7);
        $ESTADO = Offer::ESTADO;

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.offer', ['ofertas' => $ofertas, 'ESTADO' => $ESTADO, 'is_ajax' => true])->render(),
                'pagination' => (string) $ofertas->appends(request()->query())->links()
            ]);
        }

        return view('admin.offer', compact('ofertas', 'ESTADO'));
    }

    public function eliminar_oferta()
    {
        $oferta = Offer::findOrFail($request->offerId);

        try 
        {
            $oferta->delete();
            return response()->json(['success' => true, 'message' => 'Oferta eliminada correctamente.']);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la oferta.']);
        }
    }
}
