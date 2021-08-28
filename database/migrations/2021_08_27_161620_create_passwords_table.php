<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passwords', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password')->comment('Encrypted by the system-self-defined algorithm');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('type_id');
            $table->timestamps();

            $table->unique(['username', 'type_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('password_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passwords');
    }
}
