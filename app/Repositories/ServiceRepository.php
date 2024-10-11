<?php

namespace App\Repositories;

use App\Models\Service;
use App\Models\ServicePrice;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class ServiceRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    use ImageUploadTrait;

    public function findOrFail(int $id)
    {
        return Service::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $serviceData = $data['serviceData'];
        $priceData   = $data['priceData'];

        $service = Service::create($serviceData);

        $priceData['service_id'] = $service->id;
        ServicePrice::create($priceData);

        return $service;
    }

    public function update(array $data, int $id)
    {
        try {
            if ($id) {
                $data['service_id'] = 1;
                $servicePrice = ServicePrice::findOrFail($id);
                $servicePrice->update($data['priceData']);
            } else {
                $priceData['service_id'] = $service->id;
                ServicePrice::create($priceData);
            }
            \DB::beginTransaction();
            $service = Service::findOrFail($id);
            $service->update($data['serviceData']);
            \DB::commit();

            return $service;
        } catch (\Exception $e) {

            \DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getServiceList($request)
    {
       $query = ServicePrice::with(['service']);
        if (!empty($request->service_name_search)) {
            $query->whereHas('service', function ($q) use ($request) {
                if (!empty($request->service_name_search)) {
                        $q->where('service_name', (array)$request->service_name_search);
                }
                if (!empty($request->service_name_search)) {
                        $q->orWhere('service_sku', (array)$request->service_name_search);
                }
            });
        }

        if (!empty($request->service_price_search)) {
            $query->where('homeowner_price', 'like', '%' . $request->service_price_search . '%');
        }

        if (!empty($request->service_category_search)) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('service_category_id',  $request->service_category_search);
            });
        }
        if (!empty($request->service_type_search)) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('service_type_id',  $request->service_type_search);
            });
        }
        if (!empty($request->service_group_search)) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('service_group_id',  $request->service_group_search);
            });
        }
        if (!empty($request->service_uom_search)) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('unit_of_measure_id',  $request->service_uom_search);
            });
        }

        $services = $query->get();
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
        $service    = $this->getServiceList($request);
        $total      = $service->count();

        $totalFilter = $this->getServiceList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getServiceList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value, $i) {
            $value->sno                     = ++$i;
            $value->service_name            = "<a href='" . route('services.show', $value->service_id) . "' class='text-secondary'>" . ($value->service->service_name ?? '') . "</a>";
            $value->service_sku             = $value->service->service_sku ?? '';
            $value->service_category_id     = $value->service->service_categories->service_category ?? '';
            $value->service_type_id         = $value->service->service_types->service_type ?? '';
            $value->service_group_id        = $value->service->service_group->product_group_name ?? '';
            $value->homeowner_price         = '$'.($value->service->service_price->homeowner_price ?? '0.00');
            $value->unit_of_measure_id      = $value->service->unit_measures->unit_measure_name ?? '';
            $value->status                  = $value->service->status == 1 ? 'Active' : 'Inactive';
            $value->action = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow'
             data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'>
             <a class='dropdown-item showbtn text-warning' href='" . route('services.show', $value->service_id) . "' data-id='" . $value->service_id . "'><i class='bx bx-show me-1 icon-warning'></i> Show</a>
             <a class='dropdown-item editbtn text-success' href='" . route('services.edit', $value->service_id) . "' data-id='" . $value->service_id . "' ><i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a>
             </div></div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function updateImage(array $data, int $id)
    {
        $service = $this->findOrFail($id);
        if (isset($data['service_image']) && $data['service_image'] instanceof UploadedFile) {
            if ($service->service_image && Storage::disk('public')->exists($service->service_image)) {
                Storage::disk('public')->delete($service->service_image);
            }
            $data['service_image'] = $this->uploadImage($data['service_image'], Service::IMAGE_FOLDER);
        }
        $service->update($data);
        return $service;
    }

}
