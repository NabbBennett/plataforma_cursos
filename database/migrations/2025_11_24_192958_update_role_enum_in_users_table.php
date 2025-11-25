<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateRoleEnumInUsersTable extends Migration
{
    public function up()
    {
        // Primero actualizamos los valores existentes si es necesario
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'ayudante', 'maestro', 'student') NOT NULL DEFAULT 'student'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'student') NOT NULL DEFAULT 'student'");
    }
}