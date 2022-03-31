<?php

namespace App\Http\Controllers\Api;

use Exception;
use TypeError;
use PDOException;
use App\Models\ModelCake;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ControllerCake extends Controller
{

    /**
     * Exibe uma coleção do recurso
     *
     * @return json
     */
    public function index(){

        try{
            $response = ModelCake::get();
        }catch(PDOException $e){
            return response()->json(['message'=>$e->getMessage()], $e->getCode());
        }

        if(count($response)==0)
            return response()->json(['message'=>"Nenhum bolo encontrado", "status"=>200]);

        return response()->json($response,200);
    }


    /**
     * Exibe um item especifico
     *
     * @param string $name
     * @return void
     */
    public function show(string $name){

        try{
            $response = ModelCake::where('name',$name)->get();
        }catch(PDOException $e){
            return response()->json(['message'=>$e->getMessage()], $e->getCode());
        }

        if(count($response)==0)
            return response()->json(['message'=>"Nenhum bolo encontrado para '$name'"],200);

        return response()->json($response,200);
    }


    /**
     * Grava a informação no banco
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request){

        try{
            $response = ModelCake::insert($request->all());
        }catch(PDOException $e){
            $response = ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }

        if(is_array($response)){
            switch($response['code']){
                case 23000:
                    $message = "Bolo '{$request->name}' já cadastrado";
                break;

                default:
                    $message = $response['message'];
                break;
            }
            return response()->json(['message'=>$message],200);
        }


      return response()->json(['message'=>'Bolo cadastrado com sucesso'],200);
    }


    /**
     * Atualiza a informação no banco
     *
     * @param Request $request
     * @param string $cake
     * @return void
     */
    public function update(Request $request, string $name){

        $validator = Validator::make($request->all(), ['weight' => 'required','value' => 'required','quantity'=> 'required']);
        if($validator->fails())
            return response()->json(['message'=>"Falta informações obrigatórias (peso, valor e quantidade)"],200);

        $values = [
            'weight'=>$request->weight, 'value'=>$request->value, 'quantity'=>$request->quantity,
        ];

        try{
            $response = ModelCake::where('name',$name)->update($values);
        }catch(PDOException $e){
            $response = ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }

        if(is_array($response)){
            switch($response['code']){
                case 404:
                    $message = "Bolo '{$name}' não encontrado";
                break;

                default:
                    $message = $response['message'];
                break;
            }
            return response()->json(['message'=>$message],200);
        }

        return response()->json(['message'=>"Bolo '$name' atualizado com sucesso"],200);
    }


    /**
     * Remove uma informação do banco
     *
     * @param string $name
     * @return void
     */
    public function destroy(string $name){
        try{

            $cake = ModelCake::where('name',$name)->first();
            if(!$cake)
                return response()->json(['message'=>"Bolo '{$name}' não existe"],200);

            $response = ModelCake::where('name',$name)->delete();
        }catch(PDOException $e){
            $response = ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }

        if(is_array($response)){
            switch($response['code']){
                case 23000:
                    $message = "Bolo '$name' não pode ser deletado pois há interesse nele";
                break;

                default:
                    $message = $response['message'];
                break;
            }
            return response()->json(['message'=>$message],200);
        }

        return response()->json(['message'=>"Bolo '$name' removido com sucesso"],200);
    }

}
