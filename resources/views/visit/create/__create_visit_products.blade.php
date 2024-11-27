@extends('layouts.admin')

@section('title', 'Create Visit')

@section('styles')
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
<style>
    .thin-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .thin-scrollbar::-webkit-scrollbar-thumb {
        background-color: #0d6efd;
        border-radius: 10px;
    }
</style>

@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 text-dark">Add Visit Product for Opportunity <span class="text-primary"> # {{$opportunity->opportunity_code}} </span></h4>
        <div class="app-ecommerce">
            <form id="visitProductForm">
                <div class="row">
                    <!-- first column -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="card mb-1">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <h5 class="card-title mb-0 fw-bold">
                                            <span class="text-dark fw-bold">Visit <span class="text-primary">#{{$opportunity->opportunity_code}}</span> {{$opportunity->ship_to_job_name}} </span><br>
                                        </h5>
                                        <div class="row p-1">
                                            <span style="font-size:9pt">{{$opportunity_date}}&nbsp;|&nbsp;{{$opportunity->ship_to_type}}</span>
                                        </div>
                                        <div class="row p-1">
                                            <span style="font-size:10pt">Price:<span class="text-dark fw-bold ms-3">{{$price_list->price_label}}-{{$price_list->price_code}}</span>
                                        </div>
                                        <div class="row p-1">
                                            <span style="font-size:10pt">Bill to:<span class="text-dark fw-bold ms-2">{{$customer->customer_name}}</span></span>
                                        </div>
                                        <div class="row p-1">
                                            <span style="font-size:10pt">Job:<span class="text-dark fw-bold ms-4">{{$opportunity->ship_to_job_name}}</span></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <h5 class="card-title mb-0 fw-bold">
                                            <span class="text-dark fw-bold">{{$company->company_name}} </span><br>
                                        </h5>

                                        <div class="row p-1">
                                            <span><img src="{{asset('public/images/PrimSales.png')}}" alt="image not found"><span class="text-dark fw-bold ms-4">{{$primary_sales->first_name}}{{$primary_sales->state}}</span></span>
                                        </div>
                                        <div class="row p-1">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('public/images/SecSales.png') }}" alt="Image not found">
                                                <select class="form-select ms-3 text-dark fw-bold">
                                                    <option value="">--select--</option>
                                                    @foreach ($data['users'] as $id => $name)
                                                    <option value="{{$id}}" {{ $secondary_sales && $secondary_sales->id == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row border-bottom border-dark"></div>
                            </div>

                            <div class="card-body">
                                <div class="row mb-1">
                                    <div class="col-sm-12 col-lg-6">
                                        <h6 class="text-primary fw-bold">Bill To</h6>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Attn</label>
                                                <input type="text" readonly class="form-control bg-label-secondary" value="{{$opportunity->attn}}">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-8">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Address</label>
                                                <input type="text" readonly class="form-control bg-label-secondary" value="{{$customer->address}}">
                                            </div>
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Suite / Unit#</label>
                                                <input type="text" readonly class="form-control bg-label-secondary" value="{{$customer->address_2}}">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">City</label>
                                                <input type="text" readonly class="form-control bg-label-secondary" value="{{$customer->city}}">
                                            </div>
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">State</label>
                                                <input type="text" readonly class="form-control bg-label-secondary" value="{{$customer->state}}">
                                            </div>
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Zip</label>
                                                <input type="text" readonly class="form-control bg-label-secondary" value="{{$customer->zip}}">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-8">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Email</label>
                                                <input type="text" readonly class="form-control bg-label-secondary" value="{{$customer->email}}">
                                            </div>
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Phone</label>
                                                <input type="text" readonly class="form-control bg-label-secondary" value="{{$customer->phone}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <h6 class="text-primary fw-bold">Ship To</h6>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="created_by" class="form-label" style="font-size:8pt">End Customer/Job Name</label>
                                                <input type="text" class="form-control" name="ship_to_job_name" id="ship_to_job_name" value="{{$opportunity->ship_to_job_name}}">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-8">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Address</label>
                                                <input type="text" class="form-control" name="ship_to_address" id="ship_to_address" value="{{$opportunity->ship_to_address}}">
                                            </div>
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Suite / Unit#</label>
                                                <input type="text" class="form-control" name="ship_to_suite" id="ship_to_suite" value="{{$opportunity->ship_to_suite}}">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">City</label>
                                                <input type="text" class="form-control" name="ship_to_city" id="ship_to_city" value="{{$opportunity->ship_to_city}}">
                                            </div>
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">State</label>
                                                <input type="text" class="form-control" name="ship_to_state" id="ship_to_state" value="{{$opportunity->ship_to_state}}">
                                            </div>
                                            <div class="col-4">
                                                <label for="created_by" class="form-label" style="font-size:8pt">Zip</label>
                                                <input type="text" class="form-control" name="ship_to_zip" id="ship_to_zip" value="{{$opportunity->ship_to_zip}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Append new Internal Notes for this Opportunity</label>
                                        <textarea class="form-control" rows="2" id="internal_notes" name="internal_notes">{{$opportunity->internal_notes}}</textarea>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Printed Notes</label>
                                        <textarea class="form-control mt-lg-3" rows="2" id="visit_printed_notes" name="visit_printed_notes">{{$visit->visit_printed_notes}}</textarea>
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
                                            <input type="hidden" class="form-control" id="visit_id" name="visit_id" value="{{$visit->id}}">
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
                                                    <tbody id="visit_service">
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
                                                    <tbody id="visit_product">
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
                                ({{ $taxCode->tax_code_label }} - {{ $taxAmount?->tax_code_total ?? '0' }}%):
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
                        </div>
                    </div>
                </div>
                <div class="row text-end mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary" id="saveVisitProductBtn" name="saveVisitProductBtn">Save Visit</button>
                        <button type="button" class="btn btn-secondary" id="cancelVisitProductBtn" name="cancelVisitProductBtn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- / Content -->
@include('visit.create.__model')
<div class="content-backdrop fade"></div>
</div>

@endsection
@section('scripts')
@include('visit.create.__script')
@endsection