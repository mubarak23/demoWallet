<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('account_no')->nullable();
            $table->string("txn_type", 255)->nullable();
            $table->decimal("amount", 20, 2)->nullable();
            $table->string("reference")->nullable();
            $table->decimal("balance_before", 20, 2)->nullable();
            $table->decimal("balance_after", 20, 2)->nullable();
            $table->longText('metadata')->nullable()->default('text');
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
        Schema::dropIfExists('client_transactions');
    }
}
