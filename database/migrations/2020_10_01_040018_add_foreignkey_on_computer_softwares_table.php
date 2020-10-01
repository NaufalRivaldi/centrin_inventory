<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyOnComputerSoftwaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('computer_softwares', function(Blueprint $table){
            $table->foreign('computer_id')->references('id')->on('computers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('software_id')->references('id')->on('softwares')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
