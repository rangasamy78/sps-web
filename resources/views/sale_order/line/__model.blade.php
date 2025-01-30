<div class="modal fade" id="lineModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form id="soProductForm" name="soProductForm" class="form-horizontal">
            {{-- <div class="form-group d-flex justify-content-end" style="margin-right: 3%;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_not_in_stock" name="is_not_in_stock">
                    <label class="form-check-label" for="is_not_in_stock">Is Not In Stock</label>
                </div>
            </div> --}}
            <div class="modal-body">
                    <input type="hidden" name="so_product_id" id="so_product_id">
                    <input type="hidden" name="so_line_id" id="so_line_id">
                    <input type="hidden" name="so_line_no" id="so_line_no">
                    <input type="hidden" name="line_item" id="line_item" value="1">
                    <input type="hidden" name="sales_order_id" id="sales_order_id" value="{{ $sale_order->id }}">
                    <div class="form-group mb-2 row">
                        <div class="col-12 col-md-4">
                            <label for="item_name" class="col-sm-2 form-label">Item </label>
                            <input type="text" class="form-control" id="item_name" name="item_name">
                            <span class="text-danger error-text item_name_error"></span>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity">
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <label for="unit_price" class="form-label">Unit Price</label>
                                <input type="number" class="form-control" id="unit_price" name="unit_price" >
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <label for="extended_amount" class="form-label">Extended</label>
                                <input type="number" class="form-control" id="extended_amount" name="extended_amount" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_not_in_stock" name="is_not_in_stock">
                                <label class="form-check-label" for="is_not_in_stock">Is Not In Stock</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-12 col-md-6">
                                <label for="item_description" class="col-sm-2 form-label">Description </label>
                                <span class="float-end me-3">
                                    <input class="form-check-input" type="checkbox" id="is_sold_as" name="is_sold_as">
                                    <label for="is_sold_as">Sold as</label>
                                </span>
                                <textarea class="form-control" id="item_description" name="item_description" rows="1" ></textarea>
                            <span class="text-danger error-text item_description_error"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="supplier_description" class="col-sm-4 form-label">Purchasing Note </label>
                            <input type="text" class="form-control" id="supplier_description" name="supplier_description" />

                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" id="is_taxable" name="is_taxable">
                                <label for="is_taxable">Tax</label>
                                <input class="form-check-input ms-3" type="checkbox" id="is_hideon_print" name="is_hideon_print">
                                <label for="is_hideon_print">Hide</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <div class="col-12 col-md-6">
                            <label for="is_taxable">Inventory Restriction</label>
                            <input class="form-check-input ms-3" type="radio" id="inventory_restriction_slab" name="pick_ticket_restriction" value="slab" checked>
                            <label for="inventory_restriction_slab">Slab</label>
                            <input class="form-check-input ms-2" type="radio" id="inventory_restriction_lot" name="pick_ticket_restriction" value="lot">
                            <label for="inventory_restriction_lot">Lot</label>
                            <input class="form-check-input ms-2" type="radio" id="inventory_restriction_product" name="pick_ticket_restriction" value="product">
                            <label for="inventory_restriction_product">Product</label>
                        </div>
                        <div class="col-12 col-md-6">

                            <div class=" text-end">
                                <button type="submit" class="btn btn-primary" id="soitemsavedata" value="create">Save & Close</button>
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <h5 class="modal-title">Inventory Search</h5>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-top-profile" role="tabpanel">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="form-label">Name/SKU</label>
                                        <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Location</label>
                                        <select class="form-select" id="search_location" name="search_location">
                                            <option></option>
                                            @foreach ($data['locations'] as $id=>$location_name )
                                            <option value="{{$id}}">{{$location_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Type</label>
                                        <select class="form-select" id="search_product_type" name="search_product_type">
                                            <option></option>
                                            @foreach ($data['productTypes'] as $id=>$product_type )
                                            <option value="{{$id}}">{{$product_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" id="search_category_type" name="search_category_type">
                                            <option></option>
                                            @foreach ($data['productCategories'] as $id=>$product_category_name )
                                            <option value="{{$id}}">{{$product_category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Group</label>
                                        <select class="form-select" id="search_group" name="search_group" data-allow-clear="true">
                                            <option></option>
                                            @foreach ($data['productGroups'] as $id=>$group_name )
                                            <option value="{{$id}}">{{$group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label class="form-label">Serial Num</label>
                                        <input type="text" class="form-control" id="search_serial_num" name="search_serial_num">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Lot/Block</label>
                                        <input type="text" class="form-control" id="search_lot_block" name="search_lot_block">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Bundle</label>
                                        <input type="text" class="form-control" id="search_bundle" name="search_bundle">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Supp. Ref</label>
                                        <input type="text" class="form-control" id="search_supp_ref" name="search_supp_ref">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Bin</label>
                                        <input type="text" class="form-control" id="search_bin" name="search_bin">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Barcode</label>
                                        <input type="text" class="form-control" id="search_barcode" name="search_barcode">
                                    </div>
                                </div>
                                <div class="form-group mb-2 row mt-3">
                                    <div class="col-12 col-md-6">
                                        <input class="form-check-input ms-3" type="checkbox" id="show_only_available" name="show_only_available" checked>
                                        <label for="is_taxable">Show Only Available</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class=" text-end">
                                            <button type="button" class="btn btn-primary" id="searchProductBtn" name="searchProductBtn">Search</button>
                                            <button type="button" class="btn btn-secondary reset_search">Reset Search</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-datatable table-responsive">
                                    <table class="datatables-basic table tables-basic border-top table-striped" id="searchProductsTable">
                                        <thead class="table-header-bold">
                                            <tr>
                                                <th>Name / SKU</th>
                                                <th>In Stock</th>
                                                <th>Available</th>
                                                <th>In Transit / On PO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultsTableBody">
                                            <!-- Rows will be dynamically appended here -->
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>




                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="serviceModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelServiceHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="serviceForm" name="serviceForm" class="form-horizontal">
                    <input type="hidden" name="so_line_id" id="so_line_id">
                    <input type="hidden" name="so_line_no" id="so_line_no">
                    <input type="hidden" name="line_item" id="line_item" value="2">
                    <input type="hidden" name="sales_order_id" id="sales_order_id" value="{{ $sale_order->id }}">
                    <div class="form-group mb-3">
                        <label for="item_id" class="col-sm-2 form-label">Service </label>
                        <div class="col-sm-12">
                            <select class="form-control" id="item_id" name="item_id">
                                <option value="">Select Service</option>
                                    @foreach($data['services'] as $id => $service_name)
                                    <option value="{{ $id }}">{{ $service_name }}</option>
                                    @endforeach
                            </select>
                            <span class="text-danger error-text item_id_error"></span>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="item_description" class="col-sm-2 form-label">Description </label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="item_description" name="item_description" rows="2" ></textarea>
                        </div>
                        <span class="text-danger error-text item_description_error"></span>
                    </div>
                    <div class="row" >
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="unit_price" class="form-label">Unit Price</label>
                                <input type="number" class="form-control" id="unit_price" name="unit_price" >
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="extended_amount" class="form-label">Extended</label>
                                <input type="number" class="form-control" id="extended_amount" name="extended_amount" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" id="is_taxable" name="is_taxable">
                                <label for="is_taxable">Taxable</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" id="is_sold_as" name="is_sold_as">
                                <label for="is_sold_as">Sold as</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" id="is_hideon_print" name="is_hideon_print">
                                <label for="is_hideon_print">Hide Line</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="servicedata" value="create">Save Service</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

