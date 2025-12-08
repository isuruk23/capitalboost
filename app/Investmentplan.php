<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investmentplan extends Model
{
    protected $table = 'investmentplans';

    protected $fillable = [
        'plan_id','plan','invest_amount', 'installment', 'monthly_installment', 'total_payment',
        'guaranteed_maturity', 'illustrated_maturity', 'initials_payment', 'monthly_income', 'term_of_years', 'status'
    ];
}
