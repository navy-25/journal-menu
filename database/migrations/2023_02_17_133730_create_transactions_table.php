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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('name');
            $table->integer('type')->comment('1:pegawai;2:bahan;3:operasional;4:alat;5:outlet;6:lainnya');
            $table->string('status')->comment('in/out');
            $table->bigInteger('price');
            $table->string('date');
            $table->longText('note')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
