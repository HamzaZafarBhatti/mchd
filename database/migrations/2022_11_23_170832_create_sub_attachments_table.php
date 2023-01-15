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
        Schema::create('sub_attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sub_id')->unsigned();
            $table->string('path_name', 150);
            $table->string('real_name', 200);
            $table->foreign('sub_id')->references('id')->on('sub_tasks')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('sub_attachments');
    }
};
