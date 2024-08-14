<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountReceivableAgingPeriod extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account_receivable_aging_periods';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ar_invoice_date_start_1',
        'ar_invoice_date_end_1',
        'ar_invoice_date_start_2',
        'ar_invoice_date_end_2',
        'ar_invoice_date_start_3',
        'ar_invoice_date_end_3',
        'ar_invoice_date_start_4',
        'ar_invoice_date_end_4',
        'ar_due_date_start_2',
        'ar_due_date_end_2',
        'ar_due_date_start_3',
        'ar_due_date_end_3',
        'ar_due_date_start_4',
        'ar_due_date_end_4',
        'ar_due_date_start_5',
        'ar_due_date_end_5',
        'do_not_show_on_report',
    ];
}
