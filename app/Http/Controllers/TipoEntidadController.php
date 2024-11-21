<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TipoEntidadController extends Controller
{
    public function index()
    {
        // Obtener los tipos de entidad desde la API
        $response = Http::get('http://localhost:3000/get_tipo_entidad');
        $tabla_estado = Http::get('http://localhost:3000/estados');
        
        // Verificar permisos del usuario para acceder a esta página
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2;     // Valor predeterminado para inserción
        $permiso_edicion = 2;       // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 6 (TipoEntidad)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 25) // ID del objeto que corresponde a "TipoEntidad"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        return view('modulo_mantenimiento.TipoEntidad')->with([
            'Tipentidad' => json_decode($response, true),
            'tblestado' => json_decode($tabla_estado, true),
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
                ->where('id_objeto', operator: 25)
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
            }
        }

        if ($permiso_insercion == 1) {
            // Si el usuario tiene permiso para crear, insertamos el nuevo tipo de entidad
            $response = Http::post('http://localhost:3000/insert_tipo_entidad', [
                'tipo_entidad' => $request->get('tipo'),
                'id_estado' => $request->get('estdo')
            ]);

            // Obtener los datos actualizados después de la inserción
            $response = Http::get('http://localhost:3000/get_tipo_entidad');
            $tabla_estado = Http::get('http://localhost:3000/estados');

            return view('modulo_mantenimiento.TipoEntidad')->with([
                'Tipentidad' => json_decode($response, true),
                'tblestado' => json_decode($tabla_estado, true)
            ]);
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para crear un nuevo tipo de entidad.');
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
                ->where('id_objeto', 25)
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        if ($permiso_edicion == 1) {
            // Si el usuario tiene permiso para editar, actualizamos el tipo de entidad
            $response = Http::put('http://localhost:3000/update_tipo_entidad', [
                'id_tipo_entidad' => $request->get('cod'),
                'tipo_entidad' => $request->get('tipo'),
                'id_estado' => $request->get('estdo'),
            ]);

            // Obtener los datos actualizados después de la actualización
            $response = Http::get('http://localhost:3000/get_tipo_entidad');
            $tabla_estado = Http::get('http://localhost:3000/estados');

            return redirect('TipoEntidad')->with([
                'Tipentidad' => json_decode($response, true),
                'tblestado' => json_decode($tabla_estado, true)
            ]);
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para editar este tipo de entidad.');
        }
    }
}
