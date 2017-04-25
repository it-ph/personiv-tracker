<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('account_id')->unsigned()->nullable();
            $table->boolean('revision')->default(false);
            $table->integer('number_of_photos')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamp('ended_at')->nullable();
            $table->float('minutes_spent')->unsigned()->nullable();
            $table->float('minutes_idle')->unsigned()->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
