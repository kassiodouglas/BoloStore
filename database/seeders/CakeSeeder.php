<?php

namespace Database\Seeders;

use App\Models\ModelCake;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $listCakes = ['Cenoura','Chocolate','Morango','Cenoura com chocolate','Prestigio'];
        $regs = count($listCakes);

        for($x=0; $x<$regs; $x++){

            $values = [
                'name' => $listCakes[$x],
                'weight' => rand(0, 1000),
                'value' => rand(0, 100),
                'quantity' => rand(0, 99),
            ];

            (new ModelCake())->cake_store($values);
        }
    }
}
