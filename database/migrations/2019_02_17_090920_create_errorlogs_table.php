<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('module');
            $table->string('action');
            $table->text('url');
            $table->text('content');
            $table->text('error');
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
        Schema::dropIfExists('error_logs');
    }
}
