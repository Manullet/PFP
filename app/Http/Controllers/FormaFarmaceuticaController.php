<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FormaFarmaceuticaController extends Controller
{
    public function index()
    {
        // Consultar datos desde la API
        $response = Http::get('http://localhost:3000/get_forma_farmaceutica');
        $tabla_estado = Http::get('http://localhost:3000/estados');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2; // Valor predeterminado para inserción
        $permiso_edicion = 2;   // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 11 (forma farmacéutica)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 1) // ID del objeto que corresponde a "forma farmacéutica"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        return view('modulo_mantenimiento.FormaFarmaceutica')->with([
            'tblestado' => json_decode($tabla_estado, true),
            'FormaFarma' => json_decode($response, true),
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

            // Consultar permisos en la base de datos para el rol y objeto 11 (forma farmacéutica)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 1) // ID del objeto que corresponde a "forma farmacéutica"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
            }
        }

        if ($permiso_insercion == 1) {
            $response = Http::post('http://localhost:3000/insert_forma_farmaceutica', [
                'forma_farmaceutica' => $request->get('farma'),
                'id_estado' => $request->get('estdo'),
            ]);

            if ($response->successful()) {
                $mensaje = $response->json()['mensaje'] ?? 'Forma farmacéutica creada exitosamente.';
                return redirect()->back()->with('status_message', $mensaje);
            } else {
                return redirect()->back()->with('status_message', 'Hubo un error al crear la forma farmacéutica.');
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

            // Consultar permisos en la base de datos para el rol y objeto 11 (forma farmacéutica)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 1) // ID del objeto que corresponde a "forma farmacéutica"
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        if ($permiso_edicion == 1) {
            $response = Http::put('http://localhost:3000/update_forma_farmaceutica', [
                'id_forma_farmaceutica' => $request->get('cod'),
                'forma_farmaceutica' => $request->get('farma'),
                'id_estado' => $request->get('estdo'),
            ]);

            if ($response->successful()) {
                $mensaje = $response->json()['mensaje'] ?? 'Forma farmacéutica actualizada exitosamente.';
                return redirect()->back()->with('status_message', $mensaje);
            } else {
                return redirect()->back()->with('status_message', 'Hubo un error al actualizar la forma farmacéutica.');
            }
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para realizar esta acción.');
        }
    }
}
