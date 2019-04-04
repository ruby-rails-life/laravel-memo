<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name',100);
            $table->unsignedInteger('sales_staff_id');
            $table->date('order_date')->nullable();
            $table->date('estimated_delivery_date')->nullable();
            $table->unsignedInteger('developer_in_charge_id')->nullable();
            $table->string('project_status',2)->nullable();
            $table->tinyInteger('development_progress')->nullable();

            $table->foreign('sales_staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('developer_in_charge_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('projects');
    }
}
