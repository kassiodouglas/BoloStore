<?php

namespace App\Models;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PDOException;

class ModelCake extends Model
{
    use HasFactory;

    /**
     * Retorna uma listagem de registros cadastrados
     *
     * @return array
     */
    public function cakes(){
        try{
            return DB::table('tb_cakes')->select('*')->get();
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
    public function cake_show(string $name){
        try{
            return DB::table('tb_cakes')->select('*')->where('name',$name)->get();
        }catch(PDOException $e){
            return ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }


    /**
     * Grava um registro no banco de dados
     *
     * @param array $values
     * @return void
     */
    public function cake_store(array $values){
        try{
            return DB::table('tb_cakes')->insert($values);
        }catch(PDOException $e){
            return ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }


    /**
     * Atualiza um registro no banco de dados
     *
     * @param array $values
     * @param string $cake
     * @return bool|array
     */
    public function cake_update(array $values, string $name){
        try{
            return DB::transaction(function () use($values,$name) {
                $id_cake = DB::table('tb_cakes')->select('id')->where('name',$name)->first();
                    if($id_cake == null)
                        return ['code'=>404,'message'=>'Bolo não encontrado'];

                return DB::table('tb_cakes')->where('name',$name)->update($values);
            });
        }catch(PDOException $e){
            return ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }


    /**
     * Remove um registro do banco de dados
     *
     * @param string $cake
     * @return bool|array
     */
    public function cake_delete(string $name){
        try{
            return DB::transaction(function () use($name) {

                $id_cake = DB::table('tb_cakes')->select('id')->where('name',$name)->first();
                if($id_cake == null)
                    return ['code'=>404,'message'=>'Bolo não encontrado'];

                return DB::table('tb_cakes')->where('name',$name)->delete();

            });
        }catch(PDOException $e){
            return ['code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }

}
