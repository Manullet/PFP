<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        // Consultar datos desde la API
        $response = Http::get('http://localhost:3000/get_facturas');
        $tabla_producto = Http::get('http://localhost:3000/get_producto');
        $tabla_paciente = Http::get('http://localhost:3000/get_pacientes');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión

        // Permisos predeterminados
        $permiso_insercion = 2; // 2 es el valor predeterminado para sin permiso
        $permiso_edicion = 2;   // 2 es el valor predeterminado para sin permiso

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 9 (facturas)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 17) // ID del objeto que corresponde a "facturas"
                ->first();

            // Si se encuentran permisos para este rol y objeto, asignarlos
            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        // Retornar vista con datos y permisos
        return view('modulo_canjes.Facturas')->with([
            'tblpaciente' => json_decode($tabla_paciente, true),
            'tblproducto' => json_decode($tabla_producto, true),
            'Facturas' => json_decode($response, true),
            'permiso_insercion' => $permiso_insercion,
            'permiso_edicion' => $permiso_edicion,
        ]);
    }

    public function store(Request $request)
    {
        // Validar permisos antes de realizar la operación
        $usuario = session('usuario'); // Obtener usuario desde la sesión
        $permiso_insercion = 2; // 2 es el valor predeterminado para sin permiso

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol'];

            // Consultar permisos en la base de datos para el rol y objeto 9 (facturas)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 17) // ID del objeto que corresponde a "facturas"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
            }
        }

        if ($permiso_insercion == 1) {
            // Si el usuario tiene permiso para insertar, realizamos la operación
            $response = Http::post('http://localhost:3000/insert_factura', [
                'factura' => $request->input('factura'),
                'id_paciente' => $request->input('paciente'),
                'id_producto' => $request->input('producto'),
                'cantidad_producto' => $request->input('cantidad'),
            ]);

            // Verificar si el backend devuelve un mensaje de éxito o notificación
            if ($response->successful()) {
                $mensaje = $response->json()['mensaje'] ?? 'Factura insertada exitosamente';
                return redirect()->back()->with('status_message', $mensaje);
            } else {
                return redirect()->back()->with('status_message', 'Hubo un error al procesar la factura.');
            }
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para realizar esta acción.');
        }
    }
}
