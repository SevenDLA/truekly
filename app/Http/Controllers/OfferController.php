<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Offer;

class OfferController extends Controller
{
    //
    public function offer_formulario($id_oferta = '')
    {
        $oferta = empty($id_oferta) ? new Service() : Service::findOrFail($id_oferta);
        $tipo_oper = empty($id_oferta) ? 'Crear oferta' : 'Editar oferta';

        return view('services.service_form', compact('oferta', 'tipo_oper'));
    }
}
