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
        Schema::create('payment_customers', function (Blueprint $table) {
            $table->id();
            $table->decimal('tutar',10,2)->default(0);
            $table->integer('hareket')->default(2); // 1 tahsilat(cari alacağı) 2 cari borcu
            $table->unsignedBigInteger('carikart_id');
            $table->unsignedBigInteger('vardiya_id');
            $table->foreign('carikart_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('payment_customers');
    }
};
