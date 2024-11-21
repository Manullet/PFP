<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadoController extends Controller
{
    public function index()
    {
        // Consultar datos desde la API
        $response = Http::get('http://localhost:3000/estados');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión

        // Permisos predeterminados
        $permiso_insercion = 2;
        $permiso_actualizacion = 2;
        $permiso_eliminacion = 2;

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 5 (estados)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 1) // ID del objeto que corresponde a "estados"
                ->first();

            // Si se encuentran permisos para este rol y objeto, asignarlos
            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion;
                $permiso_actualizacion = $permisos->permiso_actualizacion;
                $permiso_eliminacion = $permisos->permiso_eliminacion;
            }
        }

        // Retornar vista con datos y permisos
        return view('modulo_mantenimiento.Estado')->with([
            'Estados' => json_decode($response, true),
            'permiso_insercion' => $permiso_insercion,
            'permiso_actualizacion' => $permiso_actualizacion,
            'permiso_eliminacion' => $permiso_eliminacion,
        ]);
    }

    public function store(Request $request)
    {
        // Verificar si el usuario tiene permiso para insertar
        $permiso_insercion = session('permiso_insercion');
        if ($permiso_insercion != 1) {
            return redirect()->back()->with('error', 'No tiene permiso para insertar estados.');
        }

        // Enviar la solicitud POST a la API para insertar el nuevo estado
        $response = Http::post('http://localhost:3000/insert_estado', [
            'estado' => $request->get('estado')
        ]);

        // Recuperar la lista de estados actualizada con una solicitud GET
        $resGetEstado = Http::get('http://localhost:3000/estados');

        // Pasar la lista de estados a la vista
        return view('modulo_mantenimiento.Estado')->with('Estados', json_decode($resGetEstado, true));
    }

    public function update(Request $request)
    {
        // Verificar si el usuario tiene permiso para actualizar
        $permiso_actualizacion = session('permiso_actualizacion');
        if ($permiso_actualizacion != 1) {
            return redirect()->back()->with('error', 'No tiene permiso para actualizar estados.');
        }

        // Realizar la actualización en la API
        $response = Http::put('http://localhost:3000/update_estado', [
            'id_estado' => $request->get('cod'),
            'estado' => $request->get('estado'),
        ]);

        // Recuperar la lista de estados actualizada
        $http_Estado = Http::get('http://localhost:3000/estados');
        $TBL_Estado = json_decode($http_Estado, true);

        return view('modulo_mantenimiento.Estado')->with("Estados", $TBL_Estado);
    }

    public function delete($id)
    {
        // Verificar si el usuario tiene permiso para eliminar
        $permiso_eliminacion = session('permiso_eliminacion');
        if ($permiso_eliminacion != 1) {
            return redirect()->back()->with('error', 'No tiene permiso para eliminar estados.');
        }

        // Realizar la eliminación en la API
        $response = Http::delete("http://localhost:3000/delete_estado/{$id}");

        // Recuperar la lista de estados actualizada
        $http_Estado = Http::get('http://localhost:3000/estados');
        $TBL_Estado = json_decode($http_Estado, true);

        return view('modulo_mantenimiento.Estado')->with("Estados", $TBL_Estado);
    }
}
