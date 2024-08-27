<?php

namespace App\Repositories;

use App\Models\FileType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class FileTypeRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id): Model
    {
        return FileType::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        $preparedData = [
            'view_in'               => $data['view_in'] ?? null,
            'file_type'             => $data['file_type'] ?? null,
            'file_type_opportunity' => isset($data['file_type_opportunity']) ? 1 : 0,
            'file_type_quote'       => isset($data['file_type_quote']) ? 1 : 0,
            'file_type_saleorder'   => isset($data['file_type_saleorder']) ? 1 : 0,
            'file_type_invoice'     => isset($data['file_type_invoice']) ? 1 : 0,
        ];
        return FileType::create($preparedData);
    }

    public function update(array $data, int $id): void
    {
        $preparedData = [
            'view_in'               => $data['view_in'] ?? null,
            'file_type'             => $data['file_type'] ?? null,
            'file_type_opportunity' => isset($data['file_type_opportunity']) ? 1 : 0,
            'file_type_quote'       => isset($data['file_type_quote']) ? 1 : 0,
            'file_type_saleorder'   => isset($data['file_type_saleorder']) ? 1 : 0,
            'file_type_invoice'     => isset($data['file_type_invoice']) ? 1 : 0,
        ];
        FileType::query()
            ->findOrFail($id)
            ->update($preparedData);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function getFileTypesList($request)
    {
        $query = FileType::query();
        if (!empty($request->view_in_search) ) {
            $query->where('view_in', $request->view_in_search);
        }
        if (!empty($request->file_type_search) ) {
            $query->where('file_type', 'like', '%' . $request->file_type_search . '%');
        }
        return $query;
    }

    public function dataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName      = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue     = $searchArray['value'];
        $filetypes       = $this->getFileTypesList($request);
        $total           = $filetypes->count();
        $totalFilter     = $this->getFileTypesList($request);
        $totalFilter = $totalFilter->count();
        $arrData     = $this->getFileTypesList($request);
        $arrData     = $arrData->skip($start)->take($rowPerPage);
        $arrData     = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->view_in   = $value->view_in ?? '';
            $value->file_type = $value->file_type ?? '';
            $value->action    = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
