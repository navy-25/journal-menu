<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('thumbnail')->nullable();
            $table->string('name');
            $table->bigInteger('price');
            $table->bigInteger('hpp');
            $table->integer('is_promo');
            $table->integer('status')->comment('0:non aktif;1:aktif');
            $table->bigInteger('price_promo');
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
        Schema::dropIfExists('menus');
    }
};
