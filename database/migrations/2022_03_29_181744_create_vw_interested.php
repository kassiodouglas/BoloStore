<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVwInterested extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS vw_interested");
        DB::statement("
            CREATE VIEW vw_interested AS
            SELECT
                CAKE.id id_cake,
                CAKE.name,
                EMAIL.id id_email,
                EMAIL.email,
                CAKE.quantity

            FROM tb_cakes_interested CAKINT
            INNER JOIN tb_cakes CAKE ON (CAKINT.id_cake = CAKE.id)
            INNER JOIN tb_emails EMAIL ON (CAKINT.id_email = EMAIL.id)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS vw_interested");
    }
}
