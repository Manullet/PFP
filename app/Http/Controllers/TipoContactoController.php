<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TipoContactoController extends Controller
{
    public function index()
    {
        // Obtener los tipos de contacto desde la API
        $response = Http::get('http://localhost:3000/get_tipo_contacto');
        $tabla_estado = Http::get('http://localhost:3000/estados');
        
        // Validar permisos del usuario para crear y editar
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2;     // Valor predeterminado para inserción
        $permiso_edicion = 2;       // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 5 (TipoContacto)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', operator: 26) // ID del objeto que corresponde a "TipoContacto"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        return view('modulo_mantenimiento.TipoContacto')->with([
            'tblestado' => json_decode($tabla_estado, true),
            'Tp_Contacto' => json_decode($response, true),
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
                ->where('id_objeto', 26)
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
            }
        }

        if ($permiso_insercion == 1) {
            // Si el usuario tiene permiso para crear, insertamos el nuevo tipo de contacto
            $response = Http::post('http://localhost:3000/insert_tipo_contacto', [
                'tipo_contacto' => $request->get('tipo'),
                'id_estado' => $request->get('estdo')
            ]);

            return redirect('TipoContacto')->with('status_message', 'Tipo de contacto creado exitosamente.');
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para crear un nuevo tipo de contacto.');
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
                ->where('id_objeto', 26)
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        if ($permiso_edicion == 1) {
            // Si el usuario tiene permiso para editar, actualizamos el tipo de contacto
            $response = Http::put('http://localhost:3000/update_tipo_contacto', [
                'id_tipo_contacto' => $request->get('cod'),
                'tipo_contacto' => $request->get('tipo'),
                'id_estado' => $request->get('estdo'),
            ]);

            return redirect('TipoContacto')->with('status_message', 'Tipo de contacto actualizado exitosamente.');
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para editar este tipo de contacto.');
        }
    }
}
