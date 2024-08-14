<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgingPeriodAP extends Model
{
    use HasFactory;
    protected $table = 'aging_period_account_payables';
    protected $fillable = [
        'invoice_aging_period_ap_1_start',
        'invoice_aging_period_ap_2_start',
        'invoice_aging_period_ap_3_start',
        'invoice_aging_period_ap_4_start',
        'invoice_aging_period_ap_1_end',
        'invoice_aging_period_ap_2_end',
        'invoice_aging_period_ap_3_end',
        'invoice_aging_period_ap_4_end',
        'due_date_aging_period_ap_1_start',
        'due_date_aging_period_ap_2_start',
        'due_date_aging_period_ap_3_start',
        'due_date_aging_period_ap_4_start',
        'due_date_aging_period_ap_1_end',
        'due_date_aging_period_ap_2_end',
        'due_date_aging_period_ap_3_end',
        'due_date_aging_period_ap_4_end',
    ];
}
