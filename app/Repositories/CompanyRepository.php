<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

Class CompanyRepository implements CrudRepositoryInterface, DatatableRepositoryInterface {
    use ImageUploadTrait;
    public function findOrFail(int $id)
    {
        return Company::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $data['logo'] = $this->uploadImage($data['logo'], 'images');
        }
        $data['is_bin_pre_defined'] = isset($data['is_bin_pre_defined']) ? 1 : 0;
        return Company::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $company = $this->findOrFail($id);
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $this->uploadImage($data['logo'], 'images');
        }
        $data['is_bin_pre_defined'] = isset($data['is_bin_pre_defined']) ? 1 : 0;
        return $company->update($data);
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getCompanyList()
    {
       $query = Company::query();
       return $query;
    }

    public function dataTable(Request $request) {
        $draw 				= 		$request->get('draw');
        $start 				= 		$request->get("start");
        $rowPerPage 		= 		$request->get("length");
        $orderArray 	    = 		$request->get('order');
        $columnNameArray 	= 		$request->get('columns');
        $searchArray 		= 		$request->get('search');
        $columnIndex 		= 		$orderArray[0]['column'];
        $columnName 		= 		$columnNameArray[$columnIndex]['data'];
        $columnSortOrder 	= 		$orderArray[0]['dir'];
        $searchValue 		= 		$searchArray['value'];

        $companies = $this->getCompanyList();
        $total = $companies->count();

        $totalFilter = $this->getCompanyList();
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('company_name','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = $this->getCompanyList();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('company_name','like','%'.$searchValue.'%');
        }
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno = ++$i;
            $value->company_name = $value->company_name ?? '';
            $value->action = "<button type='button' data-id='".$value->id."' class='p-2 m-0 btn btn-warning btn-sm showbtn'><i class='fa-regular fa-eye fa-fw'></i></button>&nbsp;&nbsp;<button type='button' data-id='".$value->id."'  name='btnEdit' class='editbtn btn btn-primary btn-sm p-2 m-0'><i class='fas fa-pencil-alt'></i></button>&nbsp;&nbsp;<button type='button' data-id='".$value->id."'  name='btnDelete' class='deletebtn btn btn-danger btn-sm p-2 m-0'><i class='fas fa-trash-alt'></i></button>";
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
