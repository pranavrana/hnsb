<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');
            $table->bigInteger('user_id');
            $table->string('order_id')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('amount')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('txn_amount')->nullable();
            $table->string('txn_date')->nullable();
            $table->string('txn_payment_mode')->nullable();
            $table->string('txn_bank_txn_id')->nullable();
            $table->string('txn_status')->nullable();
            $table->string('txn_response_code')->nullable();
            $table->text('txn_response_msg')->nullable();
            $table->text('response')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
