<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('image_sm')->nullable()->default(null);
            $table->string('image_md')->nullable()->default(null);
            $table->string('image_lg')->nullable()->default(null);
            $table->boolean('status')->default(true)->nullable();
            $table->boolean('featured')->default(true)->nullable();
            $table->boolean('commentable')->default(true)->nullable();
            $table->longText('content')->nullable();
            $table->string('m_title', 255)->nullable();
            $table->text('m_keywords')->nullable();
            $table->text('m_description')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
