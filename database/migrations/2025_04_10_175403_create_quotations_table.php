<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_with_initial');
            $table->text('address');
            $table->string('nic_no');
            $table->decimal('initial_investment', 15, 2);
            $table->string('period');
            $table->string('paying_term');
            $table->string('mode_of_payment');
            $table->integer('plan_id');
            $table->date('installment_date');
            $table->integer('created_by');
            $table->integer('approved_by');
            $table->integer('status');
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
        //
    }
}
