<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Models\PrePurchaseRequestFile;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class PrePurchaseRequestFileRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    use ImageUploadTrait;

    public function findOrFail(int $id)
    {
        return PrePurchaseRequestFile::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        foreach ($data['images'] as $image) {
            PrePurchaseRequestFile::create([
                'user_id' => $data['user_id'],
                'pre_purchase_request_id'  => $data['pre_purchase_request_id'],
                'images'  =>  $this->uploadImage($image, PrePurchaseRequestFile::IMAGE_FOLDER)
            ]);
        }
        return true;
    }

    public function update(array $data, int $id)
    {
        $query = $this->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getPrePurchaseRequestFileList($request)
    {
        $query = PrePurchaseRequestFile::query()->where('pre_purchase_request_id', $request->id)->with(['user']);
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

        $columnName = 'created_at';
        $counties   = $this->getPrePurchaseRequestFileList($request);
        $total      = $counties->count();

        $totalFilter = $this->getPrePurchaseRequestFileList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getPrePurchaseRequestFileList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno          = ++$i;
            $value->images        = $value->images ?? '';
            $value->title        = $value->images ?? '';
            $value->notes        = $value->notes ?? '';
            $value->user_name    = $value->user->full_name ?? '';
            $value->created_date = $value->created_at ? toDbDateTimeDisplay($value->created_at) : '';
            $value->action       = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item fileseditbtn text-success' href='javascript:void(0);' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a><a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "' ><i class='bx bx-trash me-1 icon-danger'></i> Delete</a> </div> </div>";
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
