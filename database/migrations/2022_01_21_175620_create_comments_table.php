<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('text', 500);
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('article_id');

            // foreign keys
            $table->foreign('author_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
