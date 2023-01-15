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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('big_project_id')->unsigned();
            $table->bigInteger('leader_id')->unsigned();
            $table->string('leader_name', 30)->unsigned();
            $table->tinyText("name");
            $table->text('definition_aims');
            $table->date('start_date');
            $table->date('end_date')->nullable(true)->change();
            $table->string('status', 30);
            $table->tinyText('assignee');
            $table->tinyText('assignee_names');
            $table->timestamps();
            $table->foreign('leader_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
};
