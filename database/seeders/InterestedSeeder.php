<?php

namespace Database\Seeders;

use App\Models\ModelCake;
use App\Models\ModelEmail;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\ModelInterested;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regs = 50000;

        for($x=0; $x<$regs; $x++){

            $email = Str::random(10).'@gmail.com';
            $name = Arr::random(['Cenoura','Chocolate','Morango','Cenoura com chocolate','Prestigio'], 1);

            $id_cake = ModelCake::select('id')->where('name',$name)->first();
            $id_email = ModelEmail::insertGetId(['email'=>$email]);

            ModelInterested::insert(['id_cake'=>$id_cake->id,'id_email'=>$id_email]);
        }
    }
}
