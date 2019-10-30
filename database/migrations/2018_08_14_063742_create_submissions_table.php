<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('survey_id');
            $table->string('church_id');
            $table->integer('total_time')->nullable();
            $table->text('href')->nullable();
            $table->text('analyze_url')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('response_status')->nullable();
            $table->string('language')->nullable();
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
        Schema::dropIfExists('submissions');
    }
}
