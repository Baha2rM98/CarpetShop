<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManyToManyRelationForAttributeValueAndProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributevalue_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('attribute_value_id')->unsigned();
            $table->foreign('attribute_value_id')->references('id')->on('attributes_value');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('attributevalue_product');
    }
}
