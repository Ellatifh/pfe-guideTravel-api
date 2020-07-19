<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHebergementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hebergements', function (Blueprint $table) {
            $table->string("endroits_reference");
            $table->foreign('endroits_reference')->references('reference')->on('endroits')->onDelete('cascade');
            $table->integer("ranking");
            $table->boolean("wifi")->default(false);
            $table->boolean("piscine")->default(false);
            $table->boolean("restaurant")->default(false);
            $table->boolean("spa")->default(false);
            $table->boolean("fitness")->default(false);
            $table->integer("rooms");
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['endroits_reference']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hebergements');
    }
}
