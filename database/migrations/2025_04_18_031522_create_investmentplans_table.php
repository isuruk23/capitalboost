<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investmentplans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plan_value');
            $table->integer('installment');
            $table->decimal('monthly_installment', 15, 2);
            $table->decimal('total_payment', 15, 2);
            $table->decimal('guaranteed_maturity', 15, 2);            
            $table->decimal('illustrated_maturity', 15, 2);
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
        Schema::dropIfExists('investmentplans');
    }
}
