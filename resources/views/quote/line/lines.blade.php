<div class="tab-pane fade show active" id="lines" role="tabpanel">
    <h5 class="">Lines</h5>
    <div class="row">
        <input type="text" class="form-control" hidden name="opportunity_id" id="opportunity_id" value="{{ $opportunity->id }}">
    </div>
    <table class="datatables-basic table tables-basic border-top table-striped" id="quoteLinesDatatable">
        <thead class="table-header-bold">
            <tr>
                <th>Sl.No.</th>
                <th>SubHeading/Item/Service</th>
                <th>SKU</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Fulfilled</th>
                <th>Balance</th>
                <th>Unit Price</th>
                <th>Extended</th>
                <th>Tax </th>
                <th>Hide</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="row mt-3">
        <div class="col">
            <div class="d-flex justify-content-end">
                <label class="text-dark fw-bold mt-2">Sub Total:</label>
                <span class="mt-2 ms-4 fw-bold" id="line_sub_total">$</span>
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
                <span class="mt-2 ms-4 fw-bold" id="line_total">$</span>
            </div>
        </div>
    </div>
    <div id="receive_deposit"> </div>
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-end">
                <label class="text-dark fw-bold mt-2 ">Balance Due:</label>
                <span class="mt-2 ms-4 fw-bold" id="balance_due">$</span>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 text-end">
            <button
                type="button"
                class="btn btn-primary btn-sm"
                id="addLine"
                onclick="window.location.href='{{ route('quote.receive_index', $quote->id) }}'">
                Receive Deposit
            </button>
        </div>
    </div>
</div>

<!-- offcanvas for add item-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="itemOffcanvas" aria-labelledby="quoteProductLabel">
    <div class="offcanvas-header">
        <h5 id="offCanvasHeading" class="offcanvas-title">Add Item</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form id="addQuoteProductForm" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" readonly class="form-control" id="quote_id" name="quote_id" value="{{$quote->id}}">
                <input type="hidden" readonly class="form-control" id="quote_item_id" name="quote_item_id" value="">
                <div class="col">
                    <label class="form-label">Item <sup style="color:red; font-size: 0.8rem;"><strong>*</strong></label>
                    <input type="text" readonly class="form-control quoteProductName" id="product_name" name="product_name" data-bs-toggle="modal" data-bs-target="#searchQuoteProduct">
                    <input type="hidden" readonly class="form-control quoteProductId" id="product_id" name="product_id">
                    <span class="text-danger error-text product_id_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label" for="description">Description</label>
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" value="1" id="is_sold_as" name="is_sold_as">
                            <label class="form-check-label" for="soldAsCheckbox">Sold As</label>
                            <span class="text-danger error-text is_sold_as_error"></span>
                        </div>
                    </div>
                    <textarea type="text" class="form-control" rows="2" id="description" name="description"></textarea>
                    <span class="text-danger error-text description_error"></span>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <label class="form-label">Quantity <sup style="color:red; font-size: 0.8rem;"><strong>*</strong></label>
                    <div class="d-flex">
                        <input type="number" class="form-control value_cal" id="product_quantity" name="product_quantity">
                        <label class="text-dark fw-bold p-1">SF</label>
                    </div>
                    <span class="text-danger error-text product_quantity_error"></span>
                </div>
                <div class="col-6">
                    <label class="form-label">Unit Price <sup style="color:red; font-size: 0.8rem;"><strong>*</strong></label>
                    <div class="d-flex">
                        <input type="number" class="form-control value_cal quoteProductUnitPrice" id="product_unit_price" name="product_unit_price">
                        <span class="p-1"><i class="fi fi-rr-dollar text-dark fw-bold "></i></span>
                    </div>
                    <span class="text-danger error-text product_unit_price_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Extended <sup style="color:red; font-size: 0.8rem;"><strong>*</strong></label>
                    <div class="d-flex justify-content-end gap-2">
                        <input type="text" class="form-control" readonly id="product_amount" name="product_amount">
                        <div class="form-check">
                            <input class="form-check-input ms-1" type="checkbox" value="1" id="is_tax" name="is_tax">
                            <label class="form-check-label" for="is_tax">Taxable</label>
                        </div>
                    </div>
                    <span class="text-danger error-text product_amount_error"></span>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label">Supplier / Purchasing Note</label>
                        <div class="form-check d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input me-2" type="checkbox" value="1" id="is_hide_line" name="is_hide_line">
                                <label class="form-check-label" for="soldAsCheckbox"> Hide Line</label>
                            </div>
                        </div>
                    </div>
                    <textarea type="text" class="form-control" id="notes" name="notes"></textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Inventory Restriction</label>
                    <div class="d-flex flex-wrap text-dark fw-bold" style="font-size:10pt">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" checked name="inventory_restriction" id="inlineRadio1" value="exact_slab">
                            <label class="form-check-label" for="inlineRadio1">Exact Slab</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inventory_restriction" id="inlineRadio2" value="within_lot">
                            <label class="form-check-label" for="inlineRadio2">Within Lot</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inventory_restriction" id="inlineRadio3" value="within_product">
                            <label class="form-check-label" for="inlineRadio3">Within Product</label>
                        </div>
                    </div>
                    <span class="text-danger error-text inventory_restriction_error"></span>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-primary" id="saveQuoteProduct" name="saveQuoteProduct">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end offcanvas of add item -->

<!-- offcanvas for add services-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="serviceOffcanvas" aria-labelledby="quoteServiceLabel">
    <div class="offcanvas-header">
        <h5 id="serviceOffCanvasHeading" class="offcanvas-title">Add Services</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form id="addQuoteServiceForm" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" readonly class="form-control" id="quote_id" name="quote_id" value="{{$quote->id}}">
                <input type="hidden" readonly class="form-control" id="quote_service_id" name="quote_service_id" value="">
                <div class="col">
                    <label class="form-label">Service <sup style="color:red; font-size: 0.8rem;"><strong>*</strong></label>
                    <input type="text" readonly class="form-control" id="service_name" name="service_name" data-bs-toggle="modal" data-bs-target="#searchQuoteService">
                    <input type="hidden" readonly class="form-control" id="service_id" name="service_id">
                    <span class="text-danger error-text service_id_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label" for="description">Description</label>
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" value="1" id="is_sold_as" name="is_sold_as">
                            <label class="form-check-label" for="soldAsCheckbox">Sold As</label>
                        </div>
                    </div>
                    <textarea type="text" class="form-control" rows="2" id="description" name="description"></textarea>
                    <span class="text-danger error-text description_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <label class="form-label">Quantity <sup style="color:red; font-size: 0.8rem;"><strong>*</strong></label>
                    <div class="d-flex">
                        <input type="number" class="form-control service_total" id="service_quantity" name="service_quantity">
                        <label class="text-dark fw-bold p-1">EA</label>
                    </div>
                    <span class="text-danger error-text service_quantity_error"></span>
                </div>
                <div class="col-6">
                    <label class="form-label">Unit Price <sup style="color:red; font-size: 0.8rem;"><strong>*</strong></label>
                    <div class="d-flex">
                        <input type="number" class="form-control service_total" id="service_unit_price" name="service_unit_price">
                        <span class="p-1"><i class="fi fi-rr-dollar text-dark fw-bold "></i></span>
                    </div>
                    <span class="text-danger error-text service_unit_price_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label class="form-label">Extended <sup style="color:red; font-size: 0.8rem;"><strong>*</strong></label>
                    <div class="d-flex justify-content-end gap-2">
                        <input type="text" class="form-control" readonly id="service_amount" name="service_amount">
                        <input class="form-check-input ms-1" type="checkbox" value="1" id="is_tax" name="is_tax">
                        <label class="form-label">Taxable</label>
                    </div>
                    <span class="text-danger error-text service_amount_error"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" value="1" id="is_hide_line" name="is_hide_line">
                            <label class="form-check-label" for="soldAsCheckbox"> Hide Line</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-primary" id="saveQuoteService" name="saveQuoteService">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end offcanvas of add services -->
<!-- pop up product -->
<div class="modal fade" id="searchQuoteProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">List of Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row accountFilter">
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Name:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" name="productNameFilter" id="productNameFilter" data-allow-clear="true" placeholder="Search by Product Name">
                    </div>
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Code:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" id="codeFilter" name="codeFilter" data-allow-clear="true" placeholder="Search by Product Code">
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="quoteProductListTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Name</th>
                                <th>Code</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- end pop up product -->

<!-- pop up service -->
<div class="modal fade" id="searchQuoteService" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">List of Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row accountFilter">
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Name:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" name="serviceNameFilter" id="serviceNameFilter" data-allow-clear="true" placeholder="Search by Service Name">
                    </div>
                    <div class="col-lg-4 col-sm-6 filter-input mb-2">
                        <label class="mb-2 fw-bold">Code:</label>
                        <input type=" text" class="form-control dt-input dt-full-name" id="serviceCodeFilter" name="serviceCodeFilter" data-allow-clear="true" placeholder="Search by Service Code">
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="quoteServiceListTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Name</th>
                                <th>Code</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- end pop up service -->

<!-- pop up add option line item -->
<div class="modal fade" id="addOptionLineItemModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">Option Lines for <span class="text-dark fw-dark" id="quoteProductName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Name/SKU</label>
                        <input type="text" class="form-control" id="search_product_name_sku" name="search_product_name_sku" placeholder="Enter Name/SKU">
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Type</label>
                        <select class="form-select select2" id="search_product_type" name="search_product_type" data-allow-clear="true">
                            <option value="">--select--</option>
                            @foreach ($data['productTypes'] as $id => $product_type )
                            <option value="{{$id}}">{{$product_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Price Range</label>
                        <select class="form-select select2" id="search_price_range" name="search_price_range" data-allow-clear="true">
                            <option value="">--select--</option>
                            @foreach ($data['productPriceRange'] as $id => $product_price_range )
                            <option value="{{$id}}">{{$product_price_range}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Category</label>
                        <select class="form-select select2" id="search_category_type" name="search_category_type" data-allow-clear="true">
                            <option value="">--select--</option>
                            @foreach ($data['productCategories'] as $id => $product_category_name )
                            <option value="{{$id}}">{{$product_category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Sub Category</label>
                        <select class="form-select select2" id="search_sub_category" name="search_sub_category" data-allow-clear="true">
                            <option value="">--select--</option>
                            @foreach ($data['productSubCategory'] as $id => $product_sub_category_name )
                            <option value="{{$id}}">{{$product_sub_category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Group</label>
                        <select class="form-select select2" id="search_group" name="search_group" data-allow-clear="true">
                            <option value="">--select--</option>
                            @foreach ($data['productGroup'] as $id => $product_group_name )
                            <option value="{{$id}}">{{$product_group_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-4">
                        <div class="d-flex justify-content-end mt-1 gap-3">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                Reset
                            </button>
                            <button type="button" class="btn btn-primary" name="searchProductBtn" id="searchProductBtn">Search Product</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="optionLineItemTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Group</th>
                                <th>Price Range</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
                <!-- //selected product list -->
                <form id="optionLineProductForm">
                    <div class="row mt-3">
                        <h6 class="text-dark fw-bold">Selected Options</h6>
                        <input type="hidden" class="form-control" name="quote_option_line_product_id" id="quote_option_line_product_id">
                        <input type="hidden" class="form-control" name="quote_product_id" id="quote_product_id">
                        <div class="card-datatable table-responsive">
                            <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesAddVisitProduct">
                                <thead class="table-header-bold">
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="option_line_quote_product">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" name="saveQuoteOptionLineProduct" id="saveQuoteOptionLineProduct">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end pop up add option line item -->
<!-- pop up add option line service -->
<div class="modal fade" id="addOptionLineServiceModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">Option Lines for <span class="text-dark fw-dark" id="quoteServiceName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Name/SKU</label>
                        <input type="text" class="form-control" id="search_service_name_sku" name="search_service_name_sku" placeholder="Enter Name/SKU">
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Type</label>
                        <select class="form-select select2" id="search_service_type" name="search_service_type" data-allow-clear="true">
                            <option value="">--select--</option>
                            @foreach ($data['serviceType'] as $id => $service_type )
                            <option value="{{$id}}">{{$service_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Price Range</label>
                        <select class="form-select select2" id="search_price_range" name="search_price_range" data-allow-clear="true">
                            <option value="">--select--</option>
                            @foreach ($data['productPriceRange'] as $id => $product_price_range )
                            <option value="{{$id}}">{{$product_price_range}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label class="form-label">Category</label>
                        <select class="form-select select2" id="search_category_type" name="search_category_type" data-allow-clear="true">
                            <option value="">--select--</option>
                            @foreach ($data['serviceCategory'] as $id => $service_category )
                            <option value="{{$id}}">{{$service_category}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div class="d-flex justify-content-end mt-1 gap-3">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Reset</button>
                            <button type="button" class="btn btn-primary" name="searchServiceBtn" id="searchServiceBtn">Search Service</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table border-top table-striped" id="optionLineServiceTable">
                        <thead class="table-header-bold">
                            <tr class="text-nowrap">
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>
                </div>
                <!-- //selected product list -->
                <form id="optionLineServiceForm">
                    <div class="row mt-3">
                        <h6 class="text-dark fw-bold">Selected Options</h6>
                        <input type="hidden" class="form-control" name="quote_service_id" id="quote_product_id">
                        <div class="card-datatable table-responsive">
                            <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesAddVisitProduct">
                                <thead class="table-header-bold">
                                    <tr>
                                        <th>Service</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="option_line_quote_service">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" name="saveQuoteOptionLineService" id="saveQuoteOptionLineService">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end pop up add option line service -->
<!-- pop up Price Calculator from cost product -->
<div class="modal fade" id="addProductPriceCalculatorModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">Price Calculator from Cost - <span class="text-dark fw-dark" id="productPriceCalculatorName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productPriceCalculatorForm">
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table border-top table-striped" id="">
                            <thead class="table-header-bold">
                                <tr class="text-nowrap">
                                    <th>Supplier</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Unit Cost</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="radio" class="form-check-input" id="supplier_radio" name="supplier_selection">
                                            <select class="form-select w-50 search_supplier" id="supplier_id" name="supplier_id">
                                                <option value="0">--select--</option>
                                                @foreach ($data['supplier'] as $id => $supplier_name )
                                                <option value="{{$id}}">{{$supplier_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text supplier_id_error"></span>
                                        </div>
                                    </td>
                                    <td><span id="phone"></span></td>
                                    <td><span id="email"></span></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1"><i class="fi fi-rr-dollar"></i>
                                            <input type="text" class="form-control form-control-sm unit_cost w-50" name="supplier_unit_cost" id="supplier_unit_cost">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- //selected product list -->
                    <div class="row mt-3">
                        <input type="hidden" class="form-control" name="quote_product_id" id="quote_product_id">
                        <div class="card-datatable table-responsive">
                            <table class="datatables-basic table tables-basic border-top table-striped" id="datatablesAddVisitProduct">
                                <thead class="table-header-bold">
                                    <tr>
                                        <th>Serial Num</th>
                                        <th>Lot/Block</th>
                                        <th>Bundle</th>
                                        <th>Len x Wid</th>
                                        <th>Slabs</th>
                                        <th>Area</th>
                                        <th>Unit Cost</th>
                                        <th>Extended</th>
                                        <th>Note</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="product_price_calculator">
                                    <tr>
                                        <td><input type="text" class="form-control form-control-sm" name="serial_number[]" id="serial_number[]"></td>
                                        <td><input type="text" class="form-control form-control-sm" name="lot_name[]" id="lot_name[]"></td>
                                        <td><input type="text" class="form-control form-control-sm" name="bundle[]" id="bundle[]"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control form-control-sm" name="length[]" id="length[]">
                                                <span class="mx-1" style="font-size:8pt">X</span>
                                                <input type="text" class="form-control form-control-sm" name="width[]" id="width[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1 text-primary fw-bold">
                                                <i class="fi fi-rr-minus" style="cursor: pointer;"></i>
                                                <input type="number" class="form-control form-control-sm" name="slabs[]" id="slabs[]" value="1">
                                                <i class="fi fi-rr-plus" style="cursor: pointer;"></i>
                                            </div>
                                        </td>
                                        <td><input type="text" class="form-control form-control-sm" readonly name="area[]" id="area[]"></td>
                                        <td><input type="text" class="form-control form-control-sm" name="unit_cost[]" id="unit_cost[]"></td>
                                        <td><input type="text" class="form-control form-control-sm" readonly name="amount[]" id="amount[]"></td>
                                        <td><input type="text" class="form-control form-control-sm" name="notes[]" id="notes[]"></td>
                                        <td>
                                            <div class="d-flex gap-2 text-danger fw-bold" style="font-size:9pt"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- //selected product list -->
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-primary btn-sm" id="add_row">Add More Lines</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="total_cost" class="text-dark fw-bold">Subtotal</label>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <!-- <label class="text-dark fw-bold">Area:</label> -->
                            <input type="text" class="form-control form-control-sm w-50" readonly id="subtotal_area">
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" readonly id="subtotal_extended">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="total_cost" class="text-dark form-label fw-bold">Markup Multiplier:</label>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm w-50" id="markup_multiplier" name="markup_multiplier">
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" id="total_markup_multiplier" name="total_markup_multiplier">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2">
                            <label for="total_cost" class="text-dark form-label fw-bold">Tax:</label>
                        </div>
                        <div class="col-4">
                            <select class="form-select w-75" id="tax_id" name="tax_id">
                                <option value="0">--select--</option>
                                @foreach ($data['salesTaxs'] as $id=> $tax_name)
                                <option value="{{$id}}">{{$tax_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <input type="text" class="form-control form-control-sm w-50" id="tax_amount">
                            <label>%</label>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" readonly id="total_tax_amount">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-8">
                            <label for="total_cost" class="text-dark form-label fw-bold">Additional Charges:</label>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" id="additional_charges" name="additional_charges">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-8">
                            <label for="total_cost" class="text-dark form-label fw-bold">Delivery/Freight Charges:</label>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" id="delivery_charges" name="delivery_charges">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-8">
                            <label for="total_cost" class="text-dark form-label fw-bold">Total Cost: ( Clear all Costs )</label>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" readonly id="total_cost" name="total_cost">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-sm btn-dark btn-sm" id="copy_total">Copy Total Cost into Item Charges</button>

                        </div>
                    </div>
                    <div id="warning-message"></div>
                    <div class="row border-bottom mt-2 border-dark"></div>
                    <h5 class="mt-2 text-dark fw-bold">Quoted Price</h5>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="total_cost" class="text-dark form-label fw-bold">Product Charges</label>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <input type="text" class="form-control form-control-sm w-50" readonly id="product_charges">
                            <span class="uom"></span>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" id="product_charges_amount">
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm w-50" id="product_charges_total">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="total_cost" class="text-dark form-label fw-bold">Fab/Other</label>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <input type="text" class="form-control form-control-sm w-50" readonly id="fab_other" name="fab_other">
                            <span class="uom"></span>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" id="fab_other_amount" name="fab_other_amount">
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm w-50" id="fab_other_total" name="fab_other_total">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="total_cost" class="text-dark form-label fw-bold">Total Price: ( Clear all Prices )</label>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <input type="text" class="form-control form-control-sm w-50" readonly id="total_quote_slab" name="total_quote_slab">
                            <span class="uom"></span>
                        </div>
                        <div class="col-2 d-flex gap-2">
                            <label>$</label>
                            <input type="text" class="form-control form-control-sm w-50" id="total_quote_price" name="total_quote_price">
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm w-50" id="quote_total" name="quote_total">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="total_cost" class="text-dark form-label fw-bold">Wastage</label>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm w-50" id="wastage_amount" name="wastage_amount">
                        </div>
                        <div class="col-2 d-flex gap-1">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <input type="text" class="form-control form-control-sm w-50" id="wastage_percentage" name="wastage_percentage">
                            <label>%</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-7">
                            <label for="total_cost" class="text-dark form-label fw-bold">Internal Notes</label>
                            <textarea class="form-control" name="internal_notes" id="internal_notes" placeholder="Enter Internal Notes"></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" name="savePriceCalculatorBtn" id="savePriceCalculatorBtn">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end pop up Price Calculator from cost product -->