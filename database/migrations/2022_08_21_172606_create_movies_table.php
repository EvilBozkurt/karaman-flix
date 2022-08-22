<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->nullable()->constrained()->setNullOnDelete();

            $table->string('slug')->unique();

            $table->string('title');
            $table->longText('description');

            $table->string('image');
            $table->string('trailer')->nullable()->default('test');
            $table->string('year')->nullable()->default('2022');

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
        Schema::dropIfExists('movies');
    }
}
