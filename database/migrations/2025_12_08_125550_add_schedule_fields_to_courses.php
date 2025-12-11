<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // ID del grupo de contenido (4 grupos principales)
            $table->integer('course_group')->nullable()->after('id');
            // Horario o slot de tiempo (Lunes 9am, Martes 3pm, etc)
            $table->string('schedule')->nullable()->after('course_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['course_group', 'schedule']);
        });
    }
};
