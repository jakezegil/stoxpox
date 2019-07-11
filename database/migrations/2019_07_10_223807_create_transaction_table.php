<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('buyer_id');
            $table->integer('seller_id')->nullable();
            $table->integer('product_id');
            $table->integer('product_count');
            $table->decimal('price_per_product', 8, 2);
            $table->decimal('total_price', 12, 2);	
            $table->timestamps();

            $table->foreign('buyer_id')
                ->references('id')
                ->on('users');
                
            $table->foreign('seller_id')
                ->references('id')
                ->on('users');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });

        Schema::table('products', function (Blueprint $table) {
            //
            $table->decimal('price', 8, 2)->change();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');

        Schema::table('products', function (Blueprint $table) {
            //
            $table->integer('price')->change();
            });
    }
}
