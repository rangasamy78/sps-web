<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SupplierInvoicePackingItem;
use App\Repositories\InventoryIntransitRepository;

class InventoryIntransitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private InventoryIntransitRepository $inventoryIntransitRepository;

    public function __construct(InventoryIntransitRepository $inventoryIntransitRepository)
    {
        $this->inventoryIntransitRepository = $inventoryIntransitRepository;
    }

    public function index()
    {
        return view('inventory_intransit.inventory_intransits');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->inventoryIntransitRepository->findOrFail($id);
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
        $model = $this->inventoryIntransitRepository->findOrFail($id);
        return response()->json($model);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
    public function getInventoryIntransitTableList(Request $request)
    {
        return $this->inventoryIntransitRepository->dataTable($request);
    }
}
