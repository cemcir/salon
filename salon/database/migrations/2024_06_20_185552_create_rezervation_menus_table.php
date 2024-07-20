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
        Schema::create('rezervation_menus',function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rezervasyon_id');
            $table->unsignedBigInteger('menu_id');
            $table->foreign('rezervasyon_id')->references('id')->on('rezervations')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
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
        Schema::dropIfExists('rezervation_menus');
    }
};
