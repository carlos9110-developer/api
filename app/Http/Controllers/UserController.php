<?php

namespace App\Http\Controllers;
use App\Helpers\JwtAuth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request){

        $jwt = new JwtAuth();
        return $jwt->login($request->email,$request->clave);
    }
}
