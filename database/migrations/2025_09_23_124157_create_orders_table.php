<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("g_number", 50)->nullable();
            $table->date("date")->nullable();
            $table->date("last_change_date")->nullable();
            $table->string("supplier_article", 50)->nullable();
            $table->string("tech_size", 50)->nullable();
            $table->integer("barcode")->nullable();
            $table->decimal("total_price", 10, 2)->nullable();
            $table->integer("discount_percent")->nullable();
            $table->string("warehouse_name", 50)->nullable();
            $table->string("oblast", 50)->nullable();
            $table->integer("income_id")->nullable();
            $table->integer("odid")->nullable();
            $table->integer("nm_id")->nullable();
            $table->string("subject")->nullable();
            $table->string("category")->nullable();
            $table->string("brand")->nullable();
            $table->boolean("is_cancel")->nullable();
            $table->date("cancel_dt")->nullable();
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
        Schema::dropIfExists('orders');
    }
}
