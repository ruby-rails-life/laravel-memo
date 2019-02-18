<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_clovers', function (Blueprint $table) {
            $table->string('clover_name')->primary();
            $table->boolean('active');
            $table->string('symbol')->nullable();
            $table->dateTime('create_time');
            $table->dateTime('update_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_clovers');
    }
}
