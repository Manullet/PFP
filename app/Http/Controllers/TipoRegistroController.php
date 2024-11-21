<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TipoRegistroController extends Controller
{
    public function index()
    {
        // Consultar tipo de registro desde la API
        $response = Http::get('http://localhost:3000/get_tipo_registro');
        $TpRegistro = json_decode($response, true);

        // Verificar permisos para la creación
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2; // Valor predeterminado para inserción
        $permiso_edicion = 2;   // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto (por ejemplo, TipoRegistro)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 10) // ID del objeto que corresponde a "TipoRegistro"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2; // Valor predeterminado
                $permiso_edicion = $permisos->permiso_edicion ?? 2;     // Valor predeterminado
            }
        }

        return view('modulo_mantenimiento.TipoRegistro')->with([
            "TpRegistro" => $TpRegistro,
            'permiso_insercion' => $permiso_insercion, // Enviar el permiso de inserción a la vista
            'permiso_edicion' => $permiso_edicion,     // Enviar el permiso de edición a la vista
        ]);
    }

    public function store(Request $request)
    {
        // Validar permisos antes de realizar la operación
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2; // Valor predeterminado para inserción

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto (por ejemplo, TipoRegistro)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 10) // ID del objeto que corresponde a "TipoRegistro"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2; // Valor predeterminado
            }
        }

        if ($permiso_insercion == 1) {
            // Si el usuario tiene permiso para crear, insertar el nuevo tipo de registro
            $response = Http::post('http://localhost:3000/insert_tipo_registro', [
                'tipo_registro' => $request->get('tipo')
            ]);

            // Obtener la lista de tipos de registro actualizada
            $response = Http::get('http://localhost:3000/get_tipo_registro');
            $TpRegistro = json_decode($response, true);

            // Pasar la lista de tipos de registro a la vista
            return view('modulo_mantenimiento.TipoRegistro')->with([
                "TpRegistro" => $TpRegistro,
            ]);
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para crear un nuevo tipo de registro.');
        }
    }

    public function update(Request $request)
    {
        // Validar permisos antes de realizar la operación
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_edicion = 2; // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto (por ejemplo, TipoRegistro)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 10) // ID del objeto que corresponde a "TipoRegistro"
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2; // Valor predeterminado
            }
        }

        if ($permiso_edicion == 1) {
            // Si el usuario tiene permiso para editar, actualizar el tipo de registro
            $response = Http::put('http://localhost:3000/update_tipo_registro', [
                'id_tipo_registro' => $request->get('cod'),
                'tipo_registro' => $request->get('tipo')
            ]);

            // Obtener la lista de tipos de registro actualizada
            $response = Http::get('http://localhost:3000/get_tipo_registro');
            $TpRegistro = json_decode($response, true);

            return redirect('TipoRegistro')->with([
                "TpRegistro" => $TpRegistro,
                'status_message' => 'Tipo de registro actualizado exitosamente.',
            ]);
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para actualizar este tipo de registro.');
        }
    }
}
