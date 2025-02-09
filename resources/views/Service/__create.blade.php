@extends('layouts.admin')

@section('title', 'Service')

@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Service / </span>Create</h4>
            <form id="serviceForm" name="serviceForm" class="form-horizontal">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Service information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Name">Name</label>
                                        <input type="text" class="form-control" id="service_name" placeholder="Name"
                                            name="service_name" aria-label="Name" />
                                        <span class="text-danger error-text service_name_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="SKU">SKU
                                        </label>
                                        <input type="text" class="form-control" id="service_sku" placeholder="SKU"
                                            name="service_sku" aria-label="SKU" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Units of Measure">Units of Measure</label>
                                        <select class="form-select select2" name="unit_of_measure_id"
                                            id="unit_of_measure_id" data-allow-clear="true">
                                            <option value="">--Select Units of Measure--</option>
                                            @foreach ($unit_measures as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text unit_of_measure_id_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="Referred By">Service Category
                                        </label>
                                        <select class="form-select select2" name="service_category_id"
                                            id="service_category_id" data-allow-clear="true">
                                            <option value="">--Select Category --</option>
                                            @foreach ($service_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->service_category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Referred By">Service Type
                                        </label>
                                        <select class="form-select select2" name="service_type_id" id="service_type_id"
                                            data-allow-clear="true">
                                            <option value="">--Select Type --</option>
                                            @foreach ($service_types as $type)
                                                <option value="{{ $type->id }}">{{ $type->service_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="Referred By">Service Group
                                        </label>
                                        <select class="form-select select2" name="service_group_id" id="service_group_id"
                                            data-allow-clear="true">
                                            <option value="">--Select Group --</option>
                                            @foreach ($product_groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->product_group_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="gl_sales_account_id">Sales/Income Account
                                        </label>
                                        <select class="form-select select2" name="gl_sales_account_id"
                                            id="gl_sales_account_id" data-allow-clear="true">
                                            <option value="">--Select Sales/Income Account--</option>
                                           
                                            @foreach($linked_accounts as $acc)
                                            <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text gl_sales_account_id_error"></span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="gl_cost_of_sales_account_id">Purchasing/Expense
                                            Account</label>
                                        <select class="form-select select2" name="gl_cost_of_sales_account_id"
                                            id="gl_cost_of_sales_account_id" data-allow-clear="true">
                                            <option value="">--Select Category / Nature--</option>
                                            @foreach($linked_accounts as $acc)
                                            <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text gl_cost_of_sales_account_id_error"></span>
                                    </div>

                                    <div class="col">
                                        <label class="form-label" for="expenditure_id">Preferred
                                            Expenditure</label>
                                        <select class="form-select select2" name="expenditure_id" id="expenditure_id"
                                            data-allow-clear="true">
                                            <option value="">--Select Expenditure--</option>
                                            @foreach ($service_expenditures as $type)
                                                <option value="{{ $type->id }}">{{ $type->expenditure_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="avg_est_cost">Avg. Est. Unit Cost</label>
                                        <input type="number" class="form-control" id="avg_est_cost" placeholder="$"
                                            name="avg_est_cost" aria-label="$" value="0.00" step="0.01" />
                                    </div>
                                    <div class="col mt-4">
                                        <label class="form-label mt-3" for="is_taxable_item">This Service is Taxable
                                        </label>&nbsp;
                                        <input class="form-check-input mt-3" type="checkbox" id="is_taxable_item"
                                            name="is_taxable_item" value="1">
                                    </div>
                                    <div class="col"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">Usage</h5>
                            </div>
                            <div class="card-body mb-5">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="col md-4">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="frequent_in_so"
                                                    name="frequent_in_so" value="1">
                                                <label class="form-check-label" for="frequent_in_so">
                                                    This service charge is frequently used in Sale Orders
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    id="frequent_in_customer_cm" name="frequent_in_customer_cm"
                                                    value="1">
                                                <label class="form-check-label" for="frequent_in_customer_cm">
                                                    This service charge is frequently used in Customer Creditmemos
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="frequent_in_po"
                                                    name="frequent_in_po" value="1">
                                                <label class="form-check-label" for="frequent_in_po">
                                                    This service charge is frequently used in POs
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="frequent_in_supplier_cm" name="frequent_in_supplier_cm"
                                                    value="1">
                                                <label class="form-check-label" for="frequent_in_supplier_cm">
                                                    This service charge is frequently used in Supplier Creditmemos
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-4">
                                    <div class="col-10">
                                        <label class="form-label" for="notes">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes" aria-label="Notes" style="line-height: 3;"
                                            placeholder="Notes"></textarea>
                                        <span class="text-danger error-text notes_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-10">
                                        <label class="form-label" for="internal_instruction">Special Instructions</label>
                                        <textarea class="form-control" id="internal_instruction" name="internal_instruction"
                                            aria-label="Special Instructions" style="line-height: 3;" placeholder="Special Instructions"></textarea>
                                        <span class="text-danger error-text notes_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-10">
                                        <label class="form-label" for="disclaimer">Disclaimer</label>
                                        <textarea class="form-control" id="disclaimer" name="disclaimer" aria-label="Disclaimer" style="line-height: 3;"
                                            placeholder="Disclaimer"></textarea>
                                        <span class="text-danger error-text disclaimer_error"></span>
                                    </div>
                                </div>
                            <div>
                            </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    Selling Prices</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="Homeowner Price">Homeowner Price</label>
                                    <input type="number" class="form-control" id="homeowner_price"
                                        placeholder="Homeowner Price" name="homeowner_price"
                                        aria-label="Homeowner Price" value="0.00" step="0.01" />
                                    <span class="text-danger error-text homeowner_price_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Bundle Price">Bundle Price</label>
                                    <input type="number" class="form-control" id="bundle_price"
                                        placeholder="Bundle Price" name="bundle_price" aria-label="Bundle Price" value="0.00" step="0.01" />
                                    <span class="text-danger error-text bundle_price_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Special Price">Special Price</label>
                                    <input type="number" class="form-control" id="special_price"
                                        placeholder="Special Price" name="special_price" aria-label="Special Price" value="0.00" step="0.01" />
                                    <span class="text-danger error-text special_price_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Loose Slab Price Per SQFT">Loose Slab Price Per
                                        SQFT</label>
                                    <input type="number" class="form-control" id="loose_slab_price"
                                        placeholder="Loose Slab Price Per SQFT" name="loose_slab_price"
                                        aria-label="Loose Slab Price Per SQFT" value="0.00" step="0.01" />
                                    <span class="text-danger error-text loose_slab_price_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Bundle Price Per SQFT">Bundle Price Per SQFT</label>
                                    <input type="number" class="form-control" id="bundle_price_sqft"
                                        placeholder="Bundle Price Per SQFT" name="bundle_price_sqft"
                                        aria-label="Bundle Price Per SQFT" value="0.00" step="0.01" />
                                    <span class="text-danger error-text bundle_price_sqft_error"></span>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Special Price Per SQFT">Special Price Per SQFT</label>
                                    <input type="number" class="form-control" id="special_price_per_sqft"
                                        placeholder="Special Price Per SQFT" name="special_price_per_sqft"
                                        aria-label="Special Price Per SQFT" value="0.00" step="0.01" />
                                    <span class="text-danger error-text special_price_per_sqft_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Owner Approval Price Per SQFT">Owner Approval Price Per
                                        SQFT</label>
                                    <input type="number" class="form-control" id="owner_approval_price"
                                        placeholder="Owner Approval Price Per SQFT" name="owner_approval_price"
                                        aria-label="Owner Approval Price Per SQFT" value="0.00" step="0.01" />
                                    <span class="text-danger error-text owner_approval_price_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Loose Slab Price Per Slab">Loose Slab Price Per
                                        Slab</label>
                                    <input type="number" class="form-control" id="loose_slab_per_slab"
                                        placeholder="Loose Slab Price Per Slab" name="loose_slab_per_slab"
                                        aria-label="Loose Slab Price Per Slab" value="0.00" step="0.01" />
                                    <span class="text-danger error-text loose_slab_per_slab_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Bundle Price Per Slab">Bundle Price Per Slab</label>
                                    <input type="number" class="form-control" id="bundle_price_per_slab"
                                        placeholder="Bundle Price Per Slab" name="bundle_price_per_slab"
                                        aria-label="Zip" value="0.00" step="0.01" />
                                    <span class="text-danger error-text bundle_price_per_slab_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Special Price Per Slab">Special Price Per Slab</label>
                                    <input type="number" class="form-control" id="special_price_per_slab"
                                        placeholder="Special Price Per Slab" name="special_price_per_slab"
                                        aria-label="Special Price Per Slab" value="0.00" step="0.01" />
                                    <span class="text-danger error-text special_price_per_slab_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Owner Approval Price Per Slab">Owner Approval Price Per
                                        Slab</label>
                                    <input type="number" class="form-control" id="owner_approval_price_per_slab"
                                        placeholder="Owner Approval Price Per Slab" name="owner_approval_price_per_slab"
                                        aria-label="" value="0.00" step="0.01" />
                                    <span class="text-danger error-text owner_approval_price_per_slab_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Price12">Price12</label>
                                    <input type="number" class="form-control" id="price12" placeholder="Price12"
                                        name="price12" aria-label="" value="0.00" step="0.01" />
                                    <span class="text-danger error-text price12_error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Country">Price Range</label>
                                    <select class="form-select select2" name="price_range_id" id="price_range_id"
                                        data-allow-clear="true">
                                        <option value="">--Select Price Range--</option>
                                        @foreach ($product_price_ranges as $price)
                                            <option value="{{ $price->id }}">{{ $price->product_price_range }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" id="savedata" value="create">Save
                            Service</button>
                        <button type="reset" class="btn btn-label-secondary">Discard</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @include('service.__scripts')
@endsection
