<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('added_by');
            $table->string('product_category');
            $table->string('product_name');
            $table->string('product_particulars');
            $table->string('client_name')->nullable();
            $table->integer('per_unit_price');
            $table->integer('latest_stock');
            $table->date('latest_stock_date');
            $table->integer('physically_found_quantity');
            $table->integer('sales_quantity');
            $table->integer('purchase_quantity');
            $table->integer('stock_quantity_to_be_reported');
            $table->integer('excess_quantity');
            $table->integer('shortage_quantity');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
