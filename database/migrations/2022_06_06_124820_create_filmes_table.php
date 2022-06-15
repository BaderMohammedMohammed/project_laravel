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
        Schema::create('filmes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('NameFilm');
            $table->string('ImgFilm')->nullable();
            $table->string('DetailsFilm',1500);
            $table->double('RatFilm'); // تقييم الفلم
            $table->date('DateFilm'); // تاريخ العرض
            $table->string('lengthFilm'); // مدة عرض الفلم
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
        Schema::dropIfExists('filmes');
    }
};
