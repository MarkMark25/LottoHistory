<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSixFourninesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('six_fournines', function (Blueprint $table) {
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
            $table->integer('winning_number_bonus');
            $table->boolean('ball_color');//1=Gold and 0=White
            $table->string('gold_ball_win_num');
            $table->enum('gb_province_winner',['NL','PE','NS','NB','QC','ON','MB','SK','AB','BC','YT','NT','NU']);
            $table->integer('extra');
            $table->boolean('soft_Delete')->default(1);
            $table->timestamps();
        });

        // 'NL' Newfoundland and Labrador
        // 'PE' Prince Edward Island
        // 'NS' Nova Scotia
        // 'NB' New Brunswick
        // 'QC' Quebec
        // 'ON' Ontario
        // 'MB' Manitoba
        // 'SK' Saskatchewan
        // 'AB' Alberta
        // 'BC' British Columbia
        // 'YT' Yukon Territory
        // 'NT' Northwest Territories
        // 'NU' Nunavut
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('six_fournines');
    }
}
