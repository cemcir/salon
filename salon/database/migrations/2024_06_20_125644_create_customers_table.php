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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('adi',50);
            $table->string('soyAdi',50);
            $table->string('gsm',30);
            $table->string('telefon',30);
            $table->string('adres',500);
            $table->string('eposta',100)->unique();
            $table->string('tcNo',20)->unique();
            $table->decimal('bakiye',10,2)->default(0);
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
        Schema::dropIfExists('customers');
    }
};
