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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->date('baslangicTarih')->nullable();
            $table->date('bitisTarih')->nullable();
            $table->decimal('ciro',10,2)->default(0);
            $table->decimal('cariTahsilat',10,2)->default(0);
            $table->decimal('gelir',10,2)->default(0);
            $table->decimal('gider',10,2)->default(0);
            $table->decimal('netKasa',10,2)->default(0);
            $table->decimal('nakit',10,2)->default(0);
            $table->decimal('krediKarti',10,2)->default(0);
            $table->decimal('havale',10,2)->default(0);
            $table->decimal('netKar',10,2)->default(0);
            $table->enum('durum',['0','1'])->default('1');
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
        Schema::dropIfExists('shifts');
    }
};
