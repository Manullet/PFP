<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrarPerfilController extends Controller
{
    public function index()
    {
        return view('modulo_usuarios.AdministrarPerfil');
        
    }

    
    //public function updateImagen(Request $request)
    //{
        // Lógica para actualizar la imagen de perfil
        // Ejemplo: Guardar la imagen en storage y actualizar el campo en la base de datos
    //}

    public function CambiarContrasena()
    {
        return view('CambiarContrasena');  // Muestra la página para cambiar la contraseña
    }
}
