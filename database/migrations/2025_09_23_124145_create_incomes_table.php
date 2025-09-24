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
            $table->integer("income_id")->nullable();
            $table->string("number", 50)->nullable();
            $table->date("date")->nullable();
            $table->date("last_change_date")->nullable();
            $table->string("supplier_article", 50)->nullable();
            $table->string("tech_size", 50)->nullable();
            $table->integer("barcode")->nullable();
            $table->integer("quantity")->nullable();
            $table->integer("total_price")->nullable();
            $table->date("date_close")->nullable();
            $table->string("warehouse_name", 50)->nullable();
            $table->integer("nm_id")->nullable();
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
