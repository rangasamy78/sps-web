<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_name',
        'account_number',
        'account_type_id',
        'account_sub_type_id',
        'special_account_type_id',
        'account_operating_location_id',
        'alternate_number',
        'alternate_name',
        'is_sub_account_of_id',
        'currency_id',
        'statement_end_day',
        'is_default_account',
        'is_budgeted_account',
        'is_tax_account',
        'is_reconciled_account',
        'is_allow_bank_reconciliation',
        'back_name',
        'branch_name',
        'manager_name',
        'phone',
        'fax',
        'website',
        'swift_code',
        'routing_number',
        'bank_account_number',
        'is_allow_printing_checks',
        'internal_notes',
        'status',
    ];

    protected $table = 'accounts';
}