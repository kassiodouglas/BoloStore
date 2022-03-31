<?php

namespace App\Http\Controllers\Api;

use PDOException;
use Illuminate\Http\Request;
use App\Models\ModelInterested;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ModelCake;
use App\Models\ModelEmail;
use App\Models\ModelVWInterested;

class ControllerInterested extends Controller
{

    /**
     * Exibe uma coleção do recurso
     *
     * @return void
     */
    public function index(){

        try{
            $response = ModelVWInterested::get();
        }catch(PDOException $e){
            $response =  ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }

        if(is_array($response))
            return response()->json(['message'=>$response['message']]);

        if(count($response)==0)
            return response()->json(['message'=>"Nenhum interesse encontrado"]);

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
            $response = ModelVWInterested::where('name',$name)->get();
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
            $response = DB::transaction(function () use($request) {

                $id_cake = ModelCake::select('id')->where('name',$request->name)->first();
                if($id_cake === null)
                    return ['code'=>404,'message'=>'Bolo não encontrado'];
                $id_cake = $id_cake->id;


                $id_email = ModelEmail::select('id')->where('email',$request->email)->first();
                if($id_email === null){
                    $id_email = ModelEmail::insertGetId(['email'=>$request->email]);
                }else{
                    $id_email = $id_email->id;
                }

                $response = ModelInterested::insert(['id_cake'=>$id_cake,'id_email'=>$id_email,]);

                return $response;
            });

        }catch(PDOException $e){
            $response = ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }

        if(is_array($response)){
            switch($response['code']){
                case 404:
                    $message = 'Bolo não encontrado';
                break;

                case 23000:
                    $message = "Já existe o interesse ao bolo '$request->name' pelo email '$request->email'";
                break;

                default:
                    $message = 'Erro desconhecido';
                break;
            }
            return response()->json(['message'=>$message]);
        }

        return response()->json(['message'=>'Interesse cadastrado com sucesso']);
    }


    /**
     * Remove uma informação do banco
     *
     * @param string $name
     * @return void
     */
    public function destroy(string $name, string $email){

        try{
            $response = ModelInterested::where('name',$name)->where('email',$email)->delete();
        }catch(PDOException $e){
            $response =  ['code'=>$e->getCode(),'message'=>$e->getMessage()];
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

        return response()->json(['message'=>'Interesse removido com sucesso']);

    }

}
