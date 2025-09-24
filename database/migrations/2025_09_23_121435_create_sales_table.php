<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string("g_number", 50)->nullable();
            $table->date("date")->nullable();
            $table->date("last_change_date")->nullable();
            $table->string("supplier_article", 50)->nullable();
            $table->string("tech_size", 50)->nullable();
            $table->integer("barcode")->nullable();
            $table->decimal("total_price", 10, 2)->nullable();
            $table->integer("discount_percent")->unsigned()->nullable();
            $table->boolean("is_supply")->nullable();
            $table->boolean("is_realization")->nullable();
            $table->string("promo_code_discount", 50)->nullable();
            $table->string("warehouse_name", 50)->nullable();
            $table->string("country_name", 50)->nullable();
            $table->string("oblast_okrug_name", 100)->nullable();
            $table->string("region_name", 50)->nullable();
            $table->string("income_id")->nullable();
            $table->string("sale_id", 50)->nullable();
            $table->string("odid", 50)->nullable();
            $table->integer("spp")->nullable();
            $table->decimal("for_pay", 8, 2)->nullable();
            $table->integer("finished_price")->nullable();
            $table->integer("price_with_disc")->nullable();
            $table->integer("nm_id")->nullable();
            $table->string("subject", 50)->nullable();
            $table->string("category", 50)->nullable();
            $table->string("brand", 50)->nullable();
            $table->boolean("is_storno")->nullable();
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
        Schema::dropIfExists('sales');
    }
}
