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
        Schema::table('shifts', function (Blueprint $table) {
            $table->decimal('nakitGelir',10,2)->after('gelir')->default(0);
            $table->decimal('nakitGider',10,2)->after('gider')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn('nakitGelir');
            $table->dropColumn('nakitGider');
        });
    }

};
