<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        //validar los datos
        $credentials = $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'confirm_password'=>'required|same:password',
        ]);

        //encrypt password
        $credentials['password'] = Hash::make($credentials['password']);

        //crear usuario nuevo
        $usuario = User::create($credentials);

        //generar el token
        $token = $usuario->createToken('TokenUsuario')->plainTextToken;

        //devolver una respuesta
        $respuesta = [
            'data'=>[
                'usuario'=>$usuario,
                'token'=>$token,
            ],
        ];

        return response()->json($respuesta);
    }
}
