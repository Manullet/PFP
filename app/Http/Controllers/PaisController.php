<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index()
    {
        // Obtener la lista de países desde la API
        $response = Http::get('http://localhost:3000/get_paises');
        $tbl_Estado = Http::get('http://localhost:3000/estados');

        // Validar permisos para inserción y edición
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2;     // Valor predeterminado para inserción
        $permiso_edicion = 2;       // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 2 (Pais)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 27) // ID del objeto que corresponde a "Pais"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        return view('modulo_mantenimiento.Pais')->with([
            'tblestado' => json_decode($tbl_Estado, true),
            'Paises' => json_decode($response, true),
            'permiso_insercion' => $permiso_insercion,
            'permiso_edicion' => $permiso_edicion,
        ]);
    }

    public function store(Request $request)
    {
        // Validar permisos antes de insertar
        $usuario = session('usuario');
        $permiso_insercion = 2;

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol'];

            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 27) // ID del objeto que corresponde a "Pais"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
            }
        }

        if ($permiso_insercion == 1) {
            // Si el usuario tiene permiso para crear, insertamos el nuevo país
            $response = Http::post('http://localhost:3000/insert_pais', [
                'nombre_pais' => $request->get('pais'),
                'id_estado' => $request->get('estdo'),
            ]);

            return redirect('Pais');
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para crear un nuevo país.');
        }
    }

    public function update(Request $request)
    {
        // Validar permisos antes de actualizar
        $usuario = session('usuario');
        $permiso_edicion = 2;

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol'];

            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 27) // ID del objeto que corresponde a "Pais"
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        if ($permiso_edicion == 1) {
            // Si el usuario tiene permiso para editar, actualizamos el país
            $response = Http::put('http://localhost:3000/update_pais', [
                'id_pais' => $request->get('cod'),
                'nombre_pais' => $request->get('pais'),
                'id_estado' => $request->get('estdo'),
            ]);

            return redirect('Pais');
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para editar este país.');
        }
    }
}
