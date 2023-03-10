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
        Schema::create('big_attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('big_id')->unsigned();
            $table->string('path_name', 150);
            $table->string('real_name', 200);
            $table->float('real_size');
            $table->foreign('big_id')->references('id')->on('big_projects')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('big_attachments');
    }
};
