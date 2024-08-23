<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgingPeriodAP extends Model
{
    use HasFactory;
    protected $table = 'aging_period_account_payables';
    protected $fillable = [
        'ap_invoice_date_start_1',
        'ap_invoice_date_end_1',
        'ap_invoice_date_start_2',
        'ap_invoice_date_end_2',
        'ap_invoice_date_start_3',
        'ap_invoice_date_end_3',
        'ap_invoice_date_start_4',
        'ap_invoice_date_end_4',
        'ap_due_date_start_2',
        'ap_due_date_end_2',
        'ap_due_date_start_3',
        'ap_due_date_end_3',
        'ap_due_date_start_4',
        'ap_due_date_end_4',
        'ap_due_date_start_5',
        'ap_due_date_end_5',
    ];
}
