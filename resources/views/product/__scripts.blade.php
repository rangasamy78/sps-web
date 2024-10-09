<script type="text/javascript">
    $(function() {

        var table;
        var stocktable;
        var ptable;
        var cptable;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productNameFilter,#productTypeFilter, #productCategoryFilter, #productSubCategoryFilter, #productGroupFilter,#productThicknessFilter,#productOriginFilter, #priceRangeFilter').on('keyup change', function(e) {

            e.preventDefault();
            if (table) {
            table.draw();
            }
            if (stocktable) {
                stocktable.draw();
            }
            if (ptable) {
                ptable.draw();
            }
            if (cptable) {
                cptable.draw();
            }
        });


        $(document).ready(function() {
        table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('products.list') }}",
            data: function(d) {
                d.product_name_search = $('#productNameFilter').val();
                d.product_type_search = $('#productTypeFilter').val();
                d.product_category_search = $('#productCategoryFilter').val();
                d.product_sub_category_search = $('#productSubCategoryFilter').val();
                d.product_group_search = $('#productGroupFilter').val();
                d.product_thickness_search = $('#productThicknessFilter').val();
                d.price_origin_search = $('#productOriginFilter').val();
                d.price_range_search = $('#priceRangeFilter').val();
                sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                d.order = [{
                    column: 1,
                    dir: sort
                }];
            }
        },
        columns: [
            {
                data: null,
                name: 'serial',
                orderable: false,
                searchable: false
            },
            {
                data: 'product_name',
                name: 'product_name'
            },
            {
                data: 'product_sku',
                name: 'product_sku'
            },
            {
                data: 'product_kind_id',
                name: 'product_kind_id'
            },
            {
                data: 'product_type_id',
                name: 'product_type_id'
            },
            {
                data: 'product_category_id',
                name: 'product_category_id'
            },
            {
                data: 'product_sub_category_id',
                name: 'product_sub_category_id'
            },
            // {
            //     data: 'product_group_id',
            //     name: 'product_group_id'
            // },
            {
                data: 'product_origin_id',
                name: 'product_origin_id'
            },
            {
                data: 'preferred_supplier_id',
                name: 'preferred_supplier_id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        rowCallback: function(row, data, index) {
            $('td:eq(0)', row).html(table.page.info().start + index + 1);
        },
        dom: '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
        {
            text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Product</span>',
            className: 'create-new btn btn-primary me-2',
            attr: {
                id: 'createProduct',
            },
            action: function(e, dt, node, config) {
                    window.location.href = "{{ route('products.create') }}";
                }
        },
        {
            text: '<span class="d-none d-sm-inline-block">All</span>',
            className: 'btn btn-secondary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.index') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Stock Product</span>',
            className: 'btn btn-dark me-2',
            attr: {
                id: 'stockProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.stock') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Price List</span>',
            className: 'btn btn-info me-2',
            attr: {
                id: 'pricelistProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.price_list_product') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Customer Price List</span>',
            className: 'btn btn-success me-2',
            attr: {
                id: 'customerProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.customer_price_list_product') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Search</span>',
            className: 'btn btn-warning',
            attr: {
                id: 'searchProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.product_search') }}";
            }
        }
    ]

    });
});

$(document).ready(function() {
        stocktable = $('#Stockdatatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('products.stock_list') }}",
            data: function(d) {
                d.product_name_search = $('#productNameFilter').val();
                d.product_type_search = $('#productTypeFilter').val();
                d.product_category_search = $('#productCategoryFilter').val();
                d.product_sub_category_search = $('#productSubCategoryFilter').val();
                d.product_group_search = $('#productGroupFilter').val();
                d.product_thickness_search = $('#productThicknessFilter').val();
                d.price_origin_search = $('#productOriginFilter').val();
                d.price_range_search = $('#priceRangeFilter').val();
                sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                d.order = [{
                    column: 1,
                    dir: sort
                }];
            }
        },
        columns: [
            {
                data: null,
                name: 'serial',
                orderable: false,
                searchable: false
            },
            {
                data: 'product_name',
                name: 'product_name'
            },
            {
                data: 'product_sku',
                name: 'product_sku'
            },
            {
                data: 'product_kind_id',
                name: 'product_kind_id'
            },
            {
                data: 'product_type_id',
                name: 'product_type_id'
            },
            {
                data: 'product_category_id',
                name: 'product_category_id'
            },
            {
                data: 'product_sub_category_id',
                name: 'product_sub_category_id'
            },
            {
                data: 'product_group_id',
                name: 'product_group_id'
            },
            {
                data: 'product_origin_id',
                name: 'product_origin_id'
            },
            {
                data: 'preferred_supplier_id',
                name: 'preferred_supplier_id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        rowCallback: function(row, data, index) {
            $('td:eq(0)', row).html(stocktable.page.info().start + index + 1);
        },
        dom: '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
        {
            text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Product</span>',
            className: 'create-new btn btn-primary me-2',
            attr: {
                id: 'createProduct',
            },
            action: function(e, dt, node, config) {
                    window.location.href = "{{ route('products.create') }}";
                }
        },
        {
            text: '<span class="d-none d-sm-inline-block">All</span>',
            className: 'btn btn-secondary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.index') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Stock Product</span>',
            className: 'btn btn-dark me-2',
            attr: {
                id: 'stockProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.stock') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Price List</span>',
            className: 'btn btn-info me-2',
            attr: {
                id: 'pricelistProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.price_list_product') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Customer Price List</span>',
            className: 'btn btn-success me-2',
            attr: {
                id: 'customerProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.customer_price_list_product') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Search</span>',
            className: 'btn btn-warning',
            attr: {
                id: 'searchProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "#";
            }
        }
    ]
    });
});

$(document).ready(function() {
        ptable = $('#PriceListdatatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('products.price_list_product_list') }}",
            data: function(d) {
                d.product_name_search = $('#productNameFilter').val();
                d.product_type_search = $('#productTypeFilter').val();
                d.product_category_search = $('#productCategoryFilter').val();
                d.product_sub_category_search = $('#productSubCategoryFilter').val();
                d.product_group_search = $('#productGroupFilter').val();
                d.product_thickness_search = $('#productThicknessFilter').val();
                d.price_origin_search = $('#productOriginFilter').val();
                d.price_range_search = $('#priceRangeFilter').val();
                sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                d.order = [{
                    column: 1,
                    dir: sort
                }];
            }
        },
        columns: [
            {
                data: null,
                name: 'serial',
                orderable: false,
                searchable: false
            },
            {
                data: 'product_name',
                name: 'product_name'
            },
            {
                data: 'product_sku',
                name: 'product_sku'
            },
            {
                data: 'product_category_id',
                name: 'product_category_id'
            },
            {
                data: 'product_sub_category_id',
                name: 'product_sub_category_id'
            },
            {
                data: 'product_type_id',
                name: 'product_type_id'
            },
            {
                data: 'product_group_id',
                name: 'product_group_id'
            },
            {
                data: 'preferred_supplier_id',
                name: 'preferred_supplier_id'
            },
            {
                data: 'homeowner_price',
                name: 'homeowner_price'
            },
            {
                data: 'bundle_price',
                name: 'bundle_price'
            },
            {
                data: 'special_price',
                name: 'special_price'
            },
            {
                data: 'loose_slab_price',
                name: 'loose_slab_price'
            },
            {
                data: 'bundle_price_sqft',
                name: 'bundle_price_sqft'
            },
            {
                data: 'special_price_per_sqft',
                name: 'special_price_per_sqft'
            },
            {
                data: 'owner_approval_price',
                name: 'owner_approval_price'
            },
            {
                data: 'loose_slab_per_slab',
                name: 'loose_slab_per_slab'
            },
            {
                data: 'bundle_price_per_slab',
                name: 'bundle_price_per_slab'
            },
            {
                data: 'special_price_per_slab',
                name: 'special_price_per_slab'
            },
            {
                data: 'owner_approval_price_per_slab',
                name: 'owner_approval_price_per_slab'
            },
            {
                data: 'price12',
                name: 'price12'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        rowCallback: function(row, data, index) {
            $('td:eq(0)', row).html(ptable.page.info().start + index + 1);
        },
        dom: '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
        {
            text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Product</span>',
            className: 'create-new btn btn-primary me-2',
            attr: {
                id: 'createProduct',
            },
            action: function(e, dt, node, config) {
                    window.location.href = "{{ route('products.create') }}";
                }
        },
        {
            text: '<span class="d-none d-sm-inline-block">All</span>',
            className: 'btn btn-secondary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.index') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Stock Product</span>',
            className: 'btn btn-dark me-2',
            attr: {
                id: 'stockProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.stock') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Price List</span>',
            className: 'btn btn-info me-2',
            attr: {
                id: 'pricelistProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.price_list_product') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Customer Price List</span>',
            className: 'btn btn-success me-2',
            attr: {
                id: 'customerProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.customer_price_list_product') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Search</span>',
            className: 'btn btn-warning',
            attr: {
                id: 'searchProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "#";
            }
        }
    ]
    });
});

$(document).ready(function() {
        cptable = $('#customerPriceListdatatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('products.customer_price_list_product_list') }}",
            data: function(d) {
                d.product_name_search = $('#productNameFilter').val();
                d.product_type_search = $('#productTypeFilter').val();
                d.product_category_search = $('#productCategoryFilter').val();
                d.product_sub_category_search = $('#productSubCategoryFilter').val();
                d.product_group_search = $('#productGroupFilter').val();
                d.product_thickness_search = $('#productThicknessFilter').val();
                d.price_origin_search = $('#productOriginFilter').val();
                d.price_range_search = $('#priceRangeFilter').val();
                sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                d.order = [{
                    column: 1,
                    dir: sort
                }];
            }
        },
        columns: [
            {
                data: null,
                name: 'serial',
                orderable: false,
                searchable: false
            },
            {
                data: 'product_name',
                name: 'product_name'

            },
            {
                data: 'product_sku',
                name: 'product_sku'

            },
             {
                data: 'product_type_id',
                name: 'product_type_id'

            },
            {
                data: 'product_kind_id',
                name: 'product_kind_id'
            },
            {
                data: 'product_category_id',
                name: 'product_category_id'
            },
            {
                data: 'product_sub_category_id',
                name: 'product_sub_category_id'
            },
            {
                data: 'product_group_id',
                name: 'product_group_id'
            },
            {
                data: 'preferred_supplier_id',
                name: 'preferred_supplier_id'
            },
            {
                data: 'product_group_id',
                name: 'product_group_id'
            },
            {
                data: 'product_origin_id',
                name: 'product_origin_id'
            },
            {
                data: 'preferred_supplier_id',
                name: 'preferred_supplier_id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        rowCallback: function(row, data, index) {
            $('td:eq(0)', row).html(cptable.page.info().start + index + 1);
        },
        dom: '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-10 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
        {
            text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Product</span>',
            className: 'create-new btn btn-primary me-2',
            attr: {
                id: 'createProduct',
            },
            action: function(e, dt, node, config) {
                    window.location.href = "{{ route('products.create') }}";
                }
        },
        {
            text: '<span class="d-none d-sm-inline-block">All</span>',
            className: 'btn btn-secondary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.index') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Stock Product</span>',
            className: 'btn btn-dark me-2',
            attr: {
                id: 'stockProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.stock') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Price List</span>',
            className: 'btn btn-info me-2',
            attr: {
                id: 'pricelistProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.price_list_product') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Customer Price List</span>',
            className: 'btn btn-success me-2',
            attr: {
                id: 'customerProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('products.customer_price_list_product') }}";
            }
        },
        {
            text: '<span class="d-none d-sm-inline-block">Search</span>',
            className: 'btn btn-warning',
            attr: {
                id: 'searchProduct',
            },
            action: function(e, dt, node, config) {
                window.location.href = "#";
            }
        }
        ]
        });
    });


    $('#productForm').on('input', 'input, select', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });
    $('#savedata').click(function(e) {
    e.preventDefault();
    var button = $(this);
    sending(button);

    var productId = $('#product_id').val();

    if (productId) {
        updateProduct(button, productId);
    } else {
        addProduct(button);
    }
});


function addProduct(button) {
    var formData = new FormData($('#productForm')[0]);
    var url = "{{ route('products.store') }}";
    var type = "POST";

    $.ajax({
        url: url,
        type: type,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.status == "success") {
                $('#productForm').trigger("reset");
                $('#productModel').modal('hide');
                window.location.href = "{{ route('products.index') }}";
                showToast('success', response.msg);
                table.draw();
            }
        },
        error: function(xhr) {
            handleAjaxError(xhr);
            sending(button, true);
        }
    });
}


function updateProduct(button, productId) {
    var formData = new FormData($('#productForm')[0]);
    var url = "{{ route('products.update', ':id') }}".replace(':id', productId);
    var type = "POST";
    formData.append('_method', 'PUT');


    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
        url: url,
        type: type,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            sending(button, false);
        },
        success: function(response) {
            if (response.status === "success") {
                $('#productForm').trigger("reset");
                $('#productModel').modal('hide');
                window.location.href = "{{ route('products.index') }}";
                showToast('success', response.msg);
                table.draw();
            } else {
                showToast('error', 'Failed to update product.');
            }
        },
        error: function(xhr) {
            handleAjaxError(xhr);
        },
        complete: function() {
            sending(button, true);
        }
    });
}


    $('body').on('click', '.deletebtn', function() {
        var id = $(this).data('id');
        confirmDelete(id, function() {
            deleteProduct(id);
        });
    });

    function deleteProduct(id) {
        var url = "{{ route('products.destroy', ':id') }}".replace(':id', id);
        $.ajax({
            url: url,
            type: "DELETE",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {

                    window.location.href = "{{ route('products.index') }}";
            },
            error: function(xhr) {
                console.error('Error:', xhr.statusText);
                showError('Oops!', 'Failed to fetch data.');
            }
        });
    }
    $('body').on('click', '.showbtn', function() {
        var id = $(this).data('id');
        $.get("{{ route('products.index') }}" + '/' + id, function(data) {
            $('#modelHeading').html("Show Product");
            $('#showProductModal').modal('show');
            $('#showProductForm #product_name').val(data.product_name);

        });
    });

    $('#product_category_id').on('change', function() {
        get_subcategory($(this).val(), '#product_sub_category_id');
    });

    $('#productCategoryFilter').on('change', function() {
        get_subcategory($(this).val(), '#productSubCategoryFilter');
    });


function get_subcategory(category_id, subcategory_dropdown) {

    $(subcategory_dropdown).empty().prop('disabled', false);

    var defaultOption = '<option value="" selected>--Select Sub Category--</option>';
    $(subcategory_dropdown).append(defaultOption);
    if (!category_id) {
        return;
    }

    var url = "{{ route('products.sub_category', ':id') }}";
    url = url.replace(':id', category_id);
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.status === 'success') {

                response.subcategories.forEach(function(subcategory) {
                    var option = '<option value="' + subcategory.id + '">' + subcategory.product_sub_category_name + '</option>';
                    $(subcategory_dropdown).append(option);
                });
            } else {
                console.error('Error:', response.msg);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}


$('#product_kind_id').select2({
        placeholder: 'Select Kind',
        dropdownParent: $('#product_kind_id').parent()
    });

    $('#product_type_id').select2({
        placeholder: 'Select Type / Form',
        dropdownParent: $('#product_type_id').parent()
    });

    $('#product_base_color_id').select2({
        placeholder: 'Select Base Color',
        dropdownParent: $('#product_base_color_id').parent()
    });

    $('#product_origin_id').select2({
        placeholder: 'Select Origin',
        dropdownParent: $('#product_origin_id').parent()
    });
    $('#product_group_id').select2({
        placeholder: 'Select Group',
        dropdownParent: $('#product_group_id').parent()
    });

    $('#product_category_id').select2({
        placeholder: 'Select Category',
        dropdownParent: $('#product_category_id').parent()
    });
    $('#product_sub_category_id').select2({
        placeholder: 'Select Sub Category',
        dropdownParent: $('#product_sub_category_id').parent()
    });
    $('#product_thickness_id').select2({
        placeholder: 'Select Thickness',
        dropdownParent: $('#product_thickness_id').parent()
    });

    $('#product_finish_id').select2({
        placeholder: 'Select Finish',
        dropdownParent: $('#product_finish_id').parent()
    });
    $('#unit_of_measure_id').select2({
        placeholder: 'Select Unit Of Measure',
        dropdownParent: $('#unit_of_measure_id').parent()
    });
    $('#gl_inventory_link_account_id').select2({
        placeholder: 'Select Link Account',
        dropdownParent: $('#gl_inventory_link_account_id').parent()
    });

    $('#gl_income_account_id').select2({
        placeholder: 'Select Link Account',
        dropdownParent: $('#gl_income_account_id').parent()
    });

    $('#gl_cogs_account_id').select2({
        placeholder: 'Select Link Account',
        dropdownParent: $('#gl_cogs_account_id').parent()
    });

    $('#assign_bin_id').select2({
        placeholder: 'Select Assigned Bin / A Frame',
        dropdownParent: $('#assign_bin_id').parent()
    });


    $('#preferred_supplier_id').select2({
        placeholder: 'Select Preferred Supplier',
        dropdownParent: $('#preferred_supplier_id').parent()
    });

    $('#brand_or_manufacturer_id').select2({
        placeholder: 'Select Brand/Manufacturer',
        dropdownParent: $('#brand_or_manufacturer_id').parent()
    });

    $('#purchasing_unit_id').select2({
        placeholder: 'Select Purchasing Units',
        dropdownParent: $('#purchasing_unit_id').parent()
    });

    $('#price_range_id').select2({
        placeholder: 'Select Price Range',
        dropdownParent: $('#price_range_id').parent()
    });

    $('#uom_one_id').select2({
        placeholder: 'Select UOM',
        dropdownParent: $('#uom_one_id').parent()
    });
    $('#uom_two_id').select2({
        placeholder: 'Select UOM',
        dropdownParent: $('#uom_two_id').parent()
    });

    $('#uom_three_id').select2({
        placeholder: 'Select UOM',
        dropdownParent: $('#uom_three_id').parent()
    });

    $('#uom_four_id').select2({
        placeholder: 'Select UOM',
        dropdownParent: $('#uom_four_id').parent()
    });

    $('#uom_five_id').select2({
        placeholder: 'Select UOM',
        dropdownParent: $('#uom_one_id').parent()
    });

    $('#uom_six_id').select2({
        placeholder: 'Select UOM',
        dropdownParent: $('#uom_six_id').parent()
    });

    $('#minimum_packing_unit_id').select2({
        placeholder: 'Select UOM',
        dropdownParent: $('#minimum_packing_unit_id').parent()
    });




    $('#productTypeFilter').select2({
        placeholder: 'Select Type / Form',
        dropdownParent: $('#productTypeFilter').parent()
    });

    $('#productCategoryFilter').select2({
        placeholder: 'Select Product Category',
        dropdownParent: $('#productCategoryFilter').parent()
    });

    $('#productSubCategoryFilter').select2({
        placeholder:'Select Category',
        dropdownParent: $('#productSubCategoryFilter').parent()
    });

    $('#productGroupFilter').select2({
        placeholder: 'Select Group',
        dropdownParent: $('#productGroupFilter').parent()
    });
    $('#productThicknessFilter').select2({
        placeholder: 'Select Thickness',
        dropdownParent: $('#productThicknessFilter').parent()
    });

    $('#productOriginFilter').select2({
        placeholder:'Select Origin',
        dropdownParent: $('#productOriginFilter').parent()
    });

    $('#priceRangeFilter').select2({
        placeholder: 'Select Price Range',
        dropdownParent: $('#priceRangeFilter').parent()
    });


    $(document).on('click', '.change_status', function() {

    var id = $(this).data('id');
    var button = $(this);
    var url = "{{ route('products.product_change_status', ':id') }}";
    url = url.replace(':id', id);
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.status === 'success') {
                if (response.new_status == 1) {
                    button.removeClass('btn-danger').addClass('btn-success').text('Active');
                } else {
                    button.removeClass('btn-success').addClass('btn-danger').text('Inactive');
                }
                showToast('success', response.msg);
            }
        }
    });
    });


    $('#savedataWeb').click(function(e) {
    e.preventDefault();
    var button = $(this);
    sending(button);
    var url = "{{ route('products.product_web_update', ':id') }}".replace(':id', $('#product_id').val());
    var type = "PUT";
    $.ajax({
        url: url,
        type: type,
        data: $('#productWebForm').serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status == "success") {
                $('#productWebForm').trigger("reset");
                window.location.href = "{{ route('products.index') }}";
                showToast('success', response.msg);
                table.draw();
            }
        },
        error: function(xhr) {
            handleAjaxError(xhr);
            sending(button, true);
        }
    });
    });


    $(document).ready(function() {
    $('#indivisible').on('click', function() {
        if ($(this).is(':checked')) {
            showAlert();
        } else {
            $('#uom_group_hide').show();
        }
    });


    function showAlert() {

        $('#customAlert').fadeIn();
        $('#okButton').on('click', function() {
            $('#customAlert').fadeOut();
            $('#indivisible').prop('checked', true);
            $('#uom_group_hide').hide();
        });
    }
    });


    $('#product_type_id').on('change', function() {
    var prd_type_text = $('#product_type_id option:selected').text();
    var uom_select = $('#unit_of_measure_id');


    uom_select.find('option').prop('disabled', false);

    if (prd_type_text === "Samples" || prd_type_text === "SAMPLES" || prd_type_text === "samples") {
        uom_select.prop('disabled', false);
        uom_select.find('option:contains("PCS")').prop('selected', true);
        $(".uom_vals").text('PCS');
        $(".sl_val").text('');
        uom_select.trigger('change');
    } else if (prd_type_text === "SLAB" || prd_type_text === "Slab" || prd_type_text === "slab") {

        uom_select.prop('disabled', false);
        uom_select.find('option:contains("SF")').prop('selected', true);
        uom_select.trigger('change');

        $(".uom_vals").text('SF');
        $(".sl_val").text('SF');
    } else {
        uom_select.prop('disabled', false);
        uom_select.find('option:contains("Select")').prop('selected', true);
        $(".uom_vals").text('');
        $(".sl_val").text('');
        uom_select.trigger('change');
    }
});

$(document).ready(function() {
    function checkForDuplicates(selectedValue, currentSelect) {
        let isDuplicate = false;
        let duplicateElement = null;

        $("select[name^='uom_']").each(function() {
            if ($(this).val() === selectedValue && $(this).attr('id') !== currentSelect.attr('id')) {
                isDuplicate = true;
                duplicateElement = $(this);
                return false;
            }
        });

        if (isDuplicate) {
            let keepValue = confirm("You are trying to pick a duplicate alternate UOM or base UOM as alternate UOM. Please check and proceed.");
            if (!keepValue) {
                currentSelect.val("");
            }
        }
    }

    $("select[name^='uom_']").change(function() {
        let currentVal = $(this).val();
        if (currentVal !== "") {
            checkForDuplicates(currentVal, $(this));
        }
    });
});


$('#uploadFileForm').on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);


    $.ajax({
        url: '{{ route("product.uploadFiles") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response.message);

            let fileRows = '';
            response.files.forEach(file => {
                fileRows += `<tr>
                                <td><img src="/storage/${file}" alt="Image" width="100"></td>
                                <td>${file}</td>
                                <td>Notes</td>
                                <td><button class="btn btn-danger">Delete</button></td>
                              </tr>`;
            });
            $('#fileUploadRow').html(fileRows);
        },
        error: function(xhr, status, error) {
            console.error('File upload failed:', error);
        }
    });
    });
    document.getElementById('image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        if (file) {
            reader.onload = function (e) {

                document.getElementById('uploadedAvatar').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });



    $(document).ready(function() {
    var table = $('#searchProductdatatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/get_product_images', // Adjust the route to match your Laravel route
            type: 'GET',
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'image', name: 'image', render: function(data, type, row) {
                return `<img src="${data}" alt="Product Image" width="50">`; // Display the image
            }}
        ],
        paging: true,
        pageLength: 10,
    });
});





    });
</script>
