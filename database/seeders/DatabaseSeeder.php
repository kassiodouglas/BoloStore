<?php

namespace Database\Seeders;

use App\Models\ModelUser;
use Database\Factories\InterestedFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CakeSeeder::class,
            InterestedSeeder::class,
        ]);

    }

}
