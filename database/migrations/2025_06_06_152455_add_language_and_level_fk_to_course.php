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
        Schema::table('Courses', function (Blueprint $table) {
            $table->unsignedBigInteger('language_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable()->after('language_id');
            $table->foreign('language_id')->references('lang_id')->on('languages')->onDelete('set null');
            $table->foreign('level_id')->references('level_id')->on('difficulty_levels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Courses', function (Blueprint $table) {
            //
        });
    }
};
