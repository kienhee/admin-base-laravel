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
        Schema::create('blog_hashtags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_id')->unsigned()->index();
            $table->bigInteger('hashtag_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('hashtag_id')->references('id')->on('hash_tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_hashtags');
    }
};
