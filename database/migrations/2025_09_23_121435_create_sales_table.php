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
            $table->string("g_number", 50)->nullable();// "97590226466738820217",
            $table->date("date")->nullable();// "2024-11-09",
            $table->date("last_change_date")->nullable();// "2024-11-10",
            $table->string("supplier_article", 50)->nullable();// "edad594e1855ee82",
            $table->string("tech_size", 50)->nullable();// "66e7dff9f98764da",
            $table->integer("barcode")->nullable();// 42546173,
            $table->decimal("total_price", 10, 2)->nullable();// "13407.4",
            $table->integer("discount_percent")->unsigned()->nullable();// "36",
            $table->boolean("is_supply")->nullable();// false,
            $table->boolean("is_realization")->nullable();// true,
            $table->string("promo_code_discount", 50)->nullable();// null,
            $table->string("warehouse_name", 50)->nullable();// "Чашниково",
            $table->string("country_name", 50)->nullable();// "Россия",
            $table->string("oblast_okrug_name", 100)->nullable();// "Центральный федеральный округ",
            $table->string("region_name", 50)->nullable();// "Москва",
            $table->string("income_id")->nullable();// 0,
            $table->string("sale_id", 50)->nullable();// "S13696218161",
            $table->string("odid", 50)->nullable();// null,
            $table->integer("spp")->nullable();// "7",
            $table->decimal("for_pay", 8, 2)->nullable();// "3506.49",
            $table->integer("finished_price")->nullable();// "3599",
            $table->integer("price_with_disc")->nullable();// "3991",
            $table->integer("nm_id")->nullable();// 396304892,
            $table->string("subject", 50)->nullable();// "4c3c3df48b6eb1a2",
            $table->string("category", 50)->nullable();// "9f463620982b6cc9",
            $table->string("brand", 50)->nullable();// "6fa4cfc9a11e8534",
            $table->boolean("is_storno")->nullable();// null
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
