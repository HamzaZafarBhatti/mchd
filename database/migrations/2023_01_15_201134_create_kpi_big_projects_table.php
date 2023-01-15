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
        Schema::create('kpi_big_projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('boss_id')->unsigned();
            $table->tinyText("name");
            $table->text("description");
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status', 30)->default('notyetstarted');
            $table->tinyInteger('department_code');
            $table->dateTime('status_change_date')->nullable();
            $table->foreign('boss_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('kpi_big_projects');
    }
};
