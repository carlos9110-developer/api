<?php
namespace App\Http\Controllers;
use App\Compra;
use App\Tarjeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompraController extends Controller
{

    public function store(Request $request)
    {
        if( DB::table('tarjetas')->where('numero_tarjeta',$request->numero_tarjeta)->where('clave',$request->clave)->count() > 0 ){
            $info_tarjeta   =  DB::table('tarjetas')->where('numero_tarjeta',$request->numero_tarjeta)->where('clave',$request->clave)->get();
            $saldo_tarjeta  =  $info_tarjeta[0]->saldo;
            if( $saldo_tarjeta >= $request->total_compra ){


                $saldo_nuevo   = $saldo_tarjeta - $request->total_compra;
                if($saldo_nuevo >= 50000){
                     DB::update('update tarjetas set saldo = ? where numero_tarjeta = ?',[$saldo_nuevo,$request->numero_tarjeta]);

                    $compras = new Compra;
                    $compras->numero_factura = rand (10000,999999.);
                    $compras->fecha          = date('Y-m-d');
                    $compras->articulos      = $request->articulos;
                    $compras->total_compra   = $request->total_compra;
                    $compras->id_tarjeta     = $info_tarjeta[0]->id;
                    $compras->save();   
                    $response = array(
                    'success' => false,
                    'msg'     => 'La compra se ha registrado correctamente'
                    );
                }else{
                   $response = array(
                    'success' => false,
                    'msg'     => 'Error, debe mantener un saldo de $50.000 '
                    ); 
                }

               
                return new JsonResponse($response);
            }else{
                $response = array(
                'success' => false,
                'msg'     => 'La tarjeta no tiene fondos suficientes para la compra, intente con otra tarjeta asalariado'
                );
                return new JsonResponse($response);
            }
        }else{
            $response = array(
            'success' => false,
            'msg'     => 'El número de tarjeta o la clave son incorrectos'
            );
            return new JsonResponse($response);
        }
    }

    //func

    // función donde se retorna una sola tarjeta
    public function traerCompra($numero_factura){
        $compra = DB::table('compras')->where('numero_factura',$numero_factura)->get();
        return new JsonResponse($compra);
    }

    // función donde se traen todas las compras
    public function show(Compra $compra)
    {
        $compra =  Compra::all();
        return new JsonResponse($compra);
    }
    
}
