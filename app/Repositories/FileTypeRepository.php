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
            'view_in' => $data['view_in'] ?? null,
            'file_type' => $data['file_type'] ?? null,
            'file_type_opportunity' => isset($data['file_type_opportunity']) ? 1 : 0,
            'file_type_quote' => isset($data['file_type_quote']) ? 1 : 0,
            'file_type_saleorder' => isset($data['file_type_saleorder']) ? 1 : 0,
            'file_type_invoice' => isset($data['file_type_invoice']) ? 1 : 0,
        ];
        return FileType::create($preparedData);
    }

    public function update(array $data, int $id): void
    {
        $preparedData = [
            'view_in' => $data['view_in'] ?? null,
            'file_type' => $data['file_type'] ?? null,
            'file_type_opportunity' => isset($data['file_type_opportunity']) ? 1 : 0,
            'file_type_quote' => isset($data['file_type_quote']) ? 1 : 0,
            'file_type_saleorder' => isset($data['file_type_saleorder']) ? 1 : 0,
            'file_type_invoice' => isset($data['file_type_invoice']) ? 1 : 0,
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
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowPerPage = $request->get("length");
        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue = $searchArray['value'];
        $filetypes = $this->getFileTypesList($request);
        $total = $filetypes->count();
        $totalFilter = $this->getFileTypesList($request);
        $totalFilter = $totalFilter->count();
        $arrData = $this->getFileTypesList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();
        $arrData->map(function ($value, $i) {
            $value->view_in = $value->view_in ?? '';
            $value->file_type = $value->file_type ?? '';
            $value->action = "<button type='button' data-id='" . $value->id . "' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button'
            data-id='" . $value->id . "'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i>
            </button>&nbsp;&nbsp;<button type='button' data-id='" . $value->id . "'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'>
            <i class='fas fa-trash-alt'></i></button>";
        });
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );
        return response()->json($response);
    }
}
