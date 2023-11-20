<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    use HasFactory;
    protected $table = 'receivables';
    protected $fillable = [
        'account_name',
        'end_rmb_balance',
        'happen_month'
    ];
}
