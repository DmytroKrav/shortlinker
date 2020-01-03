<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shorted_links_id');
            $table->string('datetime');
            $table->string('user_agent');
            $table->string('clicker_ip');
            $table->string('referrer')->nullable();
            $table->smallInteger('is_unique')->default(0);
            $table->string('clicker_city');
            $table->integer('updated_at');
            $table->integer('created_at');

            $table->foreign('shorted_links_id')
                ->references('id')->on('shorted_links')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clicks');
    }
}
