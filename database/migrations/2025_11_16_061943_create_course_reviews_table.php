<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('course_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->text('comment');
            $table->timestamps();

            // Un usuario solo puede hacer una reseña por curso
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_reviews');
    }
}