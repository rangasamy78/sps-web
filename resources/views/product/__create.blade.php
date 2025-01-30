@extends('layouts.admin')

@section('title', 'Product')

@section('styles')
<style>
        .custom-alert {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: skyblue;
            color: black;
            padding: 20px;
            border: 1px solid #000;
            border-radius: 10px;
            z-index: 1000;
            text-align: center;
            width: 300px;
        }
        .custom-alert button {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            background-color: #000;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
<div class="custom-alert" id="customAlert">
        <p style="text-align:left">
            Alert! <br>
            This Item is being setup as 'Indivisible' and you will not be able to allocate or sell partial quantities of this item inventory.
            To turn this option off, please un-check the 'This Product is Indivisible' checkbox.
            Please contact SPS if you need any clarification about this feature.
        </p>
        <button id="okButton">OK</button>
    </div>
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Product / </span>Create</h4>
    <form id="productForm" name="productForm" class="form-horizontal"  enctype="multipart/form-data">
                <div class="row">
                  <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="Name">Name <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <input
                              type="text"
                              class="form-control"
                              id="product_name"
                              placeholder="Name"
                              name="product_name"
                              aria-label="Name" />
                              <span class="text-danger error-text product_name_error"></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="SKU">SKU
                            <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <input
                              type="text"
                              class="form-control"
                              id="product_sku"
                              placeholder="SKU"
                              name="product_sku"
                              aria-label="SKU" />
                              <span class="text-danger error-text product_sku_error"></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Kind">Kind
                            </label>
                            <select class="form-select select2" name="product_kind_id" id="product_kind_id" data-allow-clear="true">
                                <option value="">--Select Kind--</option>
                                  @foreach($product_kind as $kind)
                                  <option value="{{ $kind->id }}">{{ $kind->product_kind_name  }}</option>
                                  @endforeach
                            </select>
                            <span class="text-danger error-text product_kind_id_error"></span>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="Alternate Name">Alternate Name
                            </label>
                            <textarea
                              class="form-control"
                              id="product_alternate_name"
                              placeholder="Alternate Name"
                              name="product_alternate_name"
                              aria-label="Alternate Name" ></textarea>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Referred By">Type / Form
                            <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <select class="form-select select2" name="product_type_id" id="product_type_id" data-allow-clear="true" >
                                <option value="">--Select Type / Form--</option>
                                @foreach($product_type as $type)
                                  <option value="{{ $type->id }}">{{ $type->product_type }}</option>
                                  @endforeach
                            </select>
                            <span class="text-danger error-text product_type_id_error"></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Base Colors">Base Colors</label>
                            <select class="form-select select2" name="product_base_color_id" id="product_base_color_id" data-allow-clear="true">
                                <option value="">--Select Colors--</option>
                                @foreach($product_color as $color)
                                  <option value="{{ $color->id }}">{{ $color->product_color }}</option>
                                  @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Origin">Origin
                            </label>
                            <select class="form-select select2" name="product_origin_id" id="product_origin_id" data-allow-clear="true">
                                <option value="">--Select Origin--</option>
                                @foreach($country as $cntry)
                                  <option value="{{ $cntry->id }}">{{ $cntry->country_name }}</option>
                                  @endforeach
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="product_category_id">Category / Nature</label>
                            <select class="form-select select2" name="product_category_id" id="product_category_id" data-allow-clear="true">
                                <option value="">--Select Category / Nature--</option>
                                @foreach($product_category as $category)
                                    <option value="{{ $category->id }}">{{ $category->product_category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label class="form-label" for="product_sub_category_id">Sub Category</label>
                            <select class="form-select select2" name="product_sub_category_id" id="product_sub_category_id" data-allow-clear="true">
                                <option value="">--Select Sub Category--</option>
                            </select>
                        </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="Group">Group
                            </label>
                            <select class="form-select select2" name="product_group_id" id="product_group_id" data-allow-clear="true">
                                <option value="">--Select Group--</option>
                                @foreach($product_group as $group)
                                  <option value="{{ $group->id }}">{{ $group->product_group_name }}</option>
                                  @endforeach
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Thickness">Thickness
                            </label>
                            <select class="form-select select2" name="product_thickness_id" id="product_thickness_id" data-allow-clear="true">
                                <option value="">--Select Thickness--</option>
                                @foreach($product_thickness as $thickness)
                                  <option value="{{ $thickness->id }}">{{ $thickness->product_thickness_name }}</option>
                                  @endforeach
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Finish">Finish
                            </label>
                            <select class="form-select select2" name="product_finish_id" id="product_finish_id" data-allow-clear="true">
                                <option value="">--Select Finish--</option>
                                @foreach($product_finish as $finish)
                                  <option value="{{ $finish->id }}">{{ $finish->finish }}</option>
                                  @endforeach
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Internal Notes">Series Name
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="product_series_name"
                              placeholder="Series Name"
                              name="product_series_name"
                              aria-label="Series Name" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Units of Measure">Units of Measure <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <select class="form-select select2" name="unit_of_measure_id" id="unit_of_measure_id" data-allow-clear="true">
                                <option value="">--Select Units of Measure--</option>
                                @foreach($unit_measure as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                  @endforeach
                            </select>
                              <span class="text-danger error-text unit_of_measure_id_error"></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Weight">Weight</label>
                            <div class="input-group">
                          <input
                          type="text"
                          class="form-control"
                          id="product_weight"
                          placeholder="Weight"
                          name="product_weight"
                          aria-label="Weight" />

                        <span class="input-group-text">LBS</span>
                        <span class="text-danger error-text product_weight_error"></span>
                      </div>
                          </div>

                          <div class="col">
                            <label class="form-label" for="Size">Size
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="product_size"
                              placeholder="Size"
                              name="product_size"
                              aria-label="Size" />
                          </div>
                        </div>
                        <div class="row mb-3">
                        <div class="col">
                        <div class="col md-4">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="indivisible"  name="indivisible" value="1">
                            <label class="form-check-label" for="indivisible" style="color:red">
                              This product is Indivisible (Each detail line of this product received in a supplier
                              packing list
                              cannot be partially sold)
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="manufactured" name="manufactured" value="1">
                            <label class="form-check-label" for="manufactured">
                              This product is manufactured and not purchased from a supplier.
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="generic" name="generic" value="1">
                            <label class="form-check-label" for="generic">
                              This product is a generic product
                            </label>
                          </div>
                          <div class="form-check">

                            <input class="form-check-input" type="checkbox" id="select_slab" name="select_slab" value="1">
                            <label class="form-check-label" for="select_slab">
                              Allow customers to select exact slab for this item
                            </label>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">
                        Default Affected Accounts</h5>
                      </div>
                      <div class="card-body">
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="GL Inventory Link Account">GL Inventory Link Account <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <select class="form-select select2" name="gl_inventory_link_account_id" id="gl_inventory_link_account_id" data-allow-clear="true">
                                <option value="">--Select GL Inventory Link Account--</option>
                             
                                    @foreach($inventories as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                    @endforeach
                              </select>
                              <span class="text-danger error-text gl_inventory_link_account_id_error"></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="GL Income Account">GL Income Account <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <select class="form-select select2" name="gl_income_account_id" id="gl_income_account_id" data-allow-clear="true">
                                <option value="">--Select GL Income Account--</option>
                                @foreach($sales as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                    @endforeach
                            </select>
                            <span class="text-danger error-text gl_income_account_id_error"></span>
                          </div>
                          <div class="col">
                            <label class="form-label" for="GL Cost Of Goods Sold Account">GL Cost Of Goods Sold Account
                            <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                            <select class="form-select select2" name="gl_cogs_account_id" id="gl_cogs_account_id" data-allow-clear="true">
                                <option value="">--Select GL Cost Of Goods Sold Account--</option>
                                @foreach($cogs as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->account_number }}-{{ $acc->account_name }}</option>
                                    @endforeach
                            </select>
                              <span class="text-danger error-text gl_cogs_account_id_error"></span>
                          </div>
                          </div>
                          <div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">
                        Reorder Levels</h5>
                      </div>
                      <div class="card-body">
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Primary Phone">Safety Stock</label>
                            <input
                              type="text"
                              class="form-control"
                              id="safety_stock"
                              placeholder="Safety Stock"
                              name="safety_stock"
                              aria-label="Safety Stock" />
                              <label class="form-label sl_val" for="Name">&nbsp;</label>
                          </div>
                          <div class="col">
                            <label class="form-label" for="">&nbsp;</label>
                            <input
                              type="text"
                              class="form-control"
                              id="safety_stock_value"
                              name="safety_stock_value"
                              aria-label="" />
                          </div>
                          <div class="col">
                            <label class="form-label" for="Reorder Qty">Reorder Qty</label>
                            <input
                              type="text"
                              class="form-control"
                              id="reorder_qty"
                              placeholder="Reorder Qty"
                              name="reorder_qty"
                              aria-label="Reorder Qty" />
                              <label class="form-label sl_val" for="Name">&nbsp;</label>
                          </div>
                          <div class="col">
                            <label class="form-label" for="">&nbsp;</label>
                            <input
                              type="text"
                              class="form-control"
                              id="reorder_qty_value"
                              name="reorder_qty_value"
                              aria-label="" />
                          </div>
                        </div>
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Lead Time">Lead Time (months)
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="lead_time"
                              placeholder="Lead Time"
                              name="lead_time"
                              aria-label="Lead Time" />
                          </div>
                          <div class="col">
                            <label class="form-label" for="Mobile">Assigned Bin / A Frame
                            </label>
                            <select class="form-select select2" name="assign_bin_id" id="assign_bin_id" data-allow-clear="true">
                                <option value="">--Select Assigned Bin / A Frame--</option>
                                <option value="1">--Select--</option>
                            </select>
                          </div>
                          </div>
                          <div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">
                        Purchasing Info</h5>
                      </div>
                      <div class="card-body">
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Preferred Supplier">Preferred Supplier</label>
                            <select class="form-select select2" name="preferred_supplier_id" id="preferred_supplier_id" data-allow-clear="true">
                                  <option value="">--Select Preferred Supplier--</option>
                                  @foreach($supplier as $supply)
                                  <option value="{{ $supply->id }}">{{ $supply->supplier_name  }}</option>
                                  @endforeach
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Brand/Manufacturer">Brand/Manufacturer</label>
                            <select class="form-select select2" name="brand_or_manufacturer_id" id="brand_or_manufacturer_id" data-allow-clear="true">
                                <option value="">--Select Brand/Manufacturer--</option>
                                @foreach($supplier as $supply)
                                  <option value="{{ $supply->id }}">{{ $supply->supplier_name  }}</option>
                                  @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Mobile">Generic Name (Supplier's Name for this Product)
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="generic_name"
                              placeholder="Generic Name"
                              name="generic_name"
                              aria-label="Generic Name" />
                          </div>
                          <div class="col">
                            <label class="form-label" for="Generic SKU">Generic SKU (Supplier SKU)
                            </label>
                            <input
                              type="text"
                              class="form-control"
                              id="generic_sku"
                              placeholder="Generic SKU"
                              name="generic_sku"
                              aria-label="Generic SKU" />
                          </div></div>
                          <div class="row mb-3">
                      <div class="col">
                          <label class="form-label" for="">Purchasing Units
                          </label>
                          <select class="form-select select2" name="purchasing_unit_id" id="purchasing_unit_id" data-allow-clear="true">
                                <option value="">--Select Purchasing Units--</option>
                                @foreach($unit_measure as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                          <label class="form-label" for=""> &nbsp;
                          </label>
                          <input
                            type="text"
                            class="form-control"
                            id="purchasing_unit_cost"
                            placeholder=""
                            name="purchasing_unit_cost"
                            aria-label="" />
                            &nbsp;&nbsp;<span class="uom_vals"></span>
                            <span class="text-danger error-text purchasing_unit_cost_error"></span>
                        </div>
                        <div class="col">
                          <label class="form-label" for="Avg Est. Cost">Avg Est. Cost/
                          </label>
                          <input
                            type="text"
                            class="form-control"
                            id="avg_est_cost"
                            placeholder="Avg Est. Cost"
                            name="avg_est_cost"
                            aria-label="Avg Est. Cost" />
                            <span class="text-danger error-text avg_est_cost_error"></span>
                        </div>
                        </div>
                          <div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">
                        Website Module</h5>
                      </div>
                      <div class="card-body">
                        <div class="row mb-3">
                        <div class="col">

                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="new_product_flag" name="new_product_flag"  value="1">
                              <label class="form-check-label" for="new_product_flag">
                                New Product Flag
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="hide_on_website_or_guest_book" name="hide_on_website_or_guest_book" value="1">
                              <label class="form-check-label" for="hide_on_website_or_guest_book">
                                Hide On Website/ Guest Book
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                              <label class="form-check-label" for="is_featured">
                                Is Feature Product
                              </label>
                            </div>
                          </div>

                          <div class="col">
                            <label class="form-label" for="Web Use/Web Name">Web Use/Web Name</label>
                            <input
                              type="text"
                              class="form-control"
                              id="web_user_name"
                              placeholder="Web Use/Web Name"
                              name="web_user_name"
                              aria-label="Web Use/Web Name " />
                          </div>
                          <div class="col">
                            <label class="form-label" for="Mobile">Description On Website
                            </label>
                            <textarea
                              class="form-control"
                              id="description_on_web"
                              placeholder="Description On Website"
                              name="description_on_web"
                              aria-label="Description On Website" ></textarea>
                          </div>
                          </div>
                          <div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="Notes">Notes</label>
                            <textarea
                              class="form-control"
                              id="notes"
                              placeholder="Notes"
                              name="notes"
                              aria-label="Notes" ></textarea>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Special Instructions">Special Instructions</label>
                            <textarea
                              class="form-control"
                              id="special_intstruction"
                              placeholder="Special Instructions"
                              name="special_intstruction"
                              aria-label="Special Instructions" ></textarea>
                          </div>
                          <div class="col">
                            <label class="form-label" for="Mobile">Disclaimer
                            </label>
                            <textarea
                              class="form-control"
                              id="disclaimer"
                              placeholder="Disclaimer"
                              name="disclaimer"
                              aria-label="Disclaimer" ></textarea>
                          </div>
                        </div>
                  <div class="row mb-3">
                      <div class="col">
                        <label class="form-label" for="Mobile">Product Image</label>

                        <div class="button-wrapper d-flex align-items-center">
                          <!-- Upload button -->
                          <label for="image" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input
                                type="file"
                                id="image"
                                name="image"
                                class="account-file-input"
                                hidden
                                accept="image/png, image/jpeg, image/jpg" />
                          </label>
                          <p class="text-muted mb-3 ms-2">Allowed JPG, GIF, JPEG or PNG. Max size of 1024K</p>
                        </div>
                        <button type="button" class="btn btn-label-secondary account-image-reset mb-4" hidden>
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                        </button>

                        <span class="text-danger error-text image_error"></span>
                                <img
                                src="data:image/svg+xml, <svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'></svg>"
                                alt=""
                                class="d-block rounded"
                                height="100"
                                width="100"
                                id="uploadedAvatar" />
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
                          <label class="form-label" for="Homeowner Price">Homeowner Price($) <sup style="color:red; font-size: 0.9rem;"><strong>*</strong></label>
                          <input
                            type="text"
                            class="form-control"
                            id="homeowner_price"
                            placeholder="Homeowner Price"
                            name="homeowner_price"
                            aria-label="Homeowner Price" />
                            <span class="text-danger error-text homeowner_price_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Bundle Price">Bundle Price($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="bundle_price"
                            placeholder="Bundle Price"
                            name="bundle_price"
                            aria-label="Bundle Price" />
                            <span class="text-danger error-text bundle_price_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Special Price">Special Price($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="special_price"
                            placeholder="Special Price"
                            name="special_price"
                            aria-label="Special Price" />
                            <span class="text-danger error-text special_price_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Loose Slab Price Per SQFT">Loose Slab Price Per SQFT($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="loose_slab_price"
                            placeholder="Loose Slab Price Per SQFT"
                            name="loose_slab_price"
                            aria-label="Loose Slab Price Per SQFT" />
                            <span class="text-danger error-text loose_slab_price_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Bundle Price Per SQFT">Bundle Price Per SQFT($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="bundle_price_sqft"
                            placeholder="Bundle Price Per SQFT"
                            name="bundle_price_sqft"
                            aria-label="Bundle Price Per SQFT" />
                            <span class="text-danger error-text bundle_price_sqft_error"></span>

                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Special Price Per SQFT">Special Price Per SQFT($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="special_price_per_sqft"
                            placeholder="Special Price Per SQFT"
                            name="special_price_per_sqft"
                            aria-label="Special Price Per SQFT" />
                            <span class="text-danger error-text special_price_per_sqft_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Owner Approval Price Per SQFT">Owner Approval Price Per SQFT($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="owner_approval_price"
                            placeholder="Owner Approval Price Per SQFT"
                            name="owner_approval_price"
                            aria-label="Owner Approval Price Per SQFT" />
                            <span class="text-danger error-text owner_approval_price_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Loose Slab Price Per Slab">Loose Slab Price Per Slab($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="loose_slab_per_slab"
                            placeholder="Loose Slab Price Per Slab"
                            name="loose_slab_per_slab"
                            aria-label="Loose Slab Price Per Slab" />
                            <span class="text-danger error-text loose_slab_per_slab_error"></span>
                        </div> <div class="mb-3">
                          <label class="form-label" for="Bundle Price Per Slab">Bundle Price Per Slab($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="bundle_price_per_slab"
                            placeholder="Bundle Price Per Slab"
                            name="bundle_price_per_slab"
                            aria-label="Zip" />
                            <span class="text-danger error-text bundle_price_per_slab_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Special Price Per Slab">Special Price Per Slab($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="special_price_per_slab"
                            placeholder="Special Price Per Slab"
                            name="special_price_per_slab"
                            aria-label="Special Price Per Slab" />
                            <span class="text-danger error-text special_price_per_slab_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Owner Approval Price Per Slab">Owner Approval Price Per Slab($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="owner_approval_price_per_slab"
                            placeholder="Owner Approval Price Per Slab"
                            name="owner_approval_price_per_slab"
                            aria-label="" />
                            <span class="text-danger error-text owner_approval_price_per_slab_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Price12">Price12($)</label>
                          <input
                            type="text"
                            class="form-control"
                            id="price12"
                            placeholder="Price12"
                            name="price12"
                            aria-label="" />
                            <span class="text-danger error-text price12_error"></span>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="Country">Price Range</label>
                          <select class="form-select select2" name="price_range_id" id="price_range_id" data-allow-clear="true">
                            <option value="">--Select Price Range--</option>
                              @foreach($product_price_range as $price)
                              <option value="{{ $price->id }}">{{ $price->product_price_range }}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                    </div>


                    <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title mb-0">Alternate Units of Measure</h5>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <select class="form-select select2" name="uom_one_id" id="uom_one_id" data-allow-clear="true">
                          <option value="">--Select UOM--</option>
                          @foreach($unit_measure as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                      <input type="text"
                          class="form-control"
                          id="uom_one_value"
                          name="uom_one_value"
                          aria-label="" />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <select class="form-select select2" name="uom_two_id" id="uom_two_id" data-allow-clear="true">
                          <option value="">--Select UOM--</option>
                          @foreach($unit_measure as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                  @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                      <input type="text"
                          class="form-control"
                          id="uom_two_value"
                          name="uom_two_value"
                          aria-label="" />
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <select class="form-select select2" name="uom_three_id" id="uom_three_id" data-allow-clear="true">
                          <option value="">--Select UOM--</option>
                          @foreach($unit_measure as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                  @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                      <input type="text"
                          class="form-control"
                          id="uom_three_value"
                          name="uom_three_value"
                          aria-label="" />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <select class="form-select select2" name="uom_four_id" id="uom_four_id" data-allow-clear="true">
                        <option value="">--Select UOM--</option>
                        @foreach($unit_measure as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                  @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                      <input type="text"
                        class="form-control"
                        id="uom_four_value"
                        name="uom_four_value"
                        aria-label="" />
                      </div>
                    </div> <div class="row mb-3">
                      <div class="col-md-6">
                        <select class="form-select select2" name="uom_five_id" id="uom_five_id" data-allow-clear="true">
                          <option value="">--Select UOM Three--</option>
                          @foreach($unit_measure as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                  @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                      <input
                          type="text"
                          class="form-control"
                          id="uom_five_value"
                          name="uom_five_value"
                          aria-label="" />
                      </div>
                    </div> <div class="row mb-3">
                      <div class="col-md-6">
                        <select class="form-select select2" name="uom_six_id" id="uom_six_id" data-allow-clear="true">
                          <option value="">--Select UOM --</option>
                          @foreach($unit_measure as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                  @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                      <input type="text"
                      class="form-control"
                      id="uom_six_value"
                      name="uom_six_value"
                      aria-label="" />
                      </div>
                    </div>
                    <div class="card-header">
                      <h5 class="card-title mb-0">Minimum Picking Unit</h5>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <select class="form-select select2" name="minimum_packing_unit_id" id="minimum_packing_unit_id" data-allow-clear="true">
                          <option value="">--Select UOM --</option>
                          @foreach($unit_measure as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_measure_name }}</option>
                                  @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                      <input type="text"
                        class="form-control"
                        id="minimum_packing_unit_value"
                        name="minimum_packing_unit_value"
                        aria-label="" />
                        <span class="text-danger error-text minimum_packing_unit_value_error"></span>
                      </div>

                    </div>
                  </div>
                  </div>
                  </div>
                  <div class="form-group text-center">
              <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Product</button>
            </div>
        </div>
  </form>
  </div>
</div>
@endsection
@section('scripts')
@include('product.__scripts')
@endsection
