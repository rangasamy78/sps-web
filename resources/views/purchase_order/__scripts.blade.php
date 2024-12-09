<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#purchaseOrderForm').on('input change', 'input, select', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });

    $('#purchaseOrderForm').on('input change', 'input[type="date"]', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });

    var table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('purchase_orders.list') }}",
            data: function(d) {
                sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                d.order = [{
                    column: 1,
                    dir: sort
                }];
            }
        },
        columns: [{
                data: null,
                name: 'serial',
                orderable: false,
                searchable: false
            },
            {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_date',
                name: 'po_date'
            },
            {
                data: 'required_ship_date',
                name: 'required_ship_date'
            },
            {
                data: 'age',
                name: 'age'
            },
            {
                data: 'supplier_so_number',
                name: 'supplier_so_number'
            },
            {
                data: 'inventory_supplier',
                name: 'inventory_supplier'
            },
            {
                data: 'supplier_type',
                name: 'supplier_type'
            },
            {
                data: 'container',
                name: 'container'
            }, {
                data: 'payment_terms',
                name: 'payment_terms'
            },

            {
                data: 'purchase_location',
                name: 'purchase_location'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'ship_location',
                name: 'ship_location'
            },
            {
                data: 'total',
                name: 'total'
            },

            {
                data: 'approval_status',
                name: 'approval_status'
            },
            {
                data: 'no_inv',
                name: 'no_inv'
            },
            {
                data: 'internal_note',
                name: 'internal_note'
            },
            {
                data: 'special_note',
                name: 'special_note'
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
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [{
            text: '<span class="d-none d-sm-inline-block">New Purchase Order</span>',
            className: 'btn btn-primary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('purchase_orders.create') }}";
            }
        }, ],
    });

    $('#savedata').click(function(e) {
        e.preventDefault();
        var button = $(this);
        sending(button);
        var url = $('#purchase_order_id').val() ? "{{ route('purchase_orders.update', ':id') }}"
            .replace(':id', $('#purchase_order_id').val()) : "{{ route('purchase_orders.store') }}";
        var type = $('#purchase_order_id').val() ? "PUT" : "POST";
        $.ajax({
            url: url,
            type: type,
            data: $('#purchaseOrderForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status == "success") {
                    $('#purchaseOrderForm').trigger("reset");
                    $('#purchaseOrderModel').modal('hide');
                    showToast('success', response.msg);
                    table.draw();
                    var id = response.id;
                    window.location.href =
                        "{{ route('purchase_orders.purchase_details', ':id') }}".replace(
                            ':id', id);
                }
            },
            error: function(xhr) {
                handleAjaxError(xhr);
                sending(button, true);
            }
        });
    });

    $(document).ready(function() {
        $('#supplier_id').on('change', function() {
            var SupplierId = $(this).val();

            if (SupplierId) {
                var url = "{{ route('fetch_supplier_details', ':id') }}";
                url = url.replace(':id', SupplierId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#supplier_address').val(response.data.ship_address)
                                .prop('readonly', true);
                            $('#supplier_suite').val(response.data.ship_suite).prop(
                                'readonly', true);
                            $('#supplier_city').val(response.data.ship_city).prop(
                                'readonly', true);
                            $('#supplier_state').val(response.data.ship_state).prop(
                                'readonly', true);
                            $('#zip').val(response.data.ship_zip).prop('readonly',
                                true);
                            $('#country_id').val(response.data.ship_country_id)
                                .trigger('change').prop('readonly', true);
                            $('#payment_term_id').val(response.data
                                .payment_terms_id).trigger('change');
                        } else {
                            alert('Supplier details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        });
    });
    $(document).ready(function() {

        $('#product_data_update').hide();
        $('#product_data').hide();
        $('#product_id').change(function() {

            var productId = $(this).val();
            var productName = $(this).find('option:selected').text();;

            if (productId) {
                $('#product_id_hid').val(productId)
                $('#product_name').val(productName).prop('disabled', true);
                $('#product_data').show();
                $('#product_data_update').hide();

            } else {

                $('#product_data').hide();
                $('#product_data_update').hide();
            }
        });
    });
    $('.edit-btn-po').click(function() {

        $('#product_data').hide();
        $('#product_data_update').show();
        var productId = $(this).data('id');
        var productName = $(this).data('product_name');

        if (productId) {
            var url = "{{ route('fetch_product_po_details', ':id') }}";
            url = url.replace(':id', productId);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#edit_id').val(productId);
                        $('#edit_po_id').val(response.data.po_id);
                        $('#edit_product_id_hid').val(response.data.product_id);
                        $('#edit_product_name').val(productName).prop('disabled', true);
                        $('#edit_so').val(response.data.so);
                        $('#edit_description').val(response.data.description);
                        $('#edit_supplier_purchasng_note').val(response.data
                            .supplier_purchasng_note);
                        $('#edit_length').val(response.data.length);
                        $('#edit_width').val(response.data.width);
                        $('#edit_bundles').val(response.data.bundles);
                        $('#edit_slabs').val(response.data.slab);
                        $('#edit_slab_bundles').val(response.data.slab_bundles);
                        $('#edit_unit_price').val(response.data.unit_price);
                        $('#edit_quantity').val(response.data.quantity);
                        $('#edit_extended').val(response.data.extended);
                    } else {
                        alert('Product details not found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }
    });

    $('#canceldata').click(function(event) {
        event.preventDefault();
        $('#product_data input[type="text"]').val('');
        $('#product_data').hide();
        $('#product_id').select2({
            allowClear: true,
        });

        const defaultProductId = "";
        $('#product_id').val(defaultProductId).trigger('change');
    });


    $('#savedataProduct').on('click', function(e) {
        e.preventDefault();

        var po_id = $('#po_id').val();

        $.ajax({
            url: '{{ route("purchase_orders.po_product_save") }}',
            type: 'POST',
            data: $('#poProductForm').serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', response.msg);
                    $('#poProductForm')[0].reset();

                    const newRow = `
                <tr>
                    <td>${response.product.so || ''}</td>
                    <td>${response.product.product_name || ''}</td>
                    <td>${response.product.description || ''}</td>
                    <td class="quantity">${response.product.quantity || ''}</td>
                    <td class="unit_price">${response.product.unit_price || ''}</td>
                    <td class="extended">${(response.product.quantity && response.product.unit_price) ? (response.product.quantity * response.product.unit_price).toFixed(2) : 'empty'}</td>
                      <td>
                        <button class="btn btn-warning btn-sm edit-btn-po" data-id="${response.product.id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${response.product.id}">Delete</button>
                    </td>
                </tr>
            `;
                    $('#product_details_table tbody').append(newRow);

                    updateSubtotalAndTotal();
                } else {
                    showToast('error', response.msg);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                showToast('error', 'An error occurred while saving the product.');
            }
        });


        function updateSubtotalAndTotal() {
            let subtotal = 0;
            let total = 0;

            $('#product_details_table tbody tr').each(function() {
                const quantity = parseFloat($(this).find('.quantity').text()) || 0;
                const unit_price = parseFloat($(this).find('.unit_price').text()) || 0;
                const extended = quantity * unit_price;
                $(this).find('.extended').text(extended.toFixed(2));

                subtotal += extended;
            });

            $('#subtotal').text(subtotal.toFixed(2));
            $('#total').text(subtotal.toFixed(
                2));
            $('#product_data').hide();
        }

    });

    $(document).ready(function() {

        const $quantityInput = $('#quantity');
        const $unitPriceInput = $('#unit_price');
        const $extendedInput = $('#extended');

        function updateExtendedPrice() {
            const quantity = parseFloat($quantityInput.val()) || 0;
            const unitPrice = parseFloat($unitPriceInput.val()) || 0;
            const extendedPrice = quantity * unitPrice;
            $extendedInput.val(extendedPrice.toFixed(2));
        }

        $quantityInput.on('input', updateExtendedPrice);
        $unitPriceInput.on('input', updateExtendedPrice);

        function calculateTotals() {
            let subtotal = 0;

            $('.extended').each(function() {
                const extendedValue = parseFloat($(this).text()) || 0;
                subtotal += extendedValue;
            });

            $('#subtotal').text(subtotal.toFixed(2));
            $('#total').text(subtotal.toFixed(
                2));
        }

        calculateTotals();

        $(document).on('input change', '.quantity, .unit_price', function() {
            const row = $(this).closest('tr');
            const quantity = parseFloat(row.find('.quantity').text()) || 0;
            const unitPrice = parseFloat(row.find('.unit_price').text()) || 0;
            const extended = quantity * unitPrice;
            row.find('.extended').text(extended.toFixed(2));
            calculateTotals();
        });
    });
    document.getElementById('saveButton').addEventListener('click', function() {

        var poId = $('#purchase_order_id').val();

        window.location.href = "{{ route('purchase_orders.po_details', ':id') }}".replace(':id', poId);

    });

});
$(document).on('click', '.delete-btn', function() {
    var poId = $(this).data('id');
    if (poId) {
        var url = "{{ route('deletePo', ':id') }}".replace(':id', poId);

        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', response.msg);
                    $(`button[data-id="${poId}"]`).closest('tr').remove();

                    updateSubtotalAndTotal();
                } else {
                    showToast('error', response.msg);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                showToast('error', 'An error occurred while deleting the product.');
            }
        });
    }
});

function updateSubtotalAndTotal() {
    let subtotal = 0;

    $('#product_details_table tbody tr').each(function() {
        const quantity = parseFloat($(this).find('.quantity').text()) || 0;
        const unitPrice = parseFloat($(this).find('.unit_price').text()) || 0;

        const extended = quantity * unitPrice;
        subtotal += extended;

        $(this).find('.extended').text(extended.toFixed(2));
    });

    $('#subtotal').text(subtotal.toFixed(2));
    const tax = parseFloat($('#tax').val()) || 0;
    const total = subtotal + tax;
    $('#total').text(total.toFixed(2));
}

$('#updatedataProduct').on('click', function(e) {
    e.preventDefault();

    var po_id = $('#po_id').val();

    $.ajax({
        url: '{{ route("purchase_orders.po_product_update") }}',
        type: 'PUT',
        data: $('#poProductFormUpdate').serialize(),
        success: function(response) {
            if (response.status === 'success') {
                showToast('success', response.msg);
                $('#poProductFormUpdate')[0].reset();

                updateSubtotalAndTotal();
            } else {
                showToast('error', response.msg);
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            showToast('error', 'An error occurred while saving the product.');
        }
    });

    function updateSubtotalAndTotal() {
        let subtotal = 0;
        let total = 0;

        $('#product_details_table tbody tr').each(function() {
            const quantity = parseFloat($(this).find('.quantity').text()) || 0;
            const unit_price = parseFloat($(this).find('.unit_price').text()) || 0;
            const extended = quantity * unit_price;

            $(this).find('.extended').text(extended.toFixed(2));


            subtotal += extended;
        });

        $('#subtotal').text(subtotal.toFixed(2));
        $('#total').text(subtotal.toFixed(2));
        $('#product_data_update').hide();
    }

});
</script>