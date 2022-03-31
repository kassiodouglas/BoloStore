<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Retorma uma mensagem de erro
     *
     * @param [array] $response
     * @param [int] $code
     * @param [string] $message
     * @return void
     */
    public function getError(array $response, int $code = null, string $message = null){

        if($code !== null && $message !== null)
            return ['message'=>$message];

        if(array_key_exists('message',$response))
            return ['message'=>$response['message']];



        return ['message'=>'Erro desconhecido'];
    }

}
