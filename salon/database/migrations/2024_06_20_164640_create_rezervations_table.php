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
        Schema::create('rezervations', function (Blueprint $table) {
            $table->id();
            $table->decimal('kiraTutari',10,2)->default(0);
            $table->decimal('menuTutari',10,2)->default(0);
            $table->time('girisSaat')->nullable();
            $table->time('cikisSaat')->nullable();
            $table->date('rezervasyonTarih')->nullable();
            $table->string('rezervasyonNotu',500)->nullable();
            $table->enum('odemeDurum',['0','1'])->default('0');
            $table->unsignedBigInteger('carikart_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('carikart_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('rezervations');
    }

};
