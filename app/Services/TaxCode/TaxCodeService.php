<?php

namespace App\Services\TaxCode;

use App\Models\TaxCode;
use Illuminate\Support\Facades\DB;

class TaxCodeService
{
    public function getNextSortOrder()
    {
        $lastSortOrder = TaxCode::orderBy('sort_order', 'desc')->first();

        return $lastSortOrder ? $lastSortOrder->sort_order + 10 : 10;
    }

    public function getRateBreakDown($id){

        $tax_code  = DB::table('tax_components')
            ->join('accounts', 'accounts.id', '=', 'tax_components.sales_tax_id')
            ->select('tax_components.id','tax_components.component_name','tax_components.tax_code_total','accounts.account_number',
                DB::raw("CONCAT(accounts.account_number, ' - ', accounts.account_name) AS account_details"))
            ->where('tax_components.tax_code_id', '=', $id)
            ->first();

        return $tax_code->component_name.' '. $tax_code->account_number.' '.$tax_code->tax_code_total." % ";

    } 

    public function getCurrentRate($id){

        $tax_code  = DB::table('tax_components')
            ->join('accounts', 'accounts.id', '=', 'tax_components.sales_tax_id')
            ->select('tax_components.id','tax_components.component_name','tax_components.tax_code_total','accounts.account_number',
                DB::raw("CONCAT(accounts.account_number, ' - ', accounts.account_name) AS account_details"))
            ->where('tax_components.tax_code_id', '=', $id)
            ->first();

        return $tax_code->tax_code_total." % ";

    } 
    
}
