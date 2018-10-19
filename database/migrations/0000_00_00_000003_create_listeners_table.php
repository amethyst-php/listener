<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateListenersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(Config::get('amethyst.listener.data.listener.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('condition')->default('1');
            $table->text('description')->nullable();
            $table->text('event_class');
            $table->integer('work_id')->unsigned()->nullable();
            $table->foreign('work_id')->references('id')->on(Config::get('amethyst.work.data.work.table'));
            $table->boolean('enabled')->default(true);
            $table->text('data');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('amethyst.listener.data.listener.table'));
    }
}
