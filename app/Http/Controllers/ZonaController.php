<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    public function index()
    {
        // Obtener la lista de zonas, países y estados desde la API
        $response = Http::get('http://localhost:3000/get_zonas');
        $tabla_estado = Http::get('http://localhost:3000/estados');
        $tabla_paises = Http::get('http://localhost:3000/get_paises');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión

        // Permisos predeterminados
        $permiso_insercion = 2; // 2 es el valor predeterminado para sin permiso
        $permiso_edicion = 2;   // 2 es el valor predeterminado para sin permiso

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 3 (zona)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)

                ->where('id_objeto', 28) // ID del objeto que corresponde a "Zona"

                ->first();

            // Si se encuentran permisos para este rol y objeto, asignarlos
            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        // Retornar vista con datos y permisos
        return view('modulo_mantenimiento.Zona')->with([
            'tblpais' => json_decode($tabla_paises, true),
            'tblestado' => json_decode($tabla_estado, true),
            'Zonas' => json_decode($response, true),
            'permiso_insercion' => $permiso_insercion,
            'permiso_edicion' => $permiso_edicion,
        ]);
    }

    public function store(Request $request)
    {
        // Validar permisos antes de insertar
        $usuario = session('usuario');
        $permiso_insercion = 2; // 2 es el valor predeterminado para sin permiso

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar los permisos de inserción
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 28) // ID del objeto que corresponde a "Zona"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
            }
        }

        if ($permiso_insercion == 1) {
            // Si el usuario tiene permiso para crear, insertamos la nueva zona
            $response = Http::post('http://localhost:3000/insert_zona', [
                'id_pais' => $request->get('pais'),
                'zona' => $request->get('zona'),
                'id_estado' => $request->get('estdo')
            ]);

            return redirect('Zona');
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para crear una nueva zona.');
        }
    }

    public function update(Request $request)
    {
        // Validar permisos antes de actualizar
        $usuario = session('usuario');
        $permiso_edicion = 2; // 2 es el valor predeterminado para sin permiso

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar los permisos de edición
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 28) // ID del objeto que corresponde a "Zona"
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        if ($permiso_edicion == 1) {
            // Si el usuario tiene permiso para editar, actualizamos la zona
            $response = Http::put('http://localhost:3000/update_zona', [
                'id_zona' => $request->get('cod'),
                'zona' => $request->get('zona'),
                'id_estado' => $request->get('estdo'),
                'id_pais' => $request->get('pais')
            ]);

            return redirect('Zona');
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para editar esta zona.');
        }
    }
}
