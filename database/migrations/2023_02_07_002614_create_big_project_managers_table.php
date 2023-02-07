<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('big_project_managers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('big_project_id')->unsigned();
            $table->bigInteger('manager_id')->unsigned();
            $table->foreign('big_project_id')->references('id')->on('big_projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('big_project_managers');
    }
};
