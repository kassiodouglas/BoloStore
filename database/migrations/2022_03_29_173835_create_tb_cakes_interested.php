<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCakesInterested extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cakes_interested', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->bigInteger('id_cake')->unsigned();
            $table->bigInteger('id_email')->unsigned();

            $table->foreign('id_cake')->references('id')->on('tb_cakes');
            $table->foreign('id_email')->references('id')->on('tb_emails');
            $table->unique(['id_cake','id_email']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cakes_interested');
    }
}
