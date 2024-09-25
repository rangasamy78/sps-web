<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DatatableRepositoryInterface;

class CustomerRepository implements CrudRepositoryInterface, DatatableRepositoryInterface
{
    use ImageUploadTrait;
    public function findOrFail(int $id)
    {
        return Customer::query()
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $customerData = $this->__prepareCustomerData($data);
        $customer     = Customer::create($customerData);
        return $customer;
    }

    public function update(array $data, int $id)
    {
        $customer     = Customer::findOrFail($id);
        $customerData = $this->__prepareCustomerData($data);
        $customer->update($customerData);
        return $customer;
    }

    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'msg' => 'Customer deleted successfully.'], 200);
    }

    public function buildBaseQuery()
    {
        return Customer::query()
                ->with(['country','shipping_country','customer_type', 'parent_location', 'sales_person', 'secondary_sales_person', 'price_list_label','tax_exempt_reason']);
    }

    public function getCustomerList($request)
    {
        $query = $this->buildBaseQuery();

        $this->applyCustomerNameFilter($query, $request);
        $this->applyCustomerTypeFilter($query, $request);
        $this->applyCustomerAddressFilter($query, $request);
        $this->applyCustomerPhoneSearchFilter($query, $request);
        $this->applyLocationFilter($query, $request);
        $this->applyStatusFilter($query, $request);

        return $query;

        // if (!empty($request->customer_name)) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('customer_name', 'like', '%' . $request->customer_name . '%')
        //           ->orWhere('contact_name', 'like', '%' . $request->customer_name . '%')
        //           ->orWhere('code', 'like', '%' . $request->customer_name . '%')
        //           ->orWhere('dba', 'like', '%' . $request->customer_name . '%');
        //     });
        // }

        // if (!empty($request->customer_type_id)) {
        //     $query->whereHas('customer_type', function ($q) use ($request) {
        //         $q->where('id', $request->customer_type_id);
        //     });
        // }

        // if (!empty($request->customer_address)) {
        //     $query->where('address', 'like', '%' . $request->customer_address . '%');
        // }

        // if (!empty($request->customer_phone_search)) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('phone', 'like', '%' . $request->customer_phone_search . '%')
        //           ->orWhere('fax', 'like', '%' . $request->customer_phone_search . '%')
        //           ->orWhere('email', 'like', '%' . $request->customer_phone_search . '%');
        //     });
        // }

        // if (!empty($request->customer_type_id)) {
        //     $query->whereHas('customer_type', function ($q) use ($request) {
        //         $q->where('id', $request->customer_type_id);
        //     });
        // }

        // if (!empty($request->location_id)) {
        //     $query->whereHas('parent_location', function ($q) use ($request) {
        //         $q->where('id', $request->location_id);
        //     });
        // }

        // if (!empty($request->status)) {
        //     $query->where('status',  $request->status );
        // }
        // return $query;
    }

    protected function applyCustomerNameFilter($query, $request)
    {
        if (!empty($request->customer_name)) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->customer_name . '%')
                ->orWhere('contact_name', 'like', '%' . $request->customer_name . '%')
                ->orWhere('code', 'like', '%' . $request->customer_name . '%')
                ->orWhere('dba', 'like', '%' . $request->customer_name . '%');
            });
        }
    }

    protected function applyCustomerTypeFilter($query, $request)
    {
        if (!empty($request->customer_type_id)) {
            $query->whereHas('customer_type', function ($q) use ($request) {
                $q->where('id', $request->customer_type_id);
            });
        }
    }

    protected function applyCustomerAddressFilter($query, $request)
    {
        if (!empty($request->customer_address)) {
            $query->where('address', 'like', '%' . $request->customer_address . '%');
        }
    }

    protected function applyCustomerPhoneSearchFilter($query, $request)
    {
        if (!empty($request->customer_phone_search)) {
            $query->where(function ($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->customer_phone_search . '%')
                ->orWhere('fax', 'like', '%' . $request->customer_phone_search . '%')
                ->orWhere('email', 'like', '%' . $request->customer_phone_search . '%');
            });
        }
    }

    protected function applyLocationFilter($query, $request)
    {
        if (!empty($request->location_id)) {
            $query->whereHas('parent_location', function ($q) use ($request) {
                $q->where('id', $request->location_id);
            });
        }
    }

    protected function applyStatusFilter($query, $request)
    {
        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }
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
        $counties   = $this->getCustomerList($request);
        $total      = $counties->count();

        $totalFilter = $this->getCustomerList($request);
        $totalFilter = $totalFilter->count();

        $arrData = $this->getCustomerList($request);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        $arrData = $arrData->get();

        // dd($arrData);
        $arrData->map(function ($value, $i) {
            $value->customer_name            = $this->__formatCustomerParts($value);
            $value->customer_type_id    = $value->customer_type->customer_type_name ?? '';
            $value->address             = $value->address ?? '';
            $value->phone               = $this->__formatPhoneParts($value);
            $value->parent_location_id  = $value->parent_location->company_name ?? '';
            $value->sales_person_id     = $this->__formatSalesPersonParts($value);
            $value->price_list_label_id = isset($value->price_list_label) ? $value->price_list_label->price_code . '-' . $value->price_list_label->price_label : '';
            $value->sales_tax_id        = $value->sales_tax_id ?? '';
            $value->status              = $value->status !== 1 ? 'Inactive' : '';
            $value->image               = $this->__formatImageNoteParts($value);
            $value->action              = "<div class='dropup'>
                <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                    <i class='bx bx-dots-vertical-rounded icon-color'></i>
                </button>
                <div class='dropdown-menu'>
                    <a class='dropdown-item showbtn text-warning' href='" . route('customers.show', $value->id) . "'>
                        <i class='bx bx-show me-1 icon-warning'></i> Show
                    </a>
                    <a class='dropdown-item editbtn text-success' href='" . route('customers.edit', $value->id) . "'>
                        <i class='bx bx-edit-alt me-1 icon-success'></i> Edit
                    </a>
                    <a class='dropdown-item deletebtn text-danger' href='javascript:void(0);' data-id='" . $value->id . "'>
                        <i class='bx bx-trash me-1 icon-danger'></i> Delete
                    </a>
                </div>
            </div>";
        });

        $response = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFilter,
            "data"            => $arrData,
        );

        return response()->json($response);
    }

    private function __getCheckboxValue(array $data, string $key)
    {
        return isset($data[$key]) ? (int)$data[$key] : 0;
    }

    private function __prepareCustomerData(array $data)
    {
        return [
            'customer_name'                 => $data['customer_name'] ?? null,
            'customer_type_id'              => $data['customer_type_id'] ?? null,
            'contact_name'                  => $data['contact_name'] ?? null,
            'print_name'                    => $data['print_name'] ?? null,
            'parent_customer_id'            => $data['parent_customer_id'] ?? null,
            'referred_by_id'                => $data['referred_by_id'] ?? null,
            'phone'                         => $data['phone'] ?? null,
            'phone_2'                       => $data['phone_2'] ?? null,
            'mobile'                        => $data['mobile'] ?? null,
            'fax'                           => $data['fax'] ?? null,
            'email'                         => $data['email'] ?? null,
            'accounting_email'              => $data['accounting_email'] ?? null,
            'url'                           => $data['url'] ?? null,
            'address'                       => $data['address'] ?? null,
            'address_2'                     => $data['address_2'] ?? null,
            'city'                          => $data['city'] ?? null,
            'state'                         => $data['state'] ?? null,
            'zip'                           => $data['zip'] ?? null,
            'county'                        => $data['county'] ?? null,
            'country_id'                    => $data['country_id'] ?? null,
            'shipping_address'              => $data['shipping_address'] ?? null,
            'shipping_address_2'            => $data['shipping_address_2'] ?? null,
            'shipping_city'                 => $data['shipping_city'] ?? null,
            'shipping_state'                => $data['shipping_state'] ?? null,
            'shipping_zip'                  => $data['shipping_zip'] ?? null,
            'shipping_county'               => $data['shipping_county'] ?? null,
            'shipping_country_id'           => $data['shipping_country_id'] ?? null,
            'parent_location_id'            => $data['parent_location_id'] ?? null,
            'multi_location'                => $data['multi_location'] ?? null,
            'generic_customer'              => $data['generic_customer'] ?? null,
            'route_location_id'             => $data['route_location_id'] ?? null,
            'is_po_required'                => $this->__getCheckboxValue($data, 'is_po_required'),
            'apply_finance_charge'          => $this->__getCheckboxValue($data, 'apply_finance_charge'),
            'preferred_document_id'         => $data['preferred_document_id'] ?? null,
            'grace_period'                  => $data['grace_period'] ?? null,
            'hold_days'                     => $data['hold_days'] ?? null,
            'since_date'                    => $data['since_date'] ? Carbon::parse($data['since_date'])->format('Y-m-d') : null,
            'tax_number'                    => $data['tax_number'] ?? null,
            'sales_person_id'               => $data['sales_person_id'] ?? null,
            'secondary_sales_person_id'     => $data['secondary_sales_person_id'] ?? null,
            'price_list_label_id'           => $data['price_list_label_id'] ?? null,
            'is_tax_exempt'                 => $this->__getCheckboxValue($data, 'is_tax_exempt'),
            'tax_exempt_reason_id'          => $data['tax_exempt_reason_id'] ?? null,
            'sales_tax_id'                  => $data['sales_tax_id'] ?? null,
            'payment_terms_id'              => $data['payment_terms_id'] ?? null,
            'exempt_certificate_no'         => $data['exempt_certificate_no'] ?? null,
            'exempt_expiry_date'            => $data['exempt_expiry_date'] ? Carbon::parse($data['exempt_expiry_date'])->format('Y-m-d') : null,
            'about_us_option_id'            => $data['about_us_option_id'] ?? null,
            'project_type_id'               => $data['project_type_id'] ?? null,
            'end_use_segment_id'            => $data['end_use_segment_id'] ?? null,
            'default_fulfillment_method_id' => $data['default_fulfillment_method_id'] ?? null,
            'credit_limit'                  => $data['credit_limit'] ?? null,
            'is_credit_lock'                => $this->__getCheckboxValue($data, 'is_credit_lock'),
            'sales_alert_note'              => $data['sales_alert_note'] ?? null,
            'sales_lock_note'               => $data['sales_lock_note'] ?? null,
            'is_allow_login'                => $this->__getCheckboxValue($data, 'is_allow_login'),
            'username'                      => $data['username'] ?? null,
            'password'                      => $data['password'] ?? null,
            'delivery_instructions'         => $data['delivery_instructions'] ?? null,
            'collection_notes'              => $data['collection_notes'] ?? null,
            'internal_notes'                => $data['internal_notes'] ?? null,
            'is_copy_sale_order'            => $this->__getCheckboxValue($data, 'is_copy_sale_order'),
        ];
    }

    public function __formatPhoneParts($value)
    {
        $phoneParts = [];
        if (!empty($value->phone)) {
            $phoneParts[] = 'P: ' . $value->phone;
        }
        if (!empty($value->phone_2)) {
            $phoneParts[] = 'P1: ' . $value->phone_2;
        }
        if (!empty($value->fax)) {
            $phoneParts[] = 'F: ' . $value->fax;
        }
        if (!empty($value->mobile)) {
            $phoneParts[] = 'M: ' . $value->mobile;
        }
        if (!empty($value->email)) {
            $phoneParts[] = 'E: ' . $value->email;
        }
        if (!empty($value->accounting_email)) {
            $phoneParts[] = 'A.E: ' . $value->accounting_email;
        }
        return !empty($phoneParts) ? implode('<br>', $phoneParts) : '';
    }

    public function __formatCustomerParts($value)
    {
        $customerParts = [];
        if (!empty($value->customer_name)) {
            $customerParts[] = $value->customer_name;
        }
        if (!empty($value->print_name)) {
            $customerParts[] = 'DBA: ' . $value->print_name;
        }
        if (!empty($value->contact_name)) {
            $customerParts[] = 'C: ' . $value->contact_name;
        }

        return !empty($customerParts) ? implode('<br>', $customerParts) : '';
    }

    public function __formatSalesPersonParts($value)
    {
        $salesPersonParts = [];
        if (!empty($value->sales_person)) {
            $salesPersonParts[] = $value->sales_person->name."<sup>1</sup>";
        }
        if (!empty($value->secondary_sales_person)) {
            $salesPersonParts[] = $value->secondary_sales_person->name."<sup>2</sup>";
        }

        return !empty($salesPersonParts) ? implode('<br>', $salesPersonParts) : '';
    }

    public function __formatImageNoteParts($value)
    {
        $imageNoteParts = [];
        if (!empty($value->internal_notes)) {
            $imageNoteParts[] = '<img src="' . url('public\assets\img\icon-image\internal_notes.png') . '" width="20" height="20" alt="Image"/ title="'.$value->internal_notes.'">';
        }
        if (!empty($value->delivery_instructions)) {
            $imageNoteParts[] = '<img src="' . url('public\assets\img\icon-image\icon_freight.gif') . '" width="20" height="20" alt="Image"/ title="'.$value->delivery_instructions.'">';
        }
        if (!empty($value->sales_lock_note)) {
            $imageNoteParts[] = '<img src="' . url('public\assets\img\icon-image\icon_lockAlert.gif') . '" width="20" height="20" alt="Image"/ title="'.$value->sales_lock_note.'">';
        }
        return !empty($imageNoteParts) ? implode(' ', $imageNoteParts) : '';
    }

    public function updateImage(array $data, int $id)
    {
        $customer = $this->findOrFail($id);
        if (isset($data['customer_image']) && $data['customer_image'] instanceof UploadedFile) {
            if ($customer->customer_image && Storage::disk('public')->exists($customer->customer_image)) {
                Storage::disk('public')->delete($customer->customer_image);
            }
            $data['customer_image'] = $this->uploadImage($data['customer_image'], Customer::IMAGE_FOLDER);
        }
        $customer->update($data);

        return $customer;
    }

}
