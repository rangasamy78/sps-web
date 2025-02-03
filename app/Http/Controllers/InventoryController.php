<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Inventory\InventoryRepository;


class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private InventoryRepository $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function index()
    {
        return view('inventory.inventories');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->inventoryRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->inventoryRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $inventory = $this->inventoryRepository->findOrFail($id);
            if ($inventory) {
                $this->inventoryRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'Inventory deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Inventory not found.']);
            }
        } catch (Exception $e) {
            
            Log::error('Error deleting inventory: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the inventory.']);
        }
    }
    public function getInventoryDataTableList(Request $request)
    {
        
        return $this->inventoryRepository->dataTable($request);
    }
}

