<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Models\ModelInterested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ControllerEmails extends Controller
{
    public function index(){

        $list_interested = (new ModelInterested())->interested();

        #filtrando bolos com quantidade disponivel
        foreach($list_interested as $index=>$item){
            if($item->quantity == 0){
                unset($list_interested[$index]);
            }
        }

        $emails = [];
        foreach($list_interested as $index=>$item){

            if( !array_key_exists($item->email, $emails) ){
                $emails[$item->email] = $item->name;
            }else{
                $emails[$item->email] .= ", ".$item->name;
            }
        }

        foreach($emails as $email=>$cakes){
            SendMail::dispatch([$email,$cakes])->delay(now()->addSeconds('1'));
        }


        return response()->json(['status'=>'200']);
    }


}
