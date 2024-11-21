<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EstadoCanjeController extends Controller
{
    public function index()
    {
        // Consultar datos desde la API
        $response = Http::get('http://localhost:3000/get_estado_canje');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión

        // Permisos predeterminados
        $permiso_insercion = 2;
        $permiso_actualizacion = 2;
        $permiso_eliminacion = 2;

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 8 (estado canje)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 8) // ID del objeto que corresponde a "estado canje"
                ->first();

            // Si se encuentran permisos para este rol y objeto, asignarlos
            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion;
                $permiso_actualizacion = $permisos->permiso_actualizacion;
                $permiso_eliminacion = $permisos->permiso_eliminacion;
            }
        }

        // Retornar vista con datos y permisos
        return view('modulo_canjes.Estado_Canje')->with([
            'Estacanje' => json_decode($response, true),
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

            // Consultar permisos en la base de datos para el rol y objeto 8 (estado canje)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 8) // ID del objeto que corresponde a "estado canje"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion;
            }
        }

        if ($permiso_insercion == 1) {
            $response = Http::post('http://localhost:3000/insert_estado_canje', [
                'estado_canje' => $request->get('canje')
            ]);
        } else {
            return redirect('Estado_Canje')->with('error', 'No tienes permiso para realizar esta acción.');
        }

        return redirect('Estado_Canje');
    }

    public function update(Request $request)
    {
        // Validar permisos antes de realizar la operación
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_actualizacion = 2;

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol'];

            // Consultar permisos en la base de datos para el rol y objeto 8 (estado canje)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 8) // ID del objeto que corresponde a "estado canje"
                ->first();

            if ($permisos) {
                $permiso_actualizacion = $permisos->permiso_actualizacion;
            }
        }

        if ($permiso_actualizacion == 1) {
            $response = Http::put('http://localhost:3000/update_estado_canje', [
                'id_estado_canje' => $request->get('cod'),
                'estado_canje' => $request->get('canje'),
            ]);
        } else {
            return redirect('Estado_Canje')->with('error', 'No tienes permiso para realizar esta acción.');
        }

        return redirect('Estado_Canje');
    }
}
