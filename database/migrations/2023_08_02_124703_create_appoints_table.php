<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appoints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('service')->nullable();
            $table->string('more_info')->nullable();
            $table->timestamps('created_at');
            $table->timestamps('updated_at');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appoints');
    }
}
