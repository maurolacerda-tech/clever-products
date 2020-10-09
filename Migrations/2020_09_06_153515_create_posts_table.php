<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('menu_id')->unsigned()->nullable()->default(null);
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->unique()->nullable();  
            $table->date('date_publish')->nullable();
            $table->string('media')->nullable(); 
            $table->enum('status', array_keys(\Modules\Posts\Models\Post::STATUS))->default('active');
            $table->enum('format', array_keys(\Modules\Posts\Models\Post::FORMAT))->default('image');
            $table->longText('summary')->nullable();
            $table->longText('body')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();            

            $table->timestamps();
        });

        Schema::create('category_post', function (Blueprint $table) {
            $table->id();           
            $table->bigInteger('post_id')->unsigned()->nullable()->default(null);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');           
            $table->bigInteger('category_id')->unsigned()->nullable()->default(null);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();           
            $table->bigInteger('tag_id')->unsigned()->nullable()->default(null);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->bigInteger('post_id')->unsigned()->nullable()->default(null);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
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
        Schema::dropIfExists('category_post');
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('posts');
    }
}
