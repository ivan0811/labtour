<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('city_id')->unsigned();
            $table->string('name');
            $table->text('image')->nullable()->default(null);
            $table->timestamps();            
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('tour_id')
            ->references('id')
            ->on('tours')
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
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_tour_id_foreign');
        });        
        Schema::dropIfExists('tours');
    }
}
