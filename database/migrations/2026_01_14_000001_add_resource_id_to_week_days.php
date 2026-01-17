<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('week_days', function (Blueprint $table) {
            if (!Schema::hasColumn('week_days', 'resource_id')) {
                $table->unsignedBigInteger('resource_id')->nullable()->after('recording_link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('week_days', function (Blueprint $table) {
            if (Schema::hasColumn('week_days', 'resource_id')) {
                $table->dropColumn('resource_id');
            }
        });
    }
};
