<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MarcaProductoController extends Controller
{
    public function index()
    {
        // Consultar datos desde la API
        $response = Http::get('http://localhost:3000/get_marca_producto');
        $tabla_estado = Http::get('http://localhost:3000/estados');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2; // Valor predeterminado para inserción
        $permiso_edicion = 2; // Valor predeterminado para edición

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 1 (marca producto)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 19) // ID del objeto que corresponde a "marca producto"
                ->first();

            if ($permisos) {
                // Asignar los permisos a las variables correspondientes, con valor por defecto en caso de que no existan
                $permiso_insercion = $permisos->permiso_creacion ?? 2;  // Valor predeterminado 2
                $permiso_edicion = $permisos->permiso_edicion ?? 2;      // Valor predeterminado 2
            }
        }

        return view('modulo_mantenimiento.Marca')->with([
            'Marcas' => json_decode($response, true),
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

            // Consultar permisos en la base de datos para el rol y objeto 1 (marca producto)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 19) // ID del objeto que corresponde a "marca producto"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2; // Valor predeterminado
            }
        }

        if ($permiso_insercion == 1) {
            $response = Http::post('http://localhost:3000/insert_marca_producto', [
                'marca_producto' => $request->get('marca'),
                'id_estado' => $request->get('estdo'),
            ]);

            if ($response->successful()) {
                $mensaje = $response->json()['mensaje'] ?? 'Marca de producto creada exitosamente.';
                return redirect()->back()->with('status_message', $mensaje);
            } else {
                return redirect()->back()->with('status_message', 'Hubo un error al crear la marca de producto.');
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

            // Consultar permisos en la base de datos para el rol y objeto 1 (marca producto)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 19) // ID del objeto que corresponde a "marca producto"
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2; // Valor predeterminado
            }
        }

        if ($permiso_edicion == 1) {
            $response = Http::put('http://localhost:3000/update_marca_producto', [
                'id_marca_producto' => $request->get('cod'),
                'marca_producto' => $request->get('marca'),
                'id_estado' => $request->get('estdo'),
            ]);

            if ($response->successful()) {
                $mensaje = $response->json()['mensaje'] ?? 'Marca de producto actualizada exitosamente.';
                return redirect()->back()->with('status_message', $mensaje);
            } else {
                return redirect()->back()->with('status_message', 'Hubo un error al actualizar la marca de producto.');
            }
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para realizar esta acción.');
        }
    }
}
