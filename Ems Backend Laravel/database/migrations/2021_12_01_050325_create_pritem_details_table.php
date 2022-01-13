<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PurchaseRequisition;

class CreatePRItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_r_item_details', function (Blueprint $table) {
            $table->id();
            $table->enum('purchase_type', ['international', 'local', 'ready_stock', 'importation', 'product_delivary', 'installation']);
            $table->string('item_description');
            $table->integer('item_quantity');
            $table->string('measurement_of_unit')->nullable();
            $table->date('required_date')->nullable();
            $table->integer('estimated_unit_price');
            $table->integer('estimated_total_price');
            $table->foreignId('purchase_requisition_id');
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
        Schema::dropIfExists('p_r_item_details');
    }
}
