<style>
    #searchProductsTable tbody tr {
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_sales_order_line = $('#salesOrderline').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('lines.list', ':id') }}".replace(':id', $('#sales_order_id').val()),
                type: 'GET',
                data: function(d) {},
            },
            columns: [{
                    data: 'so_line_no',
                    name: 'so_line_no'
                },
                {
                    data: 'item',
                    name: 'item'
                },
                {
                    data: 'sku',
                    name: 'sku'
                },
                {
                    data: 'item_description',
                    name: 'item_description'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'unit_price',
                    name: 'unit_price'
                },
                {
                    data: 'extended_amount',
                    name: 'extended_amount'
                },
                {
                    data: 'is_taxable',
                    name: 'is_taxable'
                },
                {
                    data: 'is_hideon_print',
                    name: 'is_hideon_print'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).addClass('row-' + data.id);
            },
            "info": false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                    text: ' <span class="d-none d-sm-inline-block">Add Item</span>',
                    className: 'create-new btn btn-primary me-2',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#lineModel',
                        'aria-controls': 'crmEvent',
                    },
                    action: function(e, dt, node, config) {
                        $('#modelHeading').html("Add Item from Available Inventory");
                    }
                },
                {
                    text: '<span class="d-none d-sm-inline-block">Add Service</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#serviceModel',
                        'aria-controls': 'crmEvent',
                    },
                    action: function(e, dt, node, config) {
                        $('#modelServiceHeading').html("Add Service");
                    }
                }
            ],
        });

        $(document).on('click', '.addContactBtn', function() {
            var contact_id = $(this).data('id');
            var sales_order_id = $('input[name="sales_order_id"]').val();
            if (contact_id && sales_order_id) {
                $.ajax({
                    url: "{{ route('sale_orders.contact.save') }}",
                    method: 'POST',
                    data: {
                        sales_order_id: sales_order_id,
                        contact_id: [contact_id],
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            window.location.reload();
                            let contactHTML = '';
                            response.contacts.forEach(function(contact) {
                                contactHTML += `
                            <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_${contact.sales_order_contact_id}">
                                <span class="fw-semibold">${contact.name}</span>
                                <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="${contact.sales_order_contact_id}">
                                    <i class="fas fa-trash-alt fa-xs"></i>
                                </button>
                            </div>`;
                            });
                            $('.showContact').html(contactHTML);
                        } else {
                            showToast('danger', response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        showToast('danger', 'An error occurred while adding contact.');
                    }
                });
            } else {
                showToast('warning', 'Please select a contact first.');
            }
        });

        $('body').on('click', '.editContactBtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('customers.contacts.edit', ':id') }}".replace(':id', id), function(data) {
                $('#modalTitle').html("Update Contact");
                $('#saveCustContact').html("Update Contact");
                $('#saveCustomerContactModal').modal('show');
                $('#contact_id').val(data.id);
                $('#contact_name').val(data.contact_name);
                $('#type').val(data.type);
                $('#type_id').val(data.type_id);
                $('#title').val(data.title);
                $('#address').val(data.address);
                $('#address_2').val(data.address_2);
                $('#city').val(data.city);
                $('#state').val(data.state);
                $('#zip').val(data.zip);
                $('#county_id').val(data.county_id);
                $('#country_id').val(data.country_id);
                $('#primary_phone').val(data.primary_phone);
                $('#secondary_phone').val(data.secondary_phone);
                $('#mobile').val(data.mobile);
                $('#email').val(data.email);
                $('#fax').val(data.fax);
                $('.internal_notes').val(data.internal_notes);
                $('#is_ship_to_address').prop('checked', data.is_ship_to_address);
                if (data.is_ship_to_address == 1) {
                    $('#taxCodeContainer').show();
                    $('#tax_code_id').val(data.tax_code_id);
                } else {
                    $('#tax_code_id').val('');
                    $('#taxCodeContainer').hide();
                }
            });
        });
        $(document).on('click', '.deleteBillToContactBtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteSaleOrderBillToContact(id);
            });
        });

        function deleteSaleOrderBillToContact(id) {
            var url = "{{ route('sale_orders.bill_to_contacts.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        handleAjaxResponse(response, table_sales_order_line);
                        $(`#contact_${response.id}`).remove();
                    } else {
                        showToast('danger', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to delete the contact.');
                }
            });
        }

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('lines.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelServiceHeading').html("Update Service");
                $('#serviceModel').modal('show');
                $('#item_id').val(data.item_id);
                $('#item_description').val(data.item_description);
                $('#quantity').val(data.quantity);
                $('#unit_price').val(data.unit_price);
                $('#extended_amount').val(data.extended_amount);
                if (data.is_taxable == 1) {
                    $('#is_taxable').prop('checked', true);
                } else {
                    $('#is_taxable').prop('checked', false);
                }
                if (data.is_sold_as == 1) {
                    $('#is_sold_as').prop('checked', true);
                } else {
                    $('#is_sold_as').prop('checked', false);
                }
                if (data.is_hideon_print == 1) {
                    $('#is_hideon_print').prop('checked', true);
                } else {
                    $('#is_hideon_print').prop('checked', false);
                }
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteService(id);
            });
        });

        function deleteService(id) {
            var url = "{{ route('lines.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('#soitemsavedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#so_product_id').val() ? "{{ route('so_item_lines.update', ':id') }}".replace(
                ':id', $('#so_product_id').val()) : "{{ route('so_item_lines.store') }}";
            var type = $('#so_product_id').val() ? "PUT" : "POST";
            var formData = $('#soProductForm').serializeArray();

            formData.push({
                name: 'is_not_in_stock',
                value: $('#soProductForm #is_not_in_stock').is(':checked') ? '1' : '0'
            });
            formData.push({
                name: 'is_taxable',
                value: $('#soProductForm #is_taxable').is(':checked') ? '1' : '0'
            });
            formData.push({
                name: 'is_sold_as',
                value: $('#soProductForm #is_sold_as').is(':checked') ? '1' : '0'
            });
            formData.push({
                name: 'is_hideon_print',
                value: $('#soProductForm #is_hideon_print').is(':checked') ? '1' : '0'
            });
            formData.push({
                name: 'pick_ticket_restriction',
                value: $('#soProductForm input[name="pick_ticket_restriction"]:checked')
                .val() || '0'
            });
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#soProductForm').trigger("reset");
                        sending(button, true);
                        table_sales_order_line.draw();
                        showToast('success', response.msg);
                        window.location.reload();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });


        $('#servicedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#so_line_id').val() ? "{{ route('lines.update', ':id') }}".replace(':id', $(
                '#so_line_id').val()) : "{{ route('lines.store') }}";
            var type = $('#so_line_id').val() ? "PUT" : "POST";
            var formData = $('#serviceForm').serializeArray();
            formData.push({
                name: 'is_taxable',
                value: $('#serviceForm #is_taxable').is(':checked') ? '1' : '0'
            });
            formData.push({
                name: 'is_sold_as',
                value: $('#serviceForm #is_sold_as').is(':checked') ? '1' : '0'
            });
            formData.push({
                name: 'is_hideon_print',
                value: $('#serviceForm #is_hideon_print').is(':checked') ? '1' : '0'
            });
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#serviceForm').trigger("reset");
                        sending(button, true);
                        table_sales_order_line.draw();
                        showToast('success', response.msg);
                        window.location.reload();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        const so_product_qty = document.forms['soProductForm'].elements['quantity'];
        const so_product_unit_price = document.forms['soProductForm'].elements['unit_price'];
        const so_product_ext_amt = document.forms['soProductForm'].elements['extended_amount'];

        function updateResultProduct() {
            const value1 = parseFloat(so_product_qty.value) || 0;
            const value2 = parseFloat(so_product_unit_price.value) || 0;
            const multiplicationResult = value1 * value2;

            const roundedResult = multiplicationResult.toFixed(2);

            so_product_ext_amt.value = roundedResult;
        }

        document.forms['soProductForm'].unit_price.addEventListener('input', updateResultProduct);
        document.forms['soProductForm'].quantity.addEventListener('input', updateResultProduct);

        const so_service_qty = document.forms['serviceForm'].elements['quantity'];
        const so_service_unit_price = document.forms['serviceForm'].elements['unit_price'];
        const so_service_ext_amt = document.forms['serviceForm'].elements['extended_amount'];

        function updateResult() {
            const value1 = parseFloat(so_service_qty.value) || 0;
            const value2 = parseFloat(so_service_unit_price.value) || 0;
            const multiplicationResult = value1 * value2;

            const roundedResult = multiplicationResult.toFixed(2);

            so_service_ext_amt.value = roundedResult;
        }

        document.forms['serviceForm'].unit_price.addEventListener('input', updateResult);
        document.forms['serviceForm'].quantity.addEventListener('input', updateResult);


        $('#soProductForm input, #soProductForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#soProductForm').on('input', function() {
            let fieldName = $(this).attr('name');
            $val = $('.' + fieldName + '_error').text('');
        });

        $('#serviceForm input, #serviceForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#serviceForm').on('input', function() {
            let fieldName = $(this).attr('name');
            $val = $('.' + fieldName + '_error').text('');
        });

        $('#soProductForm #is_not_in_stock').change(function() {
            if ($(this).is(':checked')) {
                $('#modelHeading').text('Add Item and Allocate Inventory Later');
                $('#quantity').attr('readonly', true);
            } else {
                $('#modelHeading').text('Add Item from Available Inventory');
                $('#quantity').attr('readonly', false);
            }
        });


        $('#searchProductBtn').click(function() {
            var table_search_product = $('#searchProductsTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('sale_orders.search_product') }}",
                    type: 'GET',
                    data: function(d) {
                        d.name = $('#search_product_name_sku').val();
                        d.type = $('#search_product_type').val();
                        d.category = $('#search_category_type').val();
                        d.group = $('#search_group').val();
                    },
                    dataSrc: function(response) {
                        return response.data;
                    },
                },
                columns: [{
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'product_sku',
                        name: 'product_sku'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'icon',
                        name: 'icon',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    processing: "Loading products...",
                    zeroRecords: "No products found matching your search.",
                },
                destroy: true,
                rowCallback: function(row, data, index) {
                    $(row).on('click', function() {
                        var tr = $(this);
                        var row = table_search_product.row(tr);
                        $('#item_name').val(data.product_name);
                        $('#search_product_name_sku').val(data.product_name);

                        table_search_product.rows().every(function() {
                            var currentRow = this.node();
                            var currentRowData = this.data();

                            if ($(currentRow).hasClass('shown')) {
                                this.child.hide();
                                $(currentRow).removeClass('shown');
                            }
                        });

                        if (row.child.isShown()) {
                            row.child.hide();
                            tr.removeClass('shown');
                        } else {
                            $.ajax({
                                url: "{{ route('so_item_lines.slablist', ':id ') }}"
                                    .replace(':id', data.product_name),
                                type: 'GET',
                                data: {
                                    item_name: data.product_name
                                },
                                success: function(subData) {
                                    var subTable =
                                        '<table class="table table-bordered table-striped table-hover table-sm"><thead  class="table-header-bold"><tr><th>Serial Num <br />Barcode</th><th>Lot/Block - Bundle / Supp. Ref</th><th>Location (Bin)</th><th>On Hand</th><th>Available</th><th>N</th><th>select</th></tr></thead><tbody>';
                                    subData.forEach(function(item) {
                                        subTable += '<tr><td>' +
                                            item.serial_no +
                                            '<br />' + item
                                            .bar_code_no +
                                            '</td><td>' + item
                                            .lot_block + ' - ' +
                                            item.supplier_ref +
                                            '</td><td>' + item
                                            .present_location +
                                            '</td><td>50.00 PCS</td><td>50.00</td><td> </td><td><input type="checkbox" class="form-check-input product_checkbox" ></td></tr>';
                                    });
                                    subTable += '</tbody></table>';

                                    row.child(subTable).show();
                                    tr.addClass('shown');
                                }
                            });
                        }
                    });
                }

            });
        });
    });
</script>
