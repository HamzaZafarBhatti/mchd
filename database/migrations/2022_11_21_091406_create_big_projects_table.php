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
        Schema::create('big_projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('boss_id')->unsigned();
            $table->tinyText("name");
            $table->text("description");
            $table->date('start_date');
            $table->date('end_date')->nullable(true)->change();
            $table->string('status', 30);
            $table->tinyInteger('department_code');
            $table->timestamps();
            $table->foreign('boss_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('big_projects');
    }
};
