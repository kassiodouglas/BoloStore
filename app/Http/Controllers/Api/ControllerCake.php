<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ModelCake;

class ControllerCake extends Controller
{

    /**
     * Exibe uma coleção do recurso
     *
     * @return void
     */
    public function index(){
        $response = (new ModelCake())->cakes();

        if(is_array($response))
            return $this->getError($response);

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
        $response = (new ModelCake())->cake_show($name);

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
        $response =  (new ModelCake())->cake_store($request->all());

        if(is_array($response))
            return $this->getError($response, 23000, "Bolo '{$request->name}' já cadastrado");

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
        $response = (new ModelCake())->cake_update($values, $name);

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
        $response =  (new ModelCake())->cake_delete($name);

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
