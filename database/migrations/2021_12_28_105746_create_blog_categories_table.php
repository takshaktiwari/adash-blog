<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('blog_category_id')->nullable()->default(null)->constrained()->comment('parent category');
            $table->string('image_sm')->nullable()->default(null);
            $table->string('image_md')->nullable()->default(null);
            $table->string('image_lg')->nullable()->default(null);
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(true);
            $table->string('meta_title', 255)->nullable()->default(null);
            $table->text('meta_keywords')->nullable()->default(null);
            $table->text('meta_description')->nullable()->default(null);
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
        Schema::dropIfExists('blog_categories');
    }
}
