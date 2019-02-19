<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloverManyToManyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clover_many_to_many', function (Blueprint $table) {
            $table->string('clover_name');
            $table->unsignedInteger('many_to_many_id');
            $table->primary(['clover_name','many_to_many_id']);

            // 外部キー制約
            $table->foreign('clover_name')->references('clover_name')->on('my_clovers')->onDelete('cascade');
            $table->foreign('many_to_many_id')->references('id')->on('many_to_manies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clover_many_to_many');
    }
}
