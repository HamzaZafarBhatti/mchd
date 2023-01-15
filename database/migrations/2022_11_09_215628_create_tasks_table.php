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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id')->unsigned();
            $table->bigInteger('leader_id')->unsigned();
            $table->tinyText('name');
            $table->text('note');
            $table->string('status', 30);
            $table->tinyInteger('priority')->nullable(true)->change();

            $table->date('start_date');
            $table->date('end_date')->nullable(true)->change();
            $table->string('assignee', 200);
            $table->string('assignee_names', 250);
            $table->tinyText('project_name');
            $table->string('leader_name', 50);

            $table->timestamps();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tasks');
    }
};
