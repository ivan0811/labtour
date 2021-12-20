<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('province_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('province_id')
            ->references('id')
            ->on('provinces')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->foreign('city_id')
            ->references('id')
            ->on('cities')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {  
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign('tours_city_id_foreign');
        });  
        Schema::dropIfExists('cities');
    }
}
