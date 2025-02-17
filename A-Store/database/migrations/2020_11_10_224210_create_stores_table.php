<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id()->index();
            $table->foreignId('user_id')->constrained('users');
            $table->string('thumbnail');
            $table->string('nm_toko');
            $table->string('no_telepon');
            $table->string('no_rekening');
            $table->string('pemilik_rekening');
            $table->string('bank');
            $table->string('alamat');
            $table->string('kota');
            $table->integer('kd_pos');
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
        Schema::dropIfExists('stores');
    }
}
