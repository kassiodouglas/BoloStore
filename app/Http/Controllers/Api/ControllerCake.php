<?php

namespace App\Http\Controllers\Api;

use PDOException;
use App\Models\ModelCake;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ControllerCake extends Controller
{

    /**
     * Exibe uma coleção do recurso
     *
     * @return void
     */
    public function index(){

        try{
            $response = ModelCake::get();
        }catch(PDOException $e){
            $response =  ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }

        if(is_array($response))
            return response()->json(['message'=>$response['message']]);

        if(count($response)==0)
            return response()->json(['message'=>"Nenhum bolo encontrado"]);

        return response()->json($response);
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
            $response =  ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }

        if(is_array($response))
            return response()->json(['message'=>$response['message']]);

        if(count($response)==0)
            return response()->json(['message'=>"Nenhum bolo encontrado para '$name'"]);

        return response()->json($response);
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
            $response =  ['code'=>$e->getCode(),'message'=>$e->getMessage()];
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
            return response()->json(['message'=>$message]);
        }


      return response()->json(['message'=>'Bolo cadastrado com sucesso']);
    }


    /**
     * Atualiza a informação no banco
     *
     * @param Request $request
     * @param string $cake
     * @return void
     */
    public function update(Request $request, string $name){

        if($request->weight == '' || $request->value == '' || $request->quantity == ''){
            return response()->json(['message'=>"Falta informações obrigatórias (peso, valor e quantidade)"]);
        }

        $values = [
            'weight'=>$request->weight,
            'value'=>$request->value,
            'quantity'=>$request->quantity,
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
            return response()->json(['message'=>$message]);
        }

        return response()->json(['message'=>"Bolo '$name' atualizado com sucesso"]);
    }


    /**
     * Remove uma informação do banco
     *
     * @param string $name
     * @return void
     */
    public function destroy(string $name){
        try{
            $response =  ModelCake::where('name',$name)->delete();
        }catch(PDOException $e){
            $response =  ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }

        if(is_array($response)){
            switch($response['code']){
                case 404:
                    $message = "Bolo '{$name}' não encontrado";
                break;

                case 23000:
                    $message = "Bolo '$name' não pode ser deletado pois há interesse nele";
                break;

                default:
                    $message = $response['message'];
                break;
            }
            return response()->json(['message'=>$message]);
        }

        return response()->json(['message'=>"Bolo '$name' removido com sucesso"]);
    }

}
