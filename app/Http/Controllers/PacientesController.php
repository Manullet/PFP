<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PacientesController extends Controller
{
    public function index()
    {
        // Consultar datos desde la API
        $response = Http::get('http://localhost:3000/get_pacientes');
        $tabla_estado = Http::get('http://localhost:3000/estados');
        $tabla_rol = Http::get('http://localhost:3000/get_usuarios');

        // Manejo de sesión y permisos
        $usuario = session('usuario'); // Obtener usuario desde la sesión

        // Permisos predeterminados
        $permiso_insercion = 2;
        $permiso_actualizacion = 2;
        $permiso_eliminacion = 2;

        if ($usuario) {
            $idRolUsuario = $usuario['id_rol']; // Obtener el rol del usuario desde la sesión

            // Consultar permisos en la base de datos para el rol y objeto 6 (pacientes)
            $permisos = DB::table('pfp_schema.tbl_permiso')
                ->where('id_rol', $idRolUsuario)
                ->where('id_objeto', 15) // ID del objeto que corresponde a "pacientes"
                ->first();

            // Si se encuentran permisos para este rol y objeto, asignarlos
            if ($permisos) {
                $permiso_insercion = $permisos->permiso_creacion;
                $permiso_actualizacion = $permisos->permiso_actualizacion;
                $permiso_eliminacion = $permisos->permiso_eliminacion;
            }
        }

        // Retornar vista con datos y permisos
        return view('modulo_operaciones.Pacientes')->with([
            'tblusuario' => json_decode($tabla_rol, true),
            'tblestado' => json_decode($tabla_estado, true),
            'Pacientes' => json_decode($response, true),
            'permiso_insercion' => $permiso_insercion,
            'permiso_actualizacion' => $permiso_actualizacion,
            'permiso_eliminacion' => $permiso_eliminacion,
        ]);
    }

    public function store(Request $request)
    {
        $response = Http::post('http://localhost:3000/insert_paciente', [
            'dni_paciente' => $request->get('dni'),
            'nombre_paciente' => $request->get('nombre'),
            'apellido_paciente' => $request->get('apellido'),
            'fecha_nacimiento' => $request->get('nacimiento'),
            'email' => $request->get('email'),
            'direccion' => $request->get('direccion'),
            'celular' => $request->get('celular'),
            'tratamiento_medico' => $request->get('tratamiento'),
            'id_usuario' => $request->get('usuario'),
            'id_estado' => $request->get('estdo'),
            'genero' => $request->get('genero'),
        ]);

        return redirect('Pacientes');
    }

    public function update(Request $request)
    {
        $response = Http::put('http://localhost:3000/update_paciente', [
            'id_paciente' => $request->get('cod'),
            'dni_paciente' => $request->get('dni'),
            'nombre_paciente' => $request->get('nombre'),
            'apellido_paciente' => $request->get('apellido'),
            'fecha_nacimiento' => $request->get('nacimiento'),
            'email' => $request->get('email'),
            'direccion' => $request->get('direccion'),
            'celular' => $request->get('celular'),
            'tratamiento_medico' => $request->get('tratamiento'),
            'id_usuario' => $request->get('usuario'),
            'id_estado' => $request->get('estdo'),
            'genero' => $request->get('genero'),
        ]);

        return redirect('Pacientes');
    }
}
