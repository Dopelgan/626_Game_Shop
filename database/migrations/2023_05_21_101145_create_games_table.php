<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->longText('description');
            $table->unsignedInteger('price')->default('0');
            $table->unsignedInteger('quantity')->default('0');
            $table->unsignedBigInteger('sold_quantity')->default('0');
            $table->unsignedBigInteger('count')->default('0');
            $table->unsignedInteger('year');
            $table->longText('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
