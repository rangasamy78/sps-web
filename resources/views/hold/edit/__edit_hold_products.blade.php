@extends('layouts.admin')

@section('title', 'Create Hold')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 text-dark">Edit Product for Hold <span class="text-primary"> # {{$hold->hold_code}} </span></h4>
        <div class="app-ecommerce">
            <form id="holdProductForm">
                <div class="row">
                    <!-- first column -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h6 class="card-title mb-0 fw-bold">
                                            <span class="text-dark fw-bold">Hold <span class="text-primary">#{{$hold->hold_code}}</span>
                                        </h6>
                                        <div class="row p-1">
                                            <span style="font-size:9pt">{{ \Carbon\Carbon::parse($hold->hold_date . ' ' . $hold->hold_time)->format('M d, Y (h:i a)') }}</span>
                                            </span>
                                            @if(optional($opportunity)->opportunity_code)
                                            <span style="font-size:9pt"><span class="text-dark fw-bold">Created from Opportunity #</span>{{$opportunity->opportunity_code}}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4" style="font-size:10pt">
                                        <label>Location:</label>
                                        <div><span class="text-dark fw-bold">{{$company->company_name}}</span></div>
                                    </div>
                                    @if(optional($primary_sales)->first_name)
                                    <div class="col-lg-4" style="font-size:10pt">
                                        <label>Sales Rep:</label>
                                        <div><span class="text-dark fw-bold">{{$primary_sales->first_name??null}}-{{$primary_sales->last_name??null}}</span></div>
                                    </div>
                                    @endif
                                    @if(optional($paymentTerm)->payment_label)
                                    <div class="col-lg-4" style="font-size:10pt">
                                        <label>Payment Terms:</label>
                                        <div><span class="text-dark fw-bold">{{$paymentTerm->payment_label}}</span></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row mt-2">
                                    @if(optional($priceList)->price_level)
                                    <div class="col-lg-4" style="font-size:10pt">
                                        <label>Price Level</label>
                                        <div><span class="text-dark fw-bold">{{$priceList->price_level}}-{{$priceList->price_code}}</span></div>
                                    </div>
                                    @endif
                                    @if(optional($hold)->pick_ticket_restriction)
                                    <div class="col-lg-4" style="font-size:10pt">
                                        <label>PickTicket Restriction</label>
                                        <div><span class="text-dark fw-bold">{{$hold->pick_ticket_restriction}}</span></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row p-1">
                                    <div class="col-lg-6" style="font-size:10pt">
                                        <label class="text-primary fw-bold">Bill To</label>
                                        <div class="row">
                                            <div class="col"><span class="text-dark fw-bold">{{$customer->customer_name}}</span></div>
                                        </div>
                                        <div class="row">
                                            <span class="text-dark" style="font-size:9pt">{{$customer->address??''}}&nbsp;{{$customer->city??''}}&nbsp;{{$customer->state??''}}&nbsp;{{$customer->zip??''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" style="font-size:10pt">
                                        <label class="text-primary fw-bold">Job Name</label>
                                        <div class="row">
                                            <div class="col"><span class="text-dark fw-bold">{{$hold->job_name}}</span></div>
                                        </div>
                                        <div class="row">
                                            <span class="text-dark" style="font-size:9pt">{{$hold->address??''}}&nbsp;{{$hold->city??''}}&nbsp;{{$hold->state??''}}&nbsp;{{$hold->zip??''}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- add service -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card mb-1">
                                    <div class="card-header">
                                    </div>
                                    <div class="card-body">
                                        <div class="row mt-3">
                                            <input type="hidden" class="form-control" id="hold_id" name="hold_id" value="{{$hold->id}}">
                                            <input type="hidden" class="form-control" id="opportunity_id" name="opportunity_id" value="{{$opportunity->id}}">
                                            <div class="card-datatable table-responsive">
                                                <table class="datatables-basic table tables-basic border-top table-striped" id="">
                                                    <thead class="table-header-bold">
                                                        <tr>
                                                            <th>Service</th>
                                                            <th>Description</th>
                                                            <th>Quantity X Unit Price = Extended</th>
                                                            <th>Tax</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="hold_service">
                                                        @foreach ($holdServices as $holdService )
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" class="form-control" name="hold_service_id" id="hold_service_id" value="{{ $holdService->id }}">
                                                                <select class="form-control form-control-sm" name="service_id[]" style="width:150px">
                                                                    <option value="">Select Service</option>
                                                                    @foreach ($data['services'] as $id=>$service_name)
                                                                    <option value="{{$id}}" {{ $holdService && $holdService->service_id == $id ? 'selected' : '' }}>{{$service_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger error-text service_id_error"></span>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm" name="service_description[]" value="{{$holdService->service_description}}">
                                                                <span class="text-danger error-text service_description_error"></span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex p-1 gap-2">
                                                                    <input type="number" class="form-control form-control-sm service-quantity" name="service_quantity[]" style="width:50px" value="{{$holdService->service_quantity}}">
                                                                    <span class="text-dark fw-bold me-1" style="font-size:8pt; white-space: nowrap;">EA</span>
                                                                    <span class="text-dark fw-bold" style="font-size:8pt; white-space: nowrap;">x $</span>
                                                                    <input type="number" class="form-control form-control-sm service-unit-price" name="service_unit_price[]" style="width:50px" value="{{$holdService->service_unit_price}}">
                                                                    <span class="text-dark fw-bold" style="font-size:8pt; white-space: nowrap;">= $</span>
                                                                    <input type="number" class="form-control form-control-sm service-amount" readonly name="service_amount[]" style="width:50px" value="{{$holdService->service_amount}}">
                                                                </div>
                                                                <span class="text-danger error-text _error"></span>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input tax-check" value="1" name="is_tax[]" {{ isset($holdService->is_tax) && $holdService->is_tax ? 'checked' : '' }}>
                                                                <span class="text-danger error-text is_tax_error"></span>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-border p-0 d-flex align-items-center justify-content-center btnClear" style="width: 30px; height: 30px;" id="btnClear">
                                                                    <i class="fi fi-rr-cross text-danger fw-bold" style="font-size: 13px;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @for ($i=1;$i<=3;$i++)
                                                            <tr>
                                                            <td>
                                                                <select class="form-control form-control-sm" name="service_id[]" style="width:150px">
                                                                    <option value="">Select Service</option>
                                                                    @foreach ($data['services'] as $id=>$service_name)
                                                                    <option value="{{$id}}">{{$service_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger error-text service_id_error"></span>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm" name="service_description[]">
                                                                <span class="text-danger error-text service_description_error"></span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex p-1 gap-2">
                                                                    <input type="number" class="form-control form-control-sm service-quantity" name="service_quantity[]" style="width:50px">
                                                                    <span class="text-dark fw-bold me-1" style="font-size:8pt; white-space: nowrap;">EA</span>
                                                                    <span class="text-dark fw-bold" style="font-size:8pt; white-space: nowrap;">x $</span>
                                                                    <input type="number" class="form-control form-control-sm service-unit-price" name="service_unit_price[]" style="width:50px">
                                                                    <span class="text-dark fw-bold" style="font-size:8pt; white-space: nowrap;">= $</span>
                                                                    <input type="number" class="form-control form-control-sm service-amount" readonly name="service_amount[]" style="width:50px">
                                                                </div>
                                                                <span class="text-danger error-text _error"></span>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input tax-check" value="1" name="is_tax[]" data-id="">
                                                                <span class="text-danger error-text is_tax_error"></span>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-border p-0 d-flex align-items-center justify-content-center btnClear" style="width: 30px; height: 30px;" id="btnClear">
                                                                    <i class="fi fi-rr-cross text-danger fw-bold" style="font-size: 13px;"></i>
                                                                </button>
                                                            </td>
                                                            </tr>
                                                            @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- //end add service -->
                    </div>
                    <!-- /first column -->
                    <!-- second column -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="nav-align-top">
                                    <ul class="nav nav-pills mb-3" role="tablist">
                                        <li class="nav-item">
                                            <button
                                                type="button"
                                                class="nav-link active"
                                                role="tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-top-profile"
                                                aria-controls="navs-pills-top-profile"
                                                aria-selected="false">
                                                Search for Products
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button
                                                type="button"
                                                class="nav-link"
                                                role="tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-top-home"
                                                aria-controls="navs-pills-top-home"
                                                aria-selected="true">
                                                Search for Inventory
                                            </button>
                                        </li>

                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="navs-pills-top-profile" role="tabpanel">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">Name/SKU</label>
                                                    <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Type</label>
                                                    <select class="form-select" id="search_product_type" name="search_product_type">
                                                        <option></option>
                                                        @foreach ($data['productTypes'] as $id=>$product_type )
                                                        <option value="{{$id}}">{{$product_type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <label class="form-label">Category</label>
                                                    <select class="form-select" id="search_category_type" name="search_category_type">
                                                        <option></option>
                                                        @foreach ($data['productCategories'] as $id=>$product_category_name )
                                                        <option value="{{$id}}">{{$product_category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Preferred Supplier</label>
                                                    <select class="select2 form-select" id="search_supplier" name="search_supplier" data-allow-clear="true">
                                                        <option></option>
                                                        @foreach ($data['suppliers'] as $id=>$supplier_name )
                                                        <option value="{{$id}}">{{$supplier_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-primary" id="searchProductBtn" name="searchProductBtn">Search</button>
                                                    <button type="button" class="btn btn-secondary reset_search">Reset Search</button>
                                                </div>
                                            </div>
                                            <div class="card-datatable table-responsive mt-3">
                                                <table class="datatables-basic table tables-basic border-top table-striped" id="searchProductsTable">
                                                    <thead class="table-header-bold">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>SKU</th>
                                                            <th>Type</th>
                                                            <th>&nbsp;</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="resultsTableBody">
                                                        <!-- Rows will be dynamically appended here -->
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="navs-pills-top-home" role="tabpanel">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">Name/SKU</label>
                                                    <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Type</label>
                                                    <select class="form-select" id="search_product_type" name="search_product_type">
                                                        <option>--select--</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <label class="form-label">Location</label>
                                                    <select class="form-select" id="search_product_type" name="search_product_type">
                                                        <option>--select--</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">Serial Num</label>
                                                    <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku">
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">Barcode</label>
                                                    <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <label class="form-label">Lot/Block</label>
                                                    <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku">
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">Bundle</label>
                                                    <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku">
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">Bin</label>
                                                    <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-primary">Search</button>
                                                    <button type="button" class="btn btn-secondary">Reset Search</button>
                                                </div>
                                            </div>
                                            <div class="card-datatable table-responsive mt-2">
                                                <table class="datatables-basic table tables-basic border-top table-striped" id="">
                                                    <thead class="table-header-bold">
                                                        <tr>
                                                            <th>Name(SKU)</th>
                                                            <th>Available</th>
                                                            <th>Type</th>
                                                            <th>&nbsp;</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card mb-1">
                                    <div class="card-header">
                                    </div>
                                    <div class="card-body">
                                        <div class="row mt-3">
                                            <div class="card-datatable table-responsive">
                                                <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesAddVisitProduct">
                                                    <thead class="table-header-bold">
                                                        <tr>
                                                            <th>Item - Serial Num / Barcode Num / Lot/Block / Bundle / Supp. Ref</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Amount</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="hold_product">
                                                        @foreach ($holdProducts as $index => $holdProduct)
                                                        @php
                                                        $imageSrc = ($index === 0)
                                                        ? asset('public/images/import.png')
                                                        : asset('public/images/icon_import.png');
                                                        $class_name = ($index === 0) ? 'copy_all' : 'copy_down';
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" class="form-control" name="hold_product_id" id="hold_product_id" value="{{ $holdProduct->id }}">
                                                                <span style="font-size: 8pt;">{{ $holdProduct->product_name }}</span>
                                                                <div class="d-flex align-items-center mt-1">
                                                                    <input type="hidden" class="form-control" name="product_id[]" id="product_id[]" value="{{ $holdProduct->product_id }}">
                                                                    <input type="checkbox" class="form-check-input me-2" id="is_sold_as[]" value="1" name="is_sold_as[]"
                                                                        {{ isset($holdProduct->is_sold_as) && $holdProduct->is_sold_as ? 'checked' : '' }}>
                                                                    <label class="text-dark fw-bold me-2 mb-0" style="font-size: 7pt; white-space: nowrap;">Sold As:</label>
                                                                    <input type="text" class="form-control form-control-sm" value="{{ $holdProduct->product_description }}"
                                                                        id="product_description[]" name="product_description[]" style="width: 80px;">
                                                                </div>
                                                                <span class="text-danger error-text product_id_error"></span>
                                                            </td>

                                                            <td><input type="number" readonly class="form-control form-control-sm product-quantity" value="{{ $holdProduct->product_quantity }}" name="product_quantity[]" id="product_quantity[]" data-id="{{ $holdProduct->product_id }}" style="width: 80px;"></td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="me-1">$</span>
                                                                    <input type="number" class="form-control product-price form-control-sm"
                                                                        name="product_unit_price[]" id="product_unit_price[]"
                                                                        value="{{ $holdProduct->product_unit_price }}"
                                                                        data-id="{{ $holdProduct->product_id }}" style="width: 80px;">
                                                                    <img src="{{ asset('public/images/icon_additionalcharge.png') }}"
                                                                        class="me-1 product_price_list" alt="Image not found" style="width: 20px; height: 20px;"
                                                                        data-id="{{ $holdProduct->product_id }}" id="product_price_list">
                                                                    <img src="{{ $imageSrc }}" class="me-1 {{ $class_name }}"
                                                                        alt="Image not found" style="width: 20px; height: 20px;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="me-2">$</span>
                                                                    <input type="text" class="form-control form-control-sm product-amount"
                                                                        id="product_amount[]" name="product_amount[]"
                                                                        value="{{ $holdProduct->product_amount }}" readonly style="width: 60px;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-border p-0 d-flex align-items-center justify-content-center delete-hold-product" style="width: 30px; height: 30px;" value="{{ $holdProduct->id }}" data-id="{{ $holdProduct->id }}">
                                                                    <i class="fi fi-rr-cross-circle text-danger fw-bold fs-4"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /second column -->
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <label class="text-dark fw-bold mt-2">Sub Total:</label>
                            <span class="mt-2 ms-4 fw-bold" id="visit_sub_total">$</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <label class="text-dark fw-bold mt-2">
                                Tax
                                @if(!empty($taxCode?->tax_code_label))
                                ({{ $taxCode->tax_code_label }} - {{ $taxAmount->tax_code_total ?? '0' }}%):
                                @else
                                ()
                                @endif
                            </label>
                            <input type="hidden" readonly class="form-control  border-0 w-25" id="tax_code_amount" name="tax_code_amount" value="{{$taxAmount?->tax_code_total ?? '0' }}">
                            <span class="mt-2 ms-4 fw-bold" id="tax_code_amount_label">$</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <label class="text-dark fw-bold mt-2">Total:</label>
                            <span class="mt-2 ms-4 fw-bold" id="visit_total">$</span>
                            <input type="hidden" readonly class="form-control  border-0 w-25" id="total" name="total" value="">
                        </div>
                    </div>
                </div>
                <div class="row text-end mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary" id="saveHoldProductBtn" name="saveHoldProductBtn">Save Hold</button>
                        <button type="button" class="btn btn-secondary" id="cancelBtn" name="cancelBtn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- / Content -->
@include('hold.create.__model')
<div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@include('hold.create.__script_product')
@endsection