<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Associate;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class SaleOrderRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return SaleOrder::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return SaleOrder::query()
            ->create($data);
    }

    public function update(array $data, int $id)
    {
        $query = SaleOrder::query()
            ->findOrFail($id)
            ->update($data);
        return $query;
    }

    public function delete(int $id)
    {
        $query = $this->findOrFail($id)->delete();
        return $query;
    }

    public function getSalesOrderList($request)
    {
        $query = SaleOrder::with(['primary_user', 'secondary_user', 'customer'])
                            ->orderBy('id', 'desc');
        return $query;
    }

    function getAssociate($id)
    {
        $associate = Associate::find($id);
        return $id ? "$associate->associate_name" : 'N/A'; // E
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
        $SalesOrder   = $this->getSalesOrderList($request);
        $total      = $SalesOrder->count();

        $totalFilter = $this->getSalesOrderList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getSalesOrderList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->sales_order_code           = "<a href='" . route('sale_orders.show', $value->id) . "' class='text-secondary'>" . ($value->sales_order_code ?? '') . "</a>";
            $value->sales_order_date           = "<a href='" . route('sale_orders.show', $value->id) . "' class='text-secondary'>" . ($value->sales_order_date ?? '') . "</a>";
            $value->customer_po_code           = "<a href='" . route('sale_orders.show', $value->id) . "' class='text-secondary'>" . ($value->customer_po_code ?? '') . "</a>";
            $value->ship_to_job_name           = "<a href='" . route('sale_orders.show', $value->id) . "' class='text-secondary'>" . ($value->ship_to_job_name ?? '') . "</a>";
            $value->ship_to_type               = $value->ship_to_type;
            $value->requested_ship_date        = $value->requested_ship_date;
            $value->est_delivery_date          = $value->est_delivery_date;
            $value->billing_customer           = "<a href='" . route('sale_orders.show', $value->id) . "'class='text-secondary'>" . ($value->customer->customer_name ?? '') . "</a>";
            $value->location                   = "<a href='" . route('sale_orders.show', $value->id) . "'class='text-secondary'>" . (Company::find($value->customer->parent_location_id)->company_name ?? '') . "</a>";
            $value->sales_person = "<a href='" . route('sale_orders.show', $value->id) . "' class='text-secondary'><ul style='list-style-type: none; padding: 0; margin: 0;'><li><i class='fi fi-rr-user'></i> " . e($value->primary_user?->first_name ?? '') . "</li><li><i class='fi fi-rr-user'></i> " . e($value->secondary_user?->first_name ?? '') . "</li></ul></a>";
            $value->action                     = "<div class='dropup'><button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'><i class='bx bx-dots-vertical-rounded icon-color'></i></button><div class='dropdown-menu'><a class='dropdown-item showbtn text-warning' href='" . route('sale_orders.show', $value->id) . "' data-id='" . $value->id . "' ><i class='bx bx-show me-1 icon-warning'></i> Show</a><a class='dropdown-item editbtn text-success'  href='" . route('sale_orders.edit', $value->id) . "' data-id='" . $value->id . "' > <i class='bx bx-edit-alt me-1 icon-success'></i> Edit </a></div> </div>";
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    public function getCustomerList($request)
    {
        $query = Customer::query();
        if (!empty($request->customerName)) {
            $query->where('customer_name', 'like', '%' . $request->customerName . '%');
        }
        if (!empty($request->customerCode)) {
            $query->where('customer_code', 'like', '%' . $request->customerCode . '%');
        }
        if (!empty($request->contact)) {
            $query->where('phone', 'like', '%' . $request->contact . '%');
        }
        return $query;
    }

    public function dataTableAllCustomer(Request $request)
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
        $SalesOrder   = $this->getCustomerList($request);
        $total      = $SalesOrder->count();
        $totalFilter = $this->getCustomerList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getCustomerList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->id        = $value->id ?? '';
            $value->customer_name                = $value->customer_name ?? '';
            $value->customer_code                = $value->customer_code ?? '';
            $value->address                      = $value->address ?? '';
            $value->address_2                    = $value->address_2 ?? '';
            $value->city                         = $value->city ?? '';
            $value->zip                          = $value->zip ?? '';
            $value->country_id                   = $value->country_id ?? '';
            $value->fax                          = $value->fax ?? '';
            $value->phone                        = $value->phone ?? '';
            $value->mobile                       = $value->mobile ?? '';
            $value->email                        = $value->email ?? '';
            $value->price_list_label_id          = $value->price_list_label_id ?? '';
            $value->sales_person_id              = $value->sales_person_id ?? '';
            $value->secondary_sales_person_id    = $value->secondary_sales_person_id ?? '';
            $value->sales_tax_id                 = $value->sales_tax_id ?? '';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getAssociateList($request)
    {
        $query = Associate::query();
        if (!empty($request->associateName)) {
            $query->where('associate_name', 'like', '%' . $request->associateName . '%');
        }
        if (!empty($request->associateCode)) {
            $query->where('associate_code', 'like', '%' . $request->associateCode . '%');
        }
        if (!empty($request->contact)) {
            $query->where('primary_phone', 'like', '%' . $request->contact . '%');
        }
        return $query;
    }

    public function dataTableAllAssociate(Request $request)
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
        $SalesOrder   = $this->getAssociateList($request);
        $total      = $SalesOrder->count();
        $totalFilter = $this->getAssociateList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getAssociateList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        $arrData->map(function ($value) {
            $value->id                    = $value->id ?? '';
            $value->associate_name        = $value->associate_name ?? '';
            $value->associate_code        = $value->associate_code ?? '';
            $value->primary_phone                 = $value->phone ?? '';
            $value->address               = $value->address ?? '';
        });
        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );
        return response()->json($response);
    }

    public function getShipToList(Request $request, $id)
    {
        $query = Contact::join('customers', 'contacts.type_id', '=', 'customers.id')
            ->where('customers.id', $id)
            ->where('contacts.type', 'customer')
            ->where('contacts.is_ship_to_address', '=', 1)
            ->select(
                'customers.id',
                'customers.customer_name',
                'customers.customer_code',
                'customers.address',
                'contacts.contact_name',
                'contacts.id as contact_id',
                'contacts.tax_code_id'
            );

        if (!empty($request->name)) {
            $query->where('contacts.contact_name', 'like', '%' . $request->name . '%');
        }
        if (!empty($request->code)) {
            $query->where('customers.customer_code', 'like', '%' . $request->code . '%');
        }
        return $query->get();
    }


    public function dataTableAllShipTo(Request $request, $id)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'] ?? 'created_at';
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';
        $salesOrder = $this->getShipToList($request, $id);
        $total       = $salesOrder->count();
        $filteredData = $salesOrder->skip($start)->take($rowPerPage)->sortBy($columnName, SORT_REGULAR, $columnSortOrder === 'desc');
        $arrData = $filteredData->map(function ($value) {
            $value->id = $value->contact_id ?? '';
            $value->tax_code_id = $value->tax_code_id ?? '';
            $value->customer_name = ($value->customer_name ?? '') . ' ' . ($value->contact_name ?? '');
            $value->customer_name_1 = ($value->customer_name ?? '');
            $value->customer_code = $value->customer_code ?? '';
            $value->address = $value->address ?? '';
            return $value;
        });
        $response = [
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $arrData->values(),
        ];

        return response()->json($response);
    }
    public function getProductList($request)
    {
        $name = $request->get('name');
        $type = $request->get('type');
        $category = $request->get('category');
        $group = $request->get('group');
        $products = Product::with('product_type:id,product_type','product_item')->select('id','product_name', 'product_type_id');
        if (!empty($name)) {
            $products->where('product_name', 'LIKE', "%{$name}%");
        }
        if (!empty($type)) {
            $products->where('product_type_id', $type);
        }
        if (!empty($category)) {
            $products->where('product_category_id', $category);
        }
        if (!empty($group)) {
            $products->where('product_group_id', $group);
        }
        $products->whereHas('product_type', function ($query) {
            $query->where('product_type', 'slab');
        });
        return $products;
    }

    public function searchProductDataTable(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length");
        $orderArray      = $request->get('order');
        $columnNameArray = $request->get('columns');
        $columnIndex     = $orderArray[0]['column'] ?? '0';
        $columnName      = $columnNameArray[$columnIndex]['data'] ?? 'created_at';
        $columnSortOrder = $orderArray[0]['dir'] ?? 'desc';

        $query = $this->getProductList($request);
        $totalRecords = $query->count();
        $filteredData = $query
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data = $filteredData->map(function ($product) {
            return [
                'product_name' => $product->product_name ?? '',
                'product_sku'  => $product->product_sku ?? 'N/A',
                'type'         => $product->product_type->product_type ?? 'N/A',
                'icon' => '<img src="' . asset('public/images/icon_detail.gif') . '" class="me-1" alt="image not found" style="width: 20px; height: 20px;cursor: pointer;" onclick="window.location.href=\'' . route('products.show', $product->id) . '\'">',
            ];

        });
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data"            => $data,
        ]);
    }
}
