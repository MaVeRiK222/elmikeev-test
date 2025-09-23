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
            $table->string("g_number", 50)->nullable(); // "9586989214519846085",
            $table->date("date")->nullable(); // "2024-10-11 19->nullable(); //45->nullable(); //11",
            $table->date("last_change_date")->nullable(); // "2024-10-12",
            $table->string("supplier_article", 50)->nullable(); // "1bdd7286d7410f4c",
            $table->string("tech_size", 50)->nullable(); // "66e7dff9f98764da",
            $table->integer("barcode")->nullable(); // 77243558,
            $table->decimal("total_price", 10, 2)->nullable(); // "1569.5",
            $table->integer("discount_percent")->nullable(); // 10,
            $table->string("warehouse_name", 50)->nullable(); // "Казань",
            $table->string("oblast", 50)->nullable(); // "Красноярский край",
            $table->integer("income_id")->nullable(); // 23829313,
            $table->integer("odid")->nullable(); // "0",
            $table->integer("nm_id")->nullable(); // 165894499,
            $table->string("subject")->nullable(); // "f694ab2be55693c7",
            $table->string("category")->nullable(); // "9f463620982b6cc9",
            $table->string("brand")->nullable(); // "a66c77274e96b48c",
            $table->boolean("is_cancel")->nullable(); // false,
            $table->date("cancel_dt")->nullable(); // null
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
