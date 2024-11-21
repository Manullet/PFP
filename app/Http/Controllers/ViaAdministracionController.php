<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ViaAdministracionController extends Controller
{
    public function index()
    {
        // Consultar datos desde la API
        $response = Http::get('http://localhost:3000/get_via_administracion');
        $tabla_estado = Http::get('http://localhost:3000/estados');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2; // Valor predeterminado para inserción
        $permiso_edicion = 2; // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 12 (vía administración)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 12) // ID del objeto que corresponde a "vía administración"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;  // Valor predeterminado 2
                $permiso_edicion = $permisos->permiso_edicion ?? 2;      // Valor predeterminado 2
            }
        }

        return view('modulo_mantenimiento.ViaAdministracion')->with([
            'ViaAdmin' => json_decode($response, true),
            'tblestado' => json_decode($tabla_estado, true),
            'permiso_insercion' => $permiso_insercion,
            'permiso_edicion' => $permiso_edicion,
        ]);
    }

    public function store(Request $request)
    {
        // Validar permisos antes de realizar la operación
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2; // Valor predeterminado para inserción

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol'];

            // Consultar permisos en la base de datos para el rol y objeto 12 (vía administración)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 12) // ID del objeto que corresponde a "vía administración"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2; // Valor predeterminado
            }
        }

        if ($permiso_insercion == 1) {
            $response = Http::post('http://localhost:3000/insert_via_administracion', [
                'via_administracion' => $request->get('via'),
                'id_estado' => $request->get('estdo'),
            ]);

            if ($response->successful()) {
                $mensaje = $response->json()['mensaje'] ?? 'Vía de administración creada exitosamente.';
                return redirect()->back()->with('status_message', $mensaje);
            } else {
                return redirect()->back()->with('status_message', 'Hubo un error al crear la vía de administración.');
            }
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para realizar esta acción.');
        }
    }

    public function update(Request $request)
    {
        // Validar permisos antes de realizar la operación
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_edicion = 2; // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol'];

            // Consultar permisos en la base de datos para el rol y objeto 12 (vía administración)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 12) // ID del objeto que corresponde a "vía administración"
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2; // Valor predeterminado
            }
        }

        if ($permiso_edicion == 1) {
            $response = Http::put('http://localhost:3000/update_via_administracion', [
                'id_via_administracion' => $request->get('cod'),
                'via_administracion' => $request->get('via'),
                'id_estado' => $request->get('estdo'),
            ]);

            if ($response->successful()) {
                $mensaje = $response->json()['mensaje'] ?? 'Vía de administración actualizada exitosamente.';
                return redirect()->back()->with('status_message', $mensaje);
            } else {
                return redirect()->back()->with('status_message', 'Hubo un error al actualizar la vía de administración.');
            }
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para realizar esta acción.');
        }
    }
}
