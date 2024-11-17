<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CambiarContrasenaController extends Controller
{
    public function index()
    {
        return view('modulo_usuarios.CambiarContrasena');
    }

    public function store(Request $request)
    {
        // Obtener el usuario autenticado en mayúsculas
        $usuario = strtoupper(auth()->user()->usuario);
        $contrasenaActual = $request->input('contrasena_actual');
        $nuevaContrasena = $request->input('nueva_contrasena');
        $confirmarContrasena = $request->input('confirmar_contrasena');

        // Validaciones de las contraseñas
        $request->validate([
            'contrasena_actual' => 'required',
            'nueva_contrasena' => 'required|min:8|max:20|different:contrasena_actual',
            'confirmar_contrasena' => 'required|same:nueva_contrasena',
        ]);

        // Buscar el usuario en la base de datos
        $user = DB::table('pfp_schema.tbl_usuario')
                    ->where('usuario', $usuario)
                    ->first();

        // Verificar que el usuario exista y la contraseña actual sea correcta
        if (!$user || !Hash::check($contrasenaActual, $user->contrasena)) {
            return redirect()->back()->withErrors(['contrasena_actual' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar la nueva contraseña en la base de datos
        DB::table('pfp_schema.tbl_usuario')
            ->where('id_usuario', $user->id_usuario)
            ->update([
                'contrasena' => Hash::make($nuevaContrasena),
                'updated_at' => now()
            ]);

        // Redirigir a la vista de AdministrarPerfil
        return redirect()->route('AdministrarPerfil')->with('success', 'Contraseña actualizada exitosamente.');
    }
}
