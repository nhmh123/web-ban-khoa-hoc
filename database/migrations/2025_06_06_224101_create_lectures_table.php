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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id('lec_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('is_intro')->default(false);
            $table->enum('type', ['video', 'article', 'quizz'])->default('video');
            $table->tinyInteger('order')->default(0);
            $table->unsignedBigInteger('sec_id');
            $table->foreign('sec_id')->references('sec_id')->on('sections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
