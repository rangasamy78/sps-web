<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PickTicketRestriction;
use App\Repositories\PickTicketRestrictionRepository;

class PickTicketRestrictionController extends Controller
{
    private PickTicketRestrictionRepository $pickTicketRestrictionRepository;

    public function __construct(PickTicketRestrictionRepository $pickTicketRestrictionRepository)
    {
        $this->pickTicketRestrictionRepository = $pickTicketRestrictionRepository;
    }
    
    public function index()
    {
        $pickTicketRestrictionDetail = PickTicketRestriction::latest()->first();
        return view('pick_ticket_restriction.pick_ticket_restrictions', compact('pickTicketRestrictionDetail'));
    }
    
    public function save(Request $request)
    {
        try {
            $lastInsertId = $this->pickTicketRestrictionRepository->save($request->all());
            return response()->json(['status' => 'success', 'msg' => 'Pick ticket restriction saved successfully.','lastId' => $lastInsertId ? $lastInsertId : $request->id ]);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving pick ticket restriction: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the pick ticket restriction.']);
        }
    }
}
