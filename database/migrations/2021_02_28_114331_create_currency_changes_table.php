<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('from_currency');
            $table->integer('to_currency');
            $table->integer('base_currency');
            $table->bigInteger('amount');
            $table->bigInteger('converted_amount');
            $table->string('refrence')->nullable();
            $table->boolean('status')->default(0);

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
        Schema::dropIfExists('currency_changes');
    }
}
