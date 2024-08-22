<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\CreditCheckSetting;
use Illuminate\Support\Facades\Log;
use App\Repositories\CreditCheckSettingRepository;


class CreditCheckSettingController extends Controller
{
    private CreditCheckSettingRepository $creditCheckSettingRepository;

    public function __construct(CreditCheckSettingRepository $creditCheckSettingRepository)
    {
        $this->creditCheckSettingRepository = $creditCheckSettingRepository;
    }
    
    public function index()
    {
        $creditCheckSettingDetail = CreditCheckSetting::latest()->first();
        return view('credit_check_setting.credit_check_settings', compact('creditCheckSettingDetail'));
    }

    public function save(Request $request)
    {
        try {
            $lastInsertId = $this->creditCheckSettingRepository->save($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Credit check setting saved successfully.','lastId' => $lastInsertId ? $lastInsertId : $request->id ]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving credit check setting: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the credit check setting.']);
        }
    }
}
