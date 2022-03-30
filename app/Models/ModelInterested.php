<?php

namespace App\Models;

use PDOException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelInterested extends Model
{
    use HasFactory;

    /**
     * Retorna uma listagem de registros cadastrados
     *
     * @return array
     */
    public function interested($sendemail = false){
        try{
            return DB::table('vw_interested')->select('*')->get();
        }catch(PDOException $e){
            return ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }

    /**
     * Retorna um registro cadastrado
     *
     * @param [string] $name
     * @return array|object
     */
    public function interested_show(string $name){
        try{
            return DB::table('vw_interested')->select('*')->where('name',$name)->get();
        }catch(PDOException $e){
            return ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }


    /**
     * Grava um registro no banco de dados
     *
     * @param [string] $email
     * @param [string] $name
     * @return void
     */
    public function interested_store($email, $name){
        try{
            return DB::transaction(function () use($email, $name) {

                $id_cake = DB::table('tb_cakes')->select('id')->where('name',$name)->first();
                if($id_cake === null)
                    return ['code'=>404,'message'=>'Bolo não encontrado'];
                $id_cake = $id_cake->id;



                $id_email = DB::table('tb_emails')->select('id')->where('email',$email)->first();
                if($id_email === null){
                    $id_email = DB::table('tb_emails')->insertGetId(['email'=>$email]);
                }else{
                    $id_email = $id_email->id;
                }


                $response = DB::table('tb_cakes_interested')->insert([
                    'id_cake'=>$id_cake,
                    'id_email'=>$id_email,
                ]);

                return $response;
            });

        }catch(PDOException $e){
            return ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }


    /**
     * Remove um registro do banco de dados
     *
     * @param string $name
     * @param string $email
     * @return bool|array
     */
    public function interested_delete(string $name, string $email){
        try{
            return DB::transaction(function () use($name, $email) {

                $id_cake = DB::table('tb_cakes')->select('id')->where('name',$name)->first();
                $id_email = DB::table('tb_emails')->select('id')->where('email',$email)->first();

                if($id_cake == null || $id_email == null)
                    return ['code'=>404,'message'=>'Bolo e/ou email não encontrado'];

                $id_interested = DB::table('tb_cakes_interested')->select('id')
                                ->where('id_cake',$id_cake->id)
                                ->where('id_email',$id_email->id)
                                ->first();
                if($id_interested == null)
                    return ['code'=>404,'message'=>'Interesse não encontrado'];

                return DB::table('tb_cakes_interested')
                    ->where('id_cake',$id_cake->id)
                    ->where('id_email',$id_email->id)
                    ->delete();

            });
        }catch(PDOException $e){
            return ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }

}
