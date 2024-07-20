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
        Schema::table('payment_customers', function (Blueprint $table) {
            $table->integer('tahsilatTuru')->after('tutar')->default(0); //0 Devir Girişi 1 Nakit 2 Kredi Kartı 3 Havale
            $table->string('fisNo',30)->after('tutar')->nullable();
            $table->string('aciklama',500)->after('tutar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_customers', function (Blueprint $table) {
            $table->dropColumn('tahsilatTuru');
            $table->dropColumn('fisNo');
            $table->dropColumn('aciklama');
        });
    }
};
