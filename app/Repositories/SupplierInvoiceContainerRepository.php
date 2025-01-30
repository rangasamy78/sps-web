<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\SupplierInvoiceContainer;
use App\Models\SupplierInvoicePackingItem;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class SupplierInvoiceContainerRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
   
    public function findOrFail(int $id)
    {
        return SupplierInvoiceContainer::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
       
        return SupplierInvoiceContainer::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SupplierInvoiceContainer::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getSupplierInvoiceContainerList(Request $request)
    {
        $query = SupplierInvoiceContainer::query();
    
    
        return $query;
    }
    
    public function dataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? 0;
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';
      
        $PriceListLabels = $this->getSupplierInvoiceContainerList($request);
    
        $total = $PriceListLabels->count();
        $totalFilter = $this->getSupplierInvoiceContainerList($request);
        $totalFilter = $totalFilter->count();
    
        $arrData = $PriceListLabels
            ->skip($start)
            ->take($rowPerPage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();
    
        $arrData->map(function ($value) {
            $value->id        = $value->id ?? '';
            $value->container_number = $value->container_number ?? '';
            $value->received_on     = $value->received_on ?? '';
            $value->received_by     = $value->received_by ?? '';
            $value->notes           = $value->notes ?? '';
            $value->po_id           = $value->po_id ?? '';
    
      
            $value->action    = '<button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-dark fileedit me-2" data-id="' . $value->id . '"><i class="fas fa-edit"></i></button>
                                 <button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-dark updateFile me-2 d-none" data-id="' . $value->id . '"><i class="fas fa-pencil-alt"></i></button>
                                 <button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-danger filedelete" data-id="' . $value->id . '"><i class="fas fa-trash-alt"></i></button>';
        });
    
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        ]);
    }

    public function dataSupplierSlabDataDetails($id)
    { 
       
        
        $supplier = SupplierInvoicePackingItem::where('product_id', $id)
                    ->with('product')
                    ->get();
       
        return $supplier;
    }
}
