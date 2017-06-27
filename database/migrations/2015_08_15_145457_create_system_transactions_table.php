<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->enum('type',['featured_fee','transaction_fee','subscription_transaction_fee']);
            $table->integer('coins');
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
        Schema::drop('system_transactions');
    }
}
