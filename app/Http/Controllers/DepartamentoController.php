<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        // Obtener la lista de departamentos, zonas y estados desde la API
        $response = Http::get('http://localhost:3000/get_departamentos');
        $tabla_zona = Http::get('http://localhost:3000/get_Zonas');
        $tabla_estado = Http::get('http://localhost:3000/estados');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión

        // Permisos predeterminados
        $permiso_insercion = 2; // 2 es el valor predeterminado para sin permiso
        $permiso_edicion = 2;   // 2 es el valor predeterminado para sin permiso

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 1 (departamento)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 29) // ID del objeto que corresponde a "departamento"
                ->first();

            // Si se encuentran permisos para este rol y objeto, asignarlos
            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        // Retornar vista con datos y permisos
        return view('modulo_mantenimiento.Departamento')->with([
            'tblestado' => json_decode($tabla_estado, true),
            'tblzona' => json_decode($tabla_zona, true),
            'Departamentos' => json_decode($response, true),
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
                ->where('id_objeto', 29) // ID del objeto que corresponde a "Departamento"
                ->first();

            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion ?? 2;
            }
        }

        // Verificar si tiene permiso para insertar
        if ($permiso_insercion == 1) {
            // Si el usuario tiene permiso para crear, insertamos el nuevo departamento
            $response = Http::post('http://localhost:3000/insert_departamento', [
                'id_zona' => $request->get('zona'),
                'nombre_departamento' => $request->get('depto'),
                'id_estado' => $request->get('estdo')
            ]);

            return redirect('Departamento')->with('status_message', 'Departamento creado exitosamente.');
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para crear un nuevo departamento.');
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
                ->where('id_objeto', 29) // ID del objeto que corresponde a "Departamento"
                ->first();

            if ($permisos) {
                $permiso_edicion = $permisos->permiso_edicion ?? 2;
            }
        }

        // Verificar si tiene permiso para editar
        if ($permiso_edicion == 1) {
            // Si el usuario tiene permiso para editar, actualizamos el departamento
            $response = Http::put('http://localhost:3000/update_departamento', [
                'id_zona' => $request->get('zona'),
                'id_departamento' => $request->get('cod'),
                'nombre_departamento' => $request->get('depto'),
                'id_estado' => $request->get('estdo')
            ]);

            return redirect('Departamento')->with('status_message', 'Departamento actualizado exitosamente.');
        } else {
            return redirect()->back()->with('status_message', 'No tienes permiso para editar este departamento.');
        }
    }
}
