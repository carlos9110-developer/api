<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\JWT\SignatureInvalidException;
use Firebase\JWT\JWT\UnexpectedValueException;
use Firebase\JWT\JWT\DomainException;
use Illuminate\Support\Facades\DB;
use App\User;


class JwtAuth{

    private $secret         = "sjshshshahashha";
    private $algoritmoCod   =  "HS256";

    public function  login($user,$pass){
        $usuario = User::where(array(
            'email'   => $user,
            'password'=> $pass 
        ))->first();

        if(is_object($usuario)){
            $payload = array(
                'sub'    => $usuario->id,
                'nombre' => $usuario->name,
                'usr'    => $usuario->email,
                'iat'    => time(),
                'exp'    => time() + (7*24*60*60)
            );
            $jwt = JWT::encode($payload,$this->secret,$this->algoritmoCod);
            $respuesta = array(
                'success' => true,
                'token'   => $jwt
            );
            return $respuesta;
        } else {
            return array(
                'success' => false,
                'msg'     => "Usuario o contraseña incorrectos"
            );
        }
    } // aca temrina el login

    public function verificarToken($token, $decodificados = false){
        $auth       = false;
        $payload    = null;

        try{
            $payload = JWT::decode($token,$this->secret,array($this->algoritmoCod));
            $auth       = true;
        }catch (SignatureInvalidException $ex){ // este case es cuando pasan un token con una firma invalida
            $auth = false;
        }catch (\UnexpectedValueException $ex){
            $auth = false;
        }  catch (\DomainException $ex){
            $auth = false;
        }
        catch (Exception $ex){
            $auth = false;
        }
        

        if($decodificados == true){
            return $payload;
        } else {
            return $auth;
        }
    }


}