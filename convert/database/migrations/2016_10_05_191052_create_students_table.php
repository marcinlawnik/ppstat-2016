<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imie');
            $table->string('drugie_imie');
            $table->string('nazwisko');
            $table->string('imie_ojca');
            $table->float('liczba_punktow');
            $table->boolean('jedna_gwiazdka');
            $table->boolean('dwie_gwiazdki');
//            $table->string('wydzial_short');
//            $table->string('kierunek_short');
            $table->integer('kierunek_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('students');
    }
}
