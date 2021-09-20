<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $fillable = [
        'first_name', 'last_name', 'account_no', 'account_type', 'account_balance', 'branch'
    ];
}
