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
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropForeign(['sec_id']); // tên cột liên kết
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
        });

        Schema::table('lectures', function (Blueprint $table) {
            $table->foreign('sec_id')->references('sec_id')->on('sections'); // không có onDelete
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropForeign(['sec_id']);
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
        });

        Schema::table('lectures', function (Blueprint $table) {
            $table->foreign('sec_id')->references('sec_id')->on('sections')->onDelete('cascade');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }
};
