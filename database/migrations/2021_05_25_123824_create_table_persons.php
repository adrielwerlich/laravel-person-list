<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
                $table->string('name')->nullable()->default('');
                $table->string('lastName')->nullable()->default('');
                $table->string('phone')->nullable()->default('');
                $table->string('email')->nullable()->unique();
                $table->boolean('isJur')->nullable()->default(false);
                $table->string('cpf')->nullable()->default('');
                $table->string('cnpj')->nullable()->default('');
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
        Schema::dropIfExists('persons');
    }
}
