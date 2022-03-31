<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Models\ModelInterested;
use App\Models\ModelVWInterested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ControllerEmails extends Controller
{


    /**
     * Envia os emails para a fila
     */
    public function send(){

        $list_interested = ModelVWInterested::get();

        $emails = $this->filter($list_interested);

        foreach($emails as $email=>$cakes){
            SendMail::dispatch(['email'=>$email,'cakes'=>$cakes])->delay(now()->addSeconds('5'));
        }

        return response()->json(['message'=>'Emails adicionados a fila para envio']);
    }



    /**
     * Filtra os bolos deixando somente os que estão disponiveis
     * Retorna os emails com uma lista dos bolos interessados
     *
     * @param array $list_interested
     * @return array
     */
    public function filter(array $list_interested){

        #retirando bolos com quantidade zero
        foreach($list_interested as $index=>$item){
            if($item->quantity == 0){
                unset($list_interested[$index]);
            }
        }

        #agrupando os bolos por email
        $emails = [];
        foreach($list_interested as $index=>$item){

            if( !array_key_exists($item->email, $emails) ){
                $emails[$item->email] = $item->name;
            }else{
                $emails[$item->email] .= ", ".$item->name;
            }
        }

        return $emails;
    }

}
