<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ControllerCake;
use App\Http\Controllers\Api\ControllerEmails;
use App\Http\Controllers\Api\ControllerInterested;

route::prefix('cake')->group(function(){

    route::get('/',[ControllerCake::class,'index']);
    route::get('show/{name}',[ControllerCake::class,'show']);

    route::put('store',[ControllerCake::class,'store']);

    route::post('update/{name}',[ControllerCake::class,'update']);

    route::delete('destroy/{name}',[ControllerCake::class,'destroy']);

});


route::prefix('interested')->group(function(){

    route::get('/',[ControllerInterested::class,'index']);
    route::get('show/{name}',[ControllerInterested::class,'show']);

    route::put('store',[ControllerInterested::class,'store']);

    route::delete('destroy/{name}/{email}',[ControllerInterested::class,'destroy']);

    route::prefix('mail')->group(function(){
        route::get('/send',[ControllerEmails::class,'send']);
    });

});


