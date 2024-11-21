<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class LoginController extends Controller
{
    // Mostrar el formulario de login
    public function showLoginForm()
    {
        return view('layouts.Login');
    }

    // Manejar el proceso de login interno
    public function login(LoginRequest $request)
    {
        // Buscar al usuario por nombre de usuario
        $usuario = User::where('nombre_usuario', $request->nombre_usuario)->first();

        // Verificar si el usuario existe y la contraseña es correcta (sin encriptación)
        if ($usuario && $request->contrasena === $usuario->contrasena) {
            // Iniciar sesión en el sistema
            Auth::login($usuario);

            // Guardar datos relevantes del usuario en la sesión
            session(['usuario' => [
                'id' => $usuario->id,
                'nombre_usuario' => $usuario->nombre_usuario,
                'id_rol' => $usuario->id_rol,
            ]]);

            return redirect()->intended('/inicio');
        } else {
            // Fallo en la autenticación
            return back()->withErrors([
                'login' => 'Usuario o contraseña incorrectos. Favor intente nuevamente.',
            ]);
        }
    }

    // Manejar el proceso de login con verificación mediante API externa
    public function verificar_Login(Request $request)
    {
        // Obtener los usuarios desde el endpoint
        $response = Http::get('http://localhost:3000/get_usuarios');
        $usuarios = json_decode($response->body(), true);

        // Recibir los datos del formulario
        $email = $request->input('correo');
        $contrasena = $request->input('contra');

        // Buscar el usuario autenticado
        $usuarioAutenticado = collect($usuarios)->first(function ($usuario) use ($email, $contrasena) {
            return $usuario['email'] == $email && $usuario['contrasena'] == $contrasena && $usuario['estado'] === 'ACTIVO';
        });

        if ($usuarioAutenticado) {
            // Guardar datos relevantes del usuario en la sesión
            session(['usuario' => [
                'id_usuario' => $usuarioAutenticado['id_usuario'],
                'nombre_usuario' => $usuarioAutenticado['nombre_usuario'],
                'email' => $usuarioAutenticado['email'],
                'id_rol' => $usuarioAutenticado['id_rol'],
            ]]);

            return redirect('inicio');
        } else {
            // Mostrar mensaje de error
            $mensaje = $usuarioAutenticado && $usuarioAutenticado['estado'] !== 'ACTIVO'
                ? 'Su cuenta está inactiva, comuníquese con el administrador'
                : 'Acceso incorrecto, intente nuevamente';

            return view('layouts.Login')->with('mensaje', $mensaje);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        // Cerrar la sesión de autenticación
        Auth::logout();
        
        // Limpiar la sesión para eliminar cualquier dato adicional
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir a la página de login
        return redirect()->route('login');
    }
}
