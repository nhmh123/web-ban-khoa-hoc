<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'bank_name',
        'bank_code',
        'bank_bin',
        'account_number',
        'account_name',
        'is_default',
    ];
}
