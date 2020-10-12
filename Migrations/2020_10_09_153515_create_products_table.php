<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('menu_id')->unsigned()->nullable()->default(null);
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->bigInteger('brand_id')->unsigned()->nullable()->default(null);
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');            
            $table->string('name');
            $table->string('slug')->unique()->nullable();            
            $table->string('media')->nullable();
            $table->string('file')->nullable();
            $table->text('video')->nullable();
            $table->text('more_images')->nullable();
            $table->double('amount', 12, 2)->nullable();
            $table->double('cost', 12, 2)->nullable();
            $table->boolean('control_stock')->default(0);
            $table->integer('stock_quantity')->nullable();
            $table->integer('minimum_quantity')->nullable();
            
            $table->string('weight')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();

            $table->string('bar_code')->nullable();
            $table->string('internal_code')->nullable();
            $table->date('release')->nullable();
            $table->integer('sold')->default(0);
            $table->enum('status', array_keys(\Modules\Products\Models\Product::STATUS))->default('active');
            $table->enum('packing', array_keys(\Modules\Products\Models\Product::PACKING))->nullable()->default(null);
            $table->longText('summary')->nullable();
            $table->longText('body')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();            

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->id();           
            $table->bigInteger('product_id')->unsigned()->nullable()->default(null);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');           
            $table->bigInteger('category_id')->unsigned()->nullable()->default(null);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
    }
}
