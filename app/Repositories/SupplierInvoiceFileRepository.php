<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;
use App\Models\SupplierInvoiceFile;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class SupplierInvoiceFileRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    use ImageUploadTrait;
    public function findOrFail(int $id)
    {
        return SupplierInvoiceFile::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $poId = $data['po_id'];
        $fileNames = $data['file_name'];
        $notes     = $data['notes'];
        foreach ($fileNames as $key => $fileInput) {
            if (!empty($fileInput)) {
                if ($fileInput instanceof UploadedFile) {
                    $filePath = $this->uploadImage($fileInput, 'images');
                } else {
                    continue;
                }
                SupplierInvoiceFile::create([
                    'file_name'  => $filePath,
                    'notes'      => $notes[$key] ?? null,
                    'po_id' => $poId,
                ]);
            }
        }
    }

    public function update(array $data, int $id)
    {
        $query = SupplierInvoiceFile::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getProductFileList($request)
    {

        $query = SupplierInvoiceFile::query();
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $columnName      = 'created_at';
        $PriceListLabels = $this->getProductFileList($request);
        $total           = $PriceListLabels->count();

        $totalFilter = $this->getProductFileList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getProductFileList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value) {
            $value->id        = $value->id ?? '';
            $value->image     = '<img src="' . (pathinfo($value->file_name, PATHINFO_EXTENSION) === 'pdf' ? asset('public/assets/img/elements/22.png') : asset('storage/app/public/' . $value->file_name)) . '" alt="file-preview" class="d-block rounded" height="40" width="40" />';
            $value->file_name = '<label>' . $value->file_name . '</label>';
            $value->notes     = '<input type="text" name="notes" value="' . ($value->notes ?? '') . '" class="form-control ' . ($value->notes ? '' : 'bg-label-secondary') . '" readonly>';
            $value->action    = '<button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-dark fileedit me-2" data-id="' . $value->id . '"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-dark updateFile me-2 d-none" data-id="' . $value->id . '"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-danger filedelete" data-id="' . $value->id . '"><i class="fas fa-trash-alt"></i></button>';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }
}
