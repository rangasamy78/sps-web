<?php

namespace App\Services\User;

use App\Models\Designation;

class UserService
{
    public function getDesignation($request)
    {
        try {
            $typeId = (array)$request->get('type_id');
            $designations = Designation::whereIn('department_id', $typeId)->get();
            return response()->json(['designations' => $designations]);
        } catch (\Exception $e) {
            Log::error('Error fetching designations: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while fetching the designations.']);
        }
    }

}
