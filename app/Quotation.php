<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'name_with_initial',
        'address',
        'nic_no',
        'plan_id',
        'sub_plan_id',
        'period',
        'paying_term',
        'mode_of_payment',
        'product_id',
        'created_by',
        'approved_by',
    ];
}
