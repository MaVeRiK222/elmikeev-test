<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->integer("income_id")->nullable(); // 23972270,
            $table->string("number", 50)->nullable(); // "",
            $table->date("date")->nullable(); // "2024-10-15",
            $table->date("last_change_date")->nullable(); // "2024-10-17",
            $table->string("supplier_article", 50)->nullable(); // "0bd4024964e4645d",
            $table->string("tech_size", 50)->nullable(); // "66e7dff9f98764da",
            $table->integer("barcode")->nullable(); // 204428427,
            $table->integer("quantity")->nullable(); // 98,
            $table->integer("total_price")->nullable(); // "0",
            $table->date("date_close")->nullable(); // "2024-10-17",
            $table->string("warehouse_name", 50)->nullable(); // "Казань",
            $table->integer("nm_id")->nullable(); // 613791486
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
        Schema::dropIfExists('incomes');
    }
}
