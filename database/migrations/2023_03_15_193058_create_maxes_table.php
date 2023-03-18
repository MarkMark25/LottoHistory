<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_string')->unique();
            $table->boolean('super_admin')->default(1);
            $table->boolean('admin')->default(1);
            $table->boolean('users')->default(1);
            $table->date('draw_date');
            $table->integer('winning_number_1');
            $table->integer('winning_number_2');
            $table->integer('winning_number_3');
            $table->integer('winning_number_4');
            $table->integer('winning_number_5');
            $table->integer('winning_number_6');
            $table->integer('winning_number_7');
            $table->integer('winning_number_bonus');
            $table->integer('extra');
            $table->boolean('soft_Delete')->default(1);
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
        Schema::dropIfExists('maxes');
    }
}
