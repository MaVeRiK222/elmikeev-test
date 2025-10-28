<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->date("last_change_date")->nullable();
            $table->string("supplier_article", 50)->nullable();
            $table->string("tech_size", 50)->nullable();
            $table->integer("barcode");
            $table->integer("quantity");
            $table->boolean("is_supply")->nullable();
            $table->boolean("is_realization")->nullable();
            $table->integer("quantity_full")->nullable();
            $table->string("warehouse_name", 50);
            $table->integer("in_way_to_client")->nullable();
            $table->integer("in_way_from_client")->nullable();
            $table->integer("nm_id");
            $table->string("subject", 50)->nullable();
            $table->string("category", 50)->nullable();
            $table->string("brand", 50)->nullable();
            $table->integer("sc_code")->nullable();
            $table->decimal("price",10,2)->nullable();
            $table->decimal("discount",10,2)->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
