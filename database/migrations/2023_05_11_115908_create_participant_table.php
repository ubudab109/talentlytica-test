<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->index();
            $table->string('email')->index();
            $table->integer('x')->default(1)->comment('range 1 - 33 ');
            $table->integer('y')->default(1)->comment('range 1 - 23');
            $table->integer('z')->default(1)->comment('range 1 - 18');
            $table->integer('w')->default(1)->comment('range 1 - 13');
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
        Schema::dropIfExists('participant');
    }
}
