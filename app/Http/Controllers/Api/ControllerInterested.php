<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelInterested;
use Illuminate\Http\Request;

class ControllerInterested extends Controller
{

    /**
     * Exibe uma coleção do recurso
     *
     * @return void
     */
    public function index(){
        $response = (new ModelInterested())->interested();

        if(is_array($response))
            return $this->getError($response);

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
        $response = (new ModelInterested())->interested_show($name);

        if(is_array($response))
            return $this->getError($response);

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
        $response = (new ModelInterested())->interested_store($request->email, $request->name);

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
        $response = (new ModelInterested())->interested_delete($name, $email);

        if(is_array($response)){
            return response()->json(['message'=>$response['message']]);
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
