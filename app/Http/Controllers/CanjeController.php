<?php

namespace App\Http\Controllers;
//incluimos Http
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class CanjeController extends Controller
{


    public function index()
    {
        $response = Http::get('http://localhost:3000/get_registro');
        $tabla_estadocanje = Http::get('http://localhost:3000/get_estado_canje');
        $tabla_producto = Http::get('http://localhost:3000/get_producto');
        $tabla_paciente = Http::get('http://localhost:3000/get_pacientes');
        $tabla_farmacia = Http::get('http://localhost:3000/get_farmacias');
        $tabla_registro = Http::get('http://localhost:3000/get_tipo_registro');
       
        
        
        return view('modulo_canjes.Canjes')->with([
        'tblestadocanje'=> json_decode($tabla_estadocanje,true),
        'tblproducto'=> json_decode($tabla_producto,true),
        'tblpaciente'=> json_decode($tabla_paciente,true),
        'tblfarmacia'=> json_decode($tabla_farmacia,true),
        'tblregistro'=> json_decode($tabla_registro,true),
        'Canjes'=> json_decode($response,true)
    ]);
    }


    
    public function store(Request $request)
    {
        $response = Http::post('http://localhost:3000/insert_registro', [
            'id_tipo_registro' => $request->get('registro'),
            'id_farmacia' => $request->get('farmacia'),
            'id_paciente' => $request->get('paciente'),
           'id_producto' => $request->get('producto'),
            'cantidad' => $request->get('cantidad'),
            'id_estado_canje' => $request->get('estadocanje'),
            'comentarios' => $request->get('comentarios'),

        ]);
  
 return redirect('Canjes');
       
    }

}