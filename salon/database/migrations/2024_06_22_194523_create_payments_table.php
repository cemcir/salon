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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('tutar',10,2)->default(0);
            $table->integer('tahsilatTuru')->default(1); // 1 Nakit 2 Kredi Kartı 3 Havale 4 Açık Hesap
            $table->unsignedBigInteger('rezervasyon_id');
            $table->unsignedBigInteger('vardiya_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('rezervasyon_id')->references('id')->on('rezervations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vardiya_id')->references('id')->on('shifts')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
};
