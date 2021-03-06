<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientTransaction extends Model
{
    //
    protected $fillable = [
        'account_no', 'txn_type', 'amount', 'reference', 'metadata', 'balance_before', 'balance_after'
    ];

}
