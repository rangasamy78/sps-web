<?php

namespace App\Repositories\SaleOrder;

use App\Models\FileType;
use Illuminate\Http\Request;
use App\Models\SaleOrderFile;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\UploadedFile;
use App\Interfaces\CrudRepositoryInterface;

class SaleOrderFileRepository implements CrudRepositoryInterface
{
    use ImageUploadTrait;
    public function findOrFail(int $id)
    {
        return SaleOrderFile::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $accountId = $data['sales_order_id'];
        $fileNames = $data['file_name'];
        $fileTypeId = $data['file_type_id'];
        $notes = $data['notes'];
        foreach ($fileNames as $key => $fileInput) {
            if (!empty($fileInput)) {
                if ($fileInput instanceof UploadedFile) {
                    $filePath = $this->uploadImage($fileInput, 'images');
                } else {
                    continue;
                }
                SaleOrderFile::create([
                    'file_name' => $filePath,
                    'file_type_id' =>  $fileTypeId[$key] ?? null,
                    'notes' =>  $notes[$key] ?? null,
                    'sales_order_id' => $accountId,
                ]);
            }
        }
    }

    public function update(array $data, int $id)
    {
        $query = SaleOrderFile::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getSaleOrderFileList($id)
    {
        $query = SaleOrderFile::where('sales_order_id', $id);
        return $query;
    }

    public function dataTable(Request $request, $id)
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
        $PriceListLabels = $this->getSaleOrderFileList($id);
        $total           = $PriceListLabels->count();

        $totalFilter = $this->getSaleOrderFileList($id);
        $totalFilter = $totalFilter->count();

        $arrData     = $this->getSaleOrderFileList($id);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData     = $arrData->get();

        $arrData->map(function ($value) {
            $fileTypes = FileType::where('file_type_saleorder', 1)->select('id', 'file_Type')->get();
            $value->id = $value->id ?? '';
            $value->image = '<img src="' . (pathinfo($value->file_name, PATHINFO_EXTENSION) === 'pdf' ? asset('public/assets/img/elements/22.png') : asset('storage/app/public/' . $value->file_name)) . '" alt="file-preview" class="d-block rounded" height="40" width="40" />';
            $value->file_name = '<label>' . $value->file_name . '</label>';
            $fileTypeOptions = '<option>--select--</option>';
            foreach ($fileTypes as $fileType) {
                $fileTypeOptions .= '<option value="' . $fileType->id . '"' . ($value->file_type_id == $fileType->id ? ' selected' : '') . '>' . $fileType->file_Type . '</option>';
            }
            $value->file_type_id = '<select id="file_type_id" name="file_type_id" class="select2 form-select ' . ($value->file_type_id ? '' : 'bg-label-secondary') . '" data-allow-clear="true" disabled>'
                . $fileTypeOptions . '</select>';
            $value->notes = '<input type="text" name="notes" value="' . ($value->notes ?? '') . '" class="form-control ' . ($value->notes ? '' : 'bg-label-secondary') . '" readonly disabled>';
            $value->action = '<button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-dark fileedit me-2" data-id="' . $value->id . '"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-dark updateFile me-2 d-none" data-id="' . $value->id . '"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-sm rounded-pill btn-icon btn-label-danger filedelete" data-id="' . $value->id . '"><i class="fas fa-trash-alt"></i></button>';
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
