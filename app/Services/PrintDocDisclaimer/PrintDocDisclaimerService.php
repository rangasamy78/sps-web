<?php

namespace App\Services\PrintDocDisclaimer;

use App\Models\SelectTypeSubCategory;

class PrintDocDisclaimerService
{
    public function getSubCategories($request)
    {
        try {
            $typeId = $request->get('type_id');
            $selectTypeSubCategory = SelectTypeSubCategory::where('select_type_category_id', $typeId)->get();
            
            return response()->json(['subcategories' => $selectTypeSubCategory]);
        } catch (\Exception $e) {
            Log::error('Error fetching subcategories: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while fetching the subcategories.']);
        }
    }
}