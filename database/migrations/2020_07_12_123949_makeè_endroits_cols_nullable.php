<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeèEndroitsColsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('endroits', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('telephone')->nullable()->change();
            $table->string('website')->nullable()->change();
            $table->integer('zipcode')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('endroits', function (Blueprint $table) {
            //
        });
    }
}
