<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id('Issue_Id');
            $table->string('Name');
            $table->mediumText('Description');
            $table->string('Email')->nullable();
            $table->string('Priority');
            $table->string('Picture')->nullable();
            $table->integer('Project_Id');
            $table->integer('Employee_Id')->nullable();
            $table->integer('Issuer_Id')->nullable();
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
        Schema::dropIfExists('issues');
    }
}
