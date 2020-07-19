<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndroitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endroits', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('name');
            $table->string('description');
            $table->string('adresse1');
            $table->string('adresse2')->nullable();
            $table->string('email');
            $table->string('telephone');
            $table->string('website');
            $table->time('startTime');
            $table->time('endTime');
            $table->integer('zipcode');
            $table->string('longitude');
            $table->string('latitude');
            $table->foreignId('produits_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endroits');
    }
}
