<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryAdjustmentReasonCode extends Model
{
    use HasFactory;
    protected $table = 'inventory_adjustment_reason_codes';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'reason',
        'adjustment_type_id',
        'income_expense_account_id'
    ];

    function linked_adjustment_type()
    {
        return $this->belongsTo(LinkedAccount::class, 'income_expense_account_id');
    }

}

