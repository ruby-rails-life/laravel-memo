<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasManiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('has_manies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('clover_name');
            $table->timestamps();
            $table->foreign('clover_name')->references('clover_name')->on('my_clovers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('has_manies');
    }
}
