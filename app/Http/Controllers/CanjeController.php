<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanjeController extends Controller
{
    public function index()
    {
        // Consultar datos desde la API
        $response = Http::get('http://localhost:3000/get_registro');
        $tabla_estadocanje = Http::get('http://localhost:3000/get_estado_canje');
        $tabla_producto = Http::get('http://localhost:3000/get_producto');
        $tabla_paciente = Http::get('http://localhost:3000/get_pacientes');
        $tabla_farmacia = Http::get('http://localhost:3000/get_farmacias');
        $tabla_registro = Http::get('http://localhost:3000/get_tipo_registro');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión

        // Permisos predeterminados
        $permiso_insercion = 2;
        $permiso_actualizacion = 2;
        $permiso_eliminacion = 2;

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 7 (canjes)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 7) // ID del objeto que corresponde a "canjes"
                ->first();

            // Si se encuentran permisos para este rol y objeto, asignarlos
            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion;
                $permiso_actualizacion = $permisos->permiso_actualizacion;
                $permiso_eliminacion = $permisos->permiso_eliminacion;
            }
        }

        // Retornar vista con datos y permisos
        return view('modulo_canjes.Canjes')->with([
            'tblestadocanje' => json_decode($tabla_estadocanje, true),
            'tblproducto' => json_decode($tabla_producto, true),
            'tblpaciente' => json_decode($tabla_paciente, true),
            'tblfarmacia' => json_decode($tabla_farmacia, true),
            'tblregistro' => json_decode($tabla_registro, true),
            'Canjes' => json_decode($response, true),
            'permiso_insercion' => $permiso_insercion,
            'permiso_actualizacion' => $permiso_actualizacion,
            'permiso_eliminacion' => $permiso_eliminacion,
        ]);
    }

    public function store(Request $request)
    {
        // Validar permisos antes de realizar la operación
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2;

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol'];

            // Consultar permisos en la base de datos para el rol y objeto 7 (canjes)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 7) // ID del objeto que corresponde a "canjes"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion;
            }
        }

        if ($permiso_insercion == 1) {
            $response = Http::post('http://localhost:3000/insert_registro', [
                'id_tipo_registro' => $request->get('registro'),
                'id_farmacia' => $request->get('farmacia'),
                'id_paciente' => $request->get('paciente'),
                'id_producto' => $request->get('producto'),
                'cantidad' => $request->get('cantidad'),
                'id_estado_canje' => $request->get('estadocanje'),
                'comentarios' => $request->get('comentarios'),
            ]);
        } else {
            return redirect('Canjes')->with('error', 'No tienes permiso para realizar esta acción.');
        }

        return redirect('Canjes');
    }
}
