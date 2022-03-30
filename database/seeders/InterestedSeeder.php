<?php

namespace Database\Seeders;

use App\Models\ModelCake;
use App\Models\ModelInterested;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        $regs = 100;

        for($x=0; $x<=$regs; $x++){

            $email = Str::random(10).'@gmail.com';
            $name = Arr::random(['Chocolate','Cenoura','Morango'], 1);

            (new ModelInterested())->interested_store( $email, $name);
        }
    }
}
