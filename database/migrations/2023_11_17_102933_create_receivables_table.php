<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('happen_month',7);
            $table->char('currency',3);
            $table->char('site',2);
            $table->string('account_name');
            $table->string('platform_order_sn');
            $table->decimal('end_rmb_balance',12,2);
            $table->decimal('delivery_amount',12,2);
            $table->decimal('receive_amount',12,2);
            $table->date('delivery_time');
            $table->date('receive_time');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receivables');
    }
}
