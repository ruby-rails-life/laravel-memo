<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloverRelationMtmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clover_relation_mtm', function (Blueprint $table) {
            $table->string('clover_name');
            $table->unsignedInteger('relation_mtm_id');
            $table->primary(['clover_name','relation_mtm_id']);

            // 外部キー制約
            $table->foreign('clover_name')->references('clover_name')->on('my_clovers')->onDelete('cascade');
            $table->foreign('relation_mtm_id')->references('id')->on('relation_mtms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clover_relation_mtm');
    }
}
