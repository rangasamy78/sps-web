<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable for opportunityCrmEvent
        var table_quote_line = $('#quoteLinesDatatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('quote.service_product_list', ':id') }}".replace(':id', $('#quote_id').val()),
                type: 'GET',
                data: function(d) {
                    // Additional data if needed
                },
            },
            columns: [{
                    data: null,
                    name: 'serial',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'sku',
                    name: 'sku'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'fullfiled',
                    name: 'fullfiled'
                },
                {
                    data: 'balance',
                    name: 'balance'
                },
                {
                    data: 'unit_price',
                    name: 'unit_price'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'tax',
                    name: 'tax'
                },
                {
                    data: 'hide_line',
                    name: 'hide_line'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            rowCallback: function(row, data, index) {
                const serial = table_quote_line.page.info().start + index + 1;
                $('td:eq(0)', row).html(serial);
            },
            drawCallback: function(settings) {
                calculateAndDisplayTotals(settings.json.data, settings.json.data2);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Item</span>',
                    className: 'create-new btn btn-primary me-2',
                    attr: {
                        'data-bs-toggle': 'offcanvas',
                        'data-bs-target': '#itemOffcanvas',
                        'aria-controls': 'Item'
                    },
                    action: function(e, dt, node, config) {
                        $('#addQuoteProductForm').trigger("reset");
                        clearQuoteProductError();
                        $('#addQuoteProductForm input[type="checkbox"]').prop('checked', false);
                        $('#addQuoteProductForm select').val('').trigger('change');
                        $('#offCanvasHeading').html("Add Item");
                    }
                },
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Service</span>',
                    className: 'create-new btn btn-secondary',
                    attr: {
                        'data-bs-toggle': 'offcanvas',
                        'data-bs-target': '#serviceOffcanvas',
                        'aria-controls': 'service'
                    },
                    action: function(e, dt, node, config) {
                        $('#addQuoteServiceForm').trigger("reset");
                        clearQuoteServiceError();
                        $('#addQuoteServiceForm input[type="checkbox"]').prop('checked', false);
                        $('#addQuoteServiceForm select').val('').trigger('change');
                        $('#serviceOffCanvasHeading').html("Add Service");
                    }
                }
            ]
        });

        function calculateAndDisplayTotals(data, data2) {
            let subtotal = 0;
            let taxSubtotal = 0;
            let totalReceived = 0;
            let totalBalance = 0;

            const taxRate = parseFloat($('#tax_code_amount').val()) || 0; // Default tax rate
            let totalsContent = '';

            data2.forEach(receive => {
                if (receive && receive.receive_amount) {
                    totalsContent += `
                <div class="row">
                    <div class="col d-flex justify-content-end gap-2">
                        <label class="text-dark fw-bold mt-2">Unapplied - #${receive.payment_method || ''}:</label>
                        <span class="mt-2 ms-4 fw-bold">$${parseFloat(receive.receive_amount).toFixed(2)}</span>
                    </div>
                </div>`;
                    totalReceived += parseFloat(receive.receive_amount) || 0;
                }
            });

            // Update the received deposits section
            $('#receive_deposit').html(totalsContent);

            // Calculate subtotal and tax based on data
            data.forEach(item => {
                const unitPrice = parseFloat(item.amount || 0);
                const taxApplicable = item.tax_cal; // Assuming tax_cal is 1 if tax is applicable

                subtotal += unitPrice;

                if (taxApplicable === 1) {
                    taxSubtotal += unitPrice;
                }
            });
            const tax = (taxSubtotal * taxRate) / 100;
            const total = subtotal + tax;
            const balanceDue = Math.max(0, total - totalReceived); // Ensure balance due is not negative
            if (balanceDue <= 0) {
                $('#addLine').hide();
            } else {
                $('#addLine').show();
            }
            $('#line_sub_total').html('$' + subtotal.toFixed(2));
            $('#tax_code_amount_label').html('$' + tax.toFixed(2));
            $('#line_total').html('$' + total.toFixed(2));
            $('#balance_due').html('$' + balanceDue.toFixed(2));
        }

        $('#addQuoteProductForm input, #addQuoteProductForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        // Save quote product button functionality
        $('#saveQuoteProduct').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#quote_item_id').val() ? "{{ route('quote.quote_products.update', ':id') }}".replace(':id', $('#quote_item_id').val()) : "{{ route('quote.quote_products.store') }}";
            var type = $('#quote_item_id').val() ? "PUT" : "POST";
            var data = $('#addQuoteProductForm').serialize();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#addQuoteProductForm').trigger("reset");
                        sending(button, true);
                        $('#itemOffcanvas').offcanvas('hide');
                        table_quote_line.draw();
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        // Initialize DataTable for productListTable with search filters
        $(' #productNameFilter,#codeFilter').on('keyup change', function(e) {
            e.preventDefault();
            table_quote_product_list.draw();
        });

        var table_quote_product_list = $('#quoteProductListTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('quote.product_list') }}",
                data: function(d) {
                    d.productName = $('#productNameFilter').val();
                    d.productCode = $('#codeFilter').val();
                }
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
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).css('cursor', 'pointer');
                $(row).on('click', function() {
                    $('#addQuoteProductForm #product_id').val(data.id);
                    $('#addQuoteProductForm #product_name').val(data.product_name);
                    $('#addQuoteProductForm #product_unit_price').val(data.homeowner_price);
                    calculateProductTotal();
                    $('#searchQuoteProduct').modal('hide');
                });
            }
        });

        //calculation 
        function calculateProductTotal() {
            var product_unit_price = parseFloat($('#product_unit_price').val()) || 0;
            var product_quantity = parseInt($('#product_quantity').val()) || 0;
            let total = product_unit_price * product_quantity;

            $('#product_amount').val(total.toFixed(2));
        }

        // Event listener for user changes
        $('.value_cal').on('change input', function() {
            calculateProductTotal();
        });

        function clearQuoteProductError() {
            // Clear error messages for each field
            $('#addQuoteProductForm .product_id_error').text('');
            $('#addQuoteProductForm .description_error').text('');
            $('#addQuoteProductForm .is_sold_as_error').text('');
            $('#addQuoteProductForm .product_unit_price_error').text('');
            $('#addQuoteProductForm .product_quantity_error').text('');
            $('#addQuoteProductForm .product_amount_error').text('');
        }

        $('body').on('click', '.updateQuoteItemContact', function() {
            var id = $(this).data('id');
            clearQuoteProductError();
            $.get("{{ route('quote.quote_products.index') }}" + '/' + id + '/edit', function(data) {
                $('#offCanvasHeading').html("Update Item");
                $('#savedata').val("Update Item").html("Update Item");
                $('#itemOffcanvas').offcanvas('show');
                $('#quote_item_id').val(data.model.id);
                $('#addQuoteProductForm #product_id').val(data.model.product_id);
                $('#addQuoteProductForm #product_name').val(data.product_name);
                $('#description').val(data.model.description);
                $('#product_quantity').val(data.model.product_quantity);
                $('#product_unit_price').val(data.model.product_unit_price);
                $('#product_amount').val(data.model.product_amount);
                $('#notes').val(data.model.notes);
                $('#addQuoteProductForm #is_sold_as').prop('checked', data.model.is_sold_as == 1);
                $('#addQuoteProductForm #is_tax').prop('checked', data.model.is_tax == 1);
                $('#addQuoteProductForm #is_hide_line').prop('checked', data.model.is_hide_line == 1);
                if (data.model.inventory_restriction) {
                    $('#addQuoteProductForm input[name="inventory_restriction"][value="' + data.model.inventory_restriction + '"]').prop('checked', true);
                }
            });
        });

        $('body').on('click', '.deleteQuoteProduct', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteQuoteProduct(id);
            });
        });

        function deleteQuoteProduct(id) {
            var url = "{{ route('quote.quote_products.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, table_quote_line);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        // item option line
        $(document).on('click', '.addOptionLineProduct', function() {
            var productId = $(this).data('id');
            var productName = $(this).data('name');
            $('#quote_product_id').val(productId);
            $('#quoteProductName').text(productName);
            $('#option_line_quote_product').find('tr').remove();
            showOptionLineProduct(productId);
            $('#addOptionLineItemModel').modal('show');
        });

        function showOptionLineProduct($id) {
            var url = "{{ route('quote.option_line_product_lists', ':id') }}".replace(':id', $id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        var product = response.data;
                        var rowIndex = $('#option_line_quote_product tr').length + 1;
                        product.forEach(function(item) {
                            var row = `<tr>
                        <td><span style="font-size: 8pt;">${item.product_name}</span><div class="d-flex align-items-center mt-1"><input type="hidden" class="form-control" name="product_id[]" value="${item.product_id}" readonly><input type="checkbox" class="form-check-input me-2" name="is_sold_as[]" ${item.is_sold_as ? 'checked' : ''}><label class="text-dark fw-bold me-2 mb-0" style="font-size: 7pt;">Sold As:</label><input type="text" class="form-control form-control-sm" name="description[]" value="${item.description || ''}" placeholder="description"></div><span class="text-danger error-text product_id_error"></span></td>
                        <td><input type="number" readonly class="form-control form-control-sm quantity" name="quantity[]" value="${item.quantity}" style="width: 100px;"></td>
                        <td><div class="d-flex align-items-center"><span class="me-1">$</span><input type="number" class="form-control price form-control-sm" name="unit_price[]" value="${item.unit_price || 0}" style="width: 100px;"></div></td>
                        <td><div class="d-flex align-items-center"><span class="me-2">$</span><input type="text" class="form-control form-control-sm amount" name="amount[]" value="${item.amount || 0}" readonly style="width: 100px;"></div><span class="text-danger error-text amount_error"></span></td>
                        <td><button type="button" class="btn btn-border p-0 d-flex align-items-center justify-content-center delete-option-line-quote-product" style="width: 30px; height: 30px;" data-id="${item.id}"><i class="fi fi-rr-cross-circle text-danger fw-bold fs-4 "></i></button></td>
                         </tr>`;
                            $('#option_line_quote_product').append(row);
                        });
                        calculateProductAmount();
                        $('.product_checkbox[data-id="' + $id + '"]').prop('disabled', true);
                    } else {
                        // $('#option_line_quote_product').html('<tr><td colspan="5" class="text-center">No products found.</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseJSON);
                    alert('An error occurred while fetching the product.');
                }
            });
        }

        // Delete option line product and remove the row from the table
        $('body').on('click', '.delete-option-line-quote-product', function() {
            var id = $(this).closest('button').data('id');
            var row = $(this).closest('tr');

            confirmDelete(id, function() {
                deleteOptionLineQuoteProduct(id, row);
            });
        });

        // Function to delete option line product
        function deleteOptionLineQuoteProduct(id, row) {
            var url = "{{ route('quote.quote_option_line_products.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, '');
                    row.remove();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        //search product
        $('#searchProductBtn').click(function() {
            var table_search_product = $('#optionLineItemTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('quote.option_line_product') }}",
                    type: 'GET',
                    data: function(d) {
                        d.name = $('#search_product_name_sku').val();
                        d.type = $('#search_product_type').val();
                        d.category = $('#search_category_type').val();
                        d.price_range = $('#search_price_range').val();
                        d.sub_category = $('#search_sub_category').val();
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
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'group',
                        name: 'group'
                    }, {
                        data: 'price_range',
                        name: 'price_range'
                    }, {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    processing: "Loading products...",
                    zeroRecords: "No products found matching your search.",
                },
                destroy: true
            });
        });

        $(document).on('change', '.product_checkbox', function() {
            if ($(this).is(':checked')) {
                var dataId = $(this).data('id');
                var url = "{{ route('products.get_product') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: dataId,
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.data) {
                            var product = response.data;
                            var rowIndex = $('#option_line_quote_product tr').length + 1;
                            var row = `<tr>
                <td><span style="font-size: 8pt;">${product.product_name}</span><div class="d-flex align-items-center mt-1"><input type="hidden" class="form-control" name="product_id[]" id="product_id[]" value="${product.id}"><input type="checkbox" class="form-check-input me-2" id="is_sold_as[]" value="1" name="is_sold_as[]"><label class="text-dark fw-bold me-2 mb-0" style="font-size: 7pt;white-space: nowrap;">Sold As:</label><input type="text" class="form-control form-control-sm" value="" id="description[]" name="description[]" placeholder="description"></div><span class="text-danger error-text product_id_error"></span></td>
                <td><input type="number" class="form-control form-control-sm quantity" value="0" readonly name="quantity[]" id="quantity[]" data-id="${product.id}" style="width: 100px;"></td>
                <td><div class="d-flex align-items-center"><span class="me-1">$</span><input type="number" class="form-control price form-control-sm" name="unit_price[]" id="unit_price[]" value="${product.price.homeowner_price || 0}" data-id="${product.id}" style="width: 100px;"></td>
                <td><div class="d-flex align-items-center"><span class="me-2">$</span><input type="text" class="form-control form-control-sm amount" id="amount[]" name="amount[]" value="${(product.price.homeowner_price || 0) *0 }" readonly style="width: 100px;"></div><span class="text-danger error-text amount_error"></span></td>
                <td><button type="button" class="btn btn-border p-0 d-flex align-items-center justify-content-center delete-row" style="width: 30px; height: 30px;" value="${product.id}" data-id="${product.id}"><i class="fi fi-rr-cross text-danger fw-bold" style="font-size: 12px;"></i></button></td></tr>`;
                            $('#option_line_quote_product').append(row);
                            calculateProductAmount();
                            $('.product_checkbox[data-id="' + dataId + '"]').prop('disabled', true);
                        } else {
                            $('#option_line_quote_product').html('<tr><td colspan="5" class="text-center">No products found.</td></tr>');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseJSON);
                        alert('An error occurred while fetching the product.');
                    }
                });
            }
        });

        function calculateProductAmount() {
            var quantity = parseFloat($(this).closest('tr').find('.quantity').val()) || 0;
            var price = parseFloat($(this).closest('tr').find('.price').val()) || 0;
            var amount = quantity * price;
            $(this).closest('tr').find('.amount').val(amount.toFixed(2));
        }

        // Update the amount when quantity or price changes
        $(document).on('input', '.price', function() {
            calculateProductAmount();
        });

        // Recalculate totals when a row is deleted
        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            calculateProductAmount();
        });

        $('#saveQuoteOptionLineProduct').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#quote_option_line_product_id').val() ? "{{ route('quote.quote_option_line_products.update', ':id') }}".replace(':id', $('#quote_option_line_product_id').val()) : "{{ route('quote.quote_option_line_products.store') }}";
            var type = $('#quote_option_line_product_id').val() ? "PUT" : "POST";
            var data = {
                quote_product_id: $('#quote_product_id').val(),
                products: []
            };
            // Loop through each row and construct product data
            $('#optionLineProductForm tbody tr').each(function() {
                var row = $(this);
                var product = {
                    product_id: row.find('input[name="product_id[]"]').val(),
                    description: row.find('input[name="description[]"]').val(),
                    is_sold_as: row.find('input[name="is_sold_as[]"]').is(':checked') ? 1 : 0,
                    quantity: row.find('input[name="quantity[]"]').val(),
                    unit_price: row.find('input[name="unit_price[]"]').val(),
                    amount: row.find('input[name="amount[]"]').val()
                };
                data.products.push(product);
            });
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#optionLineProductForm').trigger("reset");
                        sending(button, true);
                        $('#addOptionLineItemModel').modal('hide');
                        showToast('success', response.msg);
                        table_quote_line.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
        //end item line

        //service
        // Initialize DataTable for productListTable with search filters
        $(' #serviceNameFilter,#serviceCodeFilter').on('keyup change', function(e) {
            e.preventDefault();
            table_quote_service_list.draw();
        });

        var table_quote_service_list = $('#quoteServiceListTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('quote.service_list') }}",
                data: function(d) {
                    d.serviceName = $('#serviceNameFilter').val();
                    d.serviceCode = $('#serviceCodeFilter').val();
                }
            },
            columns: [{
                    data: 'service_name',
                    name: 'service_name'
                },
                {
                    data: 'service_sku',
                    name: 'service_sku'
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).css('cursor', 'pointer');
                $(row).on('click', function() {
                    $('#addQuoteServiceForm #service_id').val(data.id);
                    $('#addQuoteServiceForm #service_name').val(data.service_name);
                    $('#addQuoteServiceForm #service_unit_price').val(data.homeowner_price);
                    if (data.is_taxable_item) {
                        $('#addQuoteServiceForm #is_tax').prop('checked', true);
                    }
                    calculateServiceTotal();
                    $('#searchQuoteService').modal('hide');
                });
            }
        });

        //calculation 
        function calculateServiceTotal() {
            var product_unit_price = parseFloat($('#service_unit_price').val()) || 0;
            var product_quantity = parseInt($('#service_quantity').val()) || 0;
            let total = product_unit_price * product_quantity;

            $('#service_amount').val(total.toFixed(2));
        }
        // Event listener for user changes
        $('.service_total').on('change input', function() {
            calculateServiceTotal();
        });

        // Save quote service button functionality
        $('#addQuoteServiceForm input, #addQuoteServiceForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#saveQuoteService').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#quote_service_id').val() ? "{{ route('quote.quote_services.update', ':id') }}".replace(':id', $('#quote_service_id').val()) : "{{ route('quote.quote_services.store') }}";
            var type = $('#quote_service_id').val() ? "PUT" : "POST";
            var data = $('#addQuoteServiceForm').serialize();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#addQuoteServiceForm').trigger("reset");
                        sending(button, true);
                        $('#serviceOffcanvas').offcanvas('hide');
                        table_quote_line.draw();
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        function clearQuoteServiceError() {
            // Clear error messages for each field
            $('#addQuoteServiceForm .service_id_error').text('');
            $('#addQuoteServiceForm .description_error').text('');
            $('#addQuoteServiceForm .service_quantity_error').text('');
            $('#addQuoteServiceForm .service_unit_price_error').text('');
            $('#addQuoteServiceForm .service_amount_error').text('');
        }

        $('body').on('click', '.updateQuoteServiceContact', function() {
            var id = $(this).data('id');
            clearQuoteServiceError();
            $.get("{{ route('quote.quote_services.index') }}" + '/' + id + '/edit', function(data) {
                $('#serviceOffCanvasHeading').html("Update Service");
                $('#serviceOffcanvas').offcanvas('show');
                $('#quote_service_id').val(data.model.id);
                $('#addQuoteServiceForm #service_id').val(data.model.service_id);
                $('#addQuoteServiceForm #service_name').val(data.service_name);
                $('#addQuoteServiceForm #description').val(data.model.description);
                $('#service_quantity').val(data.model.service_quantity);
                $('#service_unit_price').val(data.model.service_unit_price);
                $('#service_amount').val(data.model.service_amount);
                $('#addQuoteServiceForm #is_sold_as').prop('checked', data.model.is_sold_as == 1);
                $('#addQuoteServiceForm #is_tax').prop('checked', data.model.is_tax == 1);
                $('#addQuoteServiceForm #is_hide_line').prop('checked', data.model.is_hide_line == 1);
            });
        });

        $('body').on('click', '.deleteQuoteService', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteQuoteService(id);
            });
        });

        function deleteQuoteService(id) {
            var url = "{{ route('quote.quote_services.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, table_quote_line);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        // service option line
        $(document).on('click', '.addOptionLineService', function() {
            var quotServiceId = $(this).data('id');
            var serviceName = $(this).data('name');
            $('#quote_service_id').val(quotServiceId);
            $('#quoteServiceName').text(serviceName);
            showOptionLineService(quotServiceId);
            $('#option_line_quote_service').find('tr').remove();
            $('#addOptionLineServiceModel').modal('show');
        });

        $('#searchServiceBtn').click(function() {
            var table_search_service = $('#optionLineServiceTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('quote.option_line_service') }}",
                    type: 'GET',
                    data: function(d) {
                        d.name = $('#search_service_name_sku').val();
                        d.type = $('#search_service_type').val();
                        d.category = $('#search_category_type').val();
                        d.priceRange = $('#search_price_range').val();
                    },
                    dataSrc: function(response) {
                        return response.data;
                    },
                },
                columns: [{
                        data: 'service_name',
                        name: 'service_name'
                    },
                    {
                        data: 'service_sku',
                        name: 'service_sku'
                    },

                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    processing: "Loading Services...",
                    zeroRecords: "No Services found matching your search.",
                },
                destroy: true
            });
        });

        $(document).on('change', '.service_checkbox', function() {
            if ($(this).is(':checked')) {
                var dataId = $(this).data('id');
                var url = "{{ route('quote.get_service') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: dataId,
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.data) {
                            var service = response.data;
                            var rowIndex = $('#option_line_quote_service tr').length + 1;
                            var row = `<tr>
                <td><span style="font-size: 8pt;">${service.service_name}</span><div class="d-flex align-items-center mt-1"><input type="hidden" class="form-control" name="service_id[]" id="service_id[]" value="${service.id}"><input type="checkbox" class="form-check-input me-2" id="is_sold_as[]" value="1" name="is_sold_as[]"><label class="text-dark fw-bold me-2 mb-0" style="font-size: 7pt;white-space: nowrap;">Sold As:</label><input type="text" class="form-control form-control-sm" value="" id="description[]" name="description[]" placeholder="description"></div><span class="text-danger error-text service_id_error"></span></td>
                <td><input type="number" class="form-control form-control-sm quantity" value="0" readonly name="quantity[]" id="quantity[]" data-id="${service.id}" style="width: 100px;"></td>
                <td><div class="d-flex align-items-center"><span class="me-1">$</span><input type="number" class="form-control price form-control-sm" name="unit_price[]" id="unit_price[]" value="${service.service_price.homeowner_price || 0}" data-id="${service.id}" style="width: 100px;"></td>
                <td><div class="d-flex align-items-center"><span class="me-2">$</span><input type="text" class="form-control form-control-sm amount" id="amount[]" name="amount[]" value="${(service.service_price.homeowner_price || 0) *0 }" readonly style="width: 100px;"></div><span class="text-danger error-text amount_error"></span></td>
                <td><button type="button" class="btn btn-border p-0 d-flex align-items-center justify-content-center delete-row" style="width: 30px; height: 30px;" value="${service.id}" data-id="${service.id}"><i class="fi fi-rr-cross text-danger fw-bold" style="font-size: 12px;"></i></button></td></tr>`;
                            $('#option_line_quote_service').append(row);
                            calculateServiceAmount();
                            $('.service_checkbox[data-id="' + dataId + '"]').prop('disabled', true);
                        } else {
                            $('#option_line_quote_service').html('<tr><td colspan="5" class="text-center">No Service found.</td></tr>');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseJSON);
                        alert('An error occurred while fetching the product.');
                    }
                });
            }
        });

        function calculateServiceAmount() {
            var quantity = parseFloat($(this).closest('tr').find('.quantity').val()) || 0;
            var price = parseFloat($(this).closest('tr').find('.price').val()) || 0;
            var amount = quantity * price;
            $(this).closest('tr').find('.amount').val(amount.toFixed(2));
        }

        $('#saveQuoteOptionLineService').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('quote.quote_option_line_services.store') }}";
            var type = "POST";
            var data = {
                quote_service_id: $('#quote_service_id').val(),
                services: []
            };
            // Loop through each row and construct product data
            $('#optionLineServiceForm tbody tr').each(function() {
                var row = $(this);
                var service = {
                    service_id: row.find('input[name="service_id[]"]').val(),
                    description: row.find('input[name="description[]"]').val(),
                    is_sold_as: row.find('input[name="is_sold_as[]"]').is(':checked') ? 1 : 0,
                    quantity: row.find('input[name="quantity[]"]').val(),
                    unit_price: row.find('input[name="unit_price[]"]').val(),
                    amount: row.find('input[name="amount[]"]').val()
                };
                data.services.push(service); // Push each product to the array
            });
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#optionLineServiceForm').trigger("reset");
                        sending(button, true);
                        $('#addOptionLineServiceModel').modal('hide');
                        showToast('success', response.msg);
                        table_quote_line.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        function showOptionLineService($id) {
            var url = "{{ route('quote.option_line_service_lists', ':id') }}".replace(':id', $id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        var service = response.data;
                        var rowIndex = $('#option_line_quote_service tr').length + 1;
                        service.forEach(function(data) {
                            var row = `<tr>
                        <td><span style="font-size: 8pt;">${data.service_name}</span><div class="d-flex align-items-center mt-1"><input type="hidden" class="form-control" name="service_id[]" value="${data.service_id}" readonly><input type="checkbox" class="form-check-input me-2" name="is_sold_as[]" ${data.is_sold_as ? 'checked' : ''}><label class="text-dark fw-bold me-2 mb-0" style="font-size: 7pt;">Sold As:</label><input type="text" class="form-control form-control-sm" name="description[]" value="${data.description || ''}" placeholder="description"></div><span class="text-danger error-text service_id_error"></span></td>
                        <td><input type="number" readonly class="form-control form-control-sm quantity" name="quantity[]" value="${data.quantity}" style="width: 100px;"></td>
                        <td><div class="d-flex align-items-center"><span class="me-1">$</span><input type="number" class="form-control price form-control-sm" name="unit_price[]" value="${data.unit_price || 0}" style="width: 100px;"></div></td>
                        <td><div class="d-flex align-items-center"><span class="me-2">$</span><input type="text" class="form-control form-control-sm amount" name="amount[]" value="${data.amount || 0}" readonly style="width: 100px;"></div><span class="text-danger error-text amount_error"></span></td>
                        <td><button type="button" class="btn btn-border p-0 d-flex align-items-center justify-content-center delete-option-line-quote-product" style="width: 30px; height: 30px;" data-id="${data.id}"><i class="fi fi-rr-cross-circle text-danger fw-bold fs-4 "></i></button></td>
                         </tr>`;
                            $('#option_line_quote_service').append(row);
                        });
                        calculateServiceAmount();
                        $('.service_checkbox[data-id="' + $id + '"]').prop('disabled', true);
                    } else {
                        // $('#option_line_quote_service').html('<tr><td colspan="5" class="text-center">No Services found.</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseJSON);
                    alert('An error occurred while fetching the product.');
                }
            });
        }

        // Delete option line product and remove the row from the table
        $('body').on('click', '.delete-option-line-quote-product', function() {
            var id = $(this).closest('button').data('id');
            var row = $(this).closest('tr');

            confirmDelete(id, function() {
                deleteOptionLineQuoteProduct(id, row);
            });
        });

        // Function to delete option line product
        function deleteOptionLineQuoteProduct(id, row) {
            var url = "{{ route('quote.quote_option_line_services.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, '');
                    row.remove();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }
        //end Service option line

        // product price calculator
        $(document).on('click', '.productPriceCalculator', function() {
            $('#productPriceCalculatorForm').trigger("reset");
            var quoteProductId = $(this).data('id');
            var productName = $(this).data('name');
            var productQty = $(this).data('quantity');
            var uom = $(this).data('uom');
            $('#productPriceCalculatorForm #quote_product_id').val(quoteProductId);
            $('#productPriceCalculatorName').text(productName);
            $('#productPriceCalculatorForm #product_charges').val(productQty);
            $('#productPriceCalculatorForm .uom').text(uom);
            $('#productPriceCalculatorForm #fab_other').val(productQty);
            $('#productPriceCalculatorForm #total_quote_slab').val(productQty);
            showPriceCalculator(quoteProductId);
            $('#addProductPriceCalculatorModel').modal('show');
        });
        // end product Price calculator

        //search supplier
        $(document).on('change', '.search_supplier', function() {
            var id = $(this).val();
            var url = "{{ route('quote.supplier_detail', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.data) {
                        var phone = response.data.mobile || response.data.primary_phone || response.data.secondary_phone || '';
                        var email = response.data.email || '';
                        $('#phone').text(phone);
                        $('#email').text(email);
                    } else {
                        alert('No data found for the selected supplier.');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseJSON);
                    alert('An error occurred while fetching the supplier details.');
                }
            });
        });
        //end search supplier

        //inscrease and decrease
        $(document).on('click', '.fi-rr-minus, .fi-rr-plus', function() {
            var input = $(this).siblings('input[name="slabs[]"]');
            var currentValue = parseInt(input.val()) || 0;
            var isMinus = $(this).hasClass('fi-rr-minus');

            if (isMinus && currentValue > 0) {
                input.val(currentValue - 1);
            } else if (!isMinus) {
                input.val(currentValue + 1);
            }
            // Trigger the calculation after changing the slabs value
            triggerCalculation($(this).closest('tr'));
        });
        //end inscrease and decrease

        //add row
        $(document).on('click', '#add_row', function() {
            var newRow = `
        <tr>
            <td><input type="text" class="form-control form-control-sm" name="serial_number[]" id="serial_number[]"></td>
            <td><input type="text" class="form-control form-control-sm" name="lot_name[]" id="lot_name[]"></td>
            <td><input type="text" class="form-control form-control-sm" name="bundle[]" id="bundle[]"></td>
            <td><div class="d-flex align-items-center"><input type="text" class="form-control form-control-sm" name="length[]" id="length[]"><span class="mx-1" style="font-size:8pt">X</span><input type="text" class="form-control form-control-sm" name="width[]" id="width[]"></div></td>
            <td><div class="d-flex align-items-center gap-1 text-primary fw-bold"><i class="fi fi-rr-minus" style="cursor: pointer;"></i><input type="number" class="form-control form-control-sm" name="slabs[]" id="slabs[]" value="0"><i class="fi fi-rr-plus" style="cursor: pointer;"></i></div></td>
            <td><input type="text" class="form-control form-control-sm" readonly name="area[]" id="area[]"></td>
            <td><input type="text" class="form-control form-control-sm" name="unit_cost[]" id="unit_cost[]"></td>
            <td><input type="text" class="form-control form-control-sm" readonly name="amount[]" id="amount[]"></td>
            <td><input type="text" class="form-control form-control-sm" name="notes[]" id="notes[]"></td>
            <td><div class="d-flex gap-2" style="font-size:9pt"><span class="text-primary fw-bold copy_previous_data"><i class="fi fi-rr-arrow-turn-down-left"></i></span><i class="fi fi-rr-cross text-danger fw-bold" style="cursor: pointer;" onclick="$(this).closest('tr').remove();"></i></div></td>
        </tr>`;
            $('#product_price_calculator').append(newRow);
        });
        //end add row

        //copy previous data
        $(document).on('click', '.copy_previous_data', function() {
            var currentRow = $(this).closest('tr');
            var previousRow = currentRow.prev('tr');
            if (previousRow.length > 0) {
                currentRow.find('input').each(function() {
                    var inputName = $(this).attr('name');
                    if (inputName) {
                        var previousValue = previousRow.find(`input[name="${inputName}"]`).val();
                        $(this).val(previousValue);
                    }
                });
            } else {
                alert('No previous row to copy data from.');
            }
        });

        //unit cost calculation
        $(document).on('change', '#supplier_unit_cost', function() {
            var unitCost = parseFloat($(this).val()) || 0;
            $('input[name="unit_cost[]"]').each(function() {
                $(this).val(unitCost);
                var row = $(this).closest('tr');
                var area = parseFloat(row.find('input[name="area[]"]').val()) || 0;
                var amount = unitCost * area;
                row.find('input[name="amount[]"]').val(amount.toFixed(2));
            });
            updateSubtotals();
            calculateTax();
            totalCostCalculation();
            wastagesCalculation();
        });
        //end unit cost calculation

        //area calculation
        $(document).on('input', 'input[name="length[]"], input[name="width[]"], input[name="slabs[]"], input[name="unit_cost[]"]', function() {
            var parent = $(this).closest('tr');
            triggerCalculation(parent);
        });

        // Function to calculate area and extended values
        function triggerCalculation(parent) {
            var length = parseFloat(parent.find('input[name="length[]"]').val()) || 0;
            var width = parseFloat(parent.find('input[name="width[]"]').val()) || 0;
            var slabs = parseFloat(parent.find('input[name="slabs[]"]').val()) || 1;
            var unitCost = parseFloat(parent.find('input[name="unit_cost[]"]').val()) || 0;
            var area = ((length * width) / 144) * slabs;
            var amount = unitCost * area;
            parent.find('input[name="area[]"]').val(area.toFixed(2));
            parent.find('input[name="amount[]"]').val(amount.toFixed(2));
            updateSubtotals();
            calculateTax();
            totalCostCalculation();
            wastagesCalculation();
        }

        // Update extended whenever unit_cost[] changes
        $(document).on('input', 'input[name="unit_cost[]"]', function() {
            var parent = $(this).closest('tr');
            var area = parseFloat(parent.find('input[name="area[]"]').val()) || 0;
            var unitCost = parseFloat($(this).val()) || 0;
            var amount = unitCost * area;
            parent.find('input[name="amount[]"]').val(amount.toFixed(2));
            updateSubtotals();
            calculateTax();
            totalCostCalculation();
            wastagesCalculation();
        });
        //end area calculation

        //sub total
        function updateSubtotals() {
            var totalArea = 0;
            var totalExtended = 0;
            $('input[name="area[]"]').each(function() {
                var area = parseFloat($(this).val()) || 0;
                totalArea += area;
            });
            $('input[name="amount[]"]').each(function() {
                var amount = parseFloat($(this).val()) || 0;
                totalExtended += amount;
            });
            $('#subtotal_area').val(totalArea.toFixed(2));
            $('#subtotal_extended').val(totalExtended.toFixed(2));
            wastagesCalculation();
        }
        //markup multiplier
        $(document).on('input', 'input[name="markup_multiplier"]', function() {
            var markupMultiplier = parseFloat($(this).val()) || 0;
            var subtotalExtended = parseFloat($('#subtotal_extended').val()) || 0;
            var markup = subtotalExtended * (markupMultiplier - 1);
            $('#total_markup_multiplier').val(markup.toFixed(2));
            totalCostCalculation();
        });
        //end markup multiplier

        //tax caluclation
        function calculateTax() {
            let amount = parseFloat($('#subtotal_extended').val()) || 0;
            let taxRate = parseFloat($('#tax_amount').val()) || 0;
            let totalTaxAmount = (amount * taxRate) / 100;
            $('#total_tax_amount').val(totalTaxAmount.toFixed(2));
        }

        $(document).on('change', '#tax_id', function() {
            var id = $(this).val();
            var url = "{{ route('quote.tax_amount', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.data) {
                        $('#tax_amount').val(response.data);
                        calculateTax(); // Recalculate tax whenever the tax rate changes
                        totalCostCalculation();
                    } else {
                        alert('No data found for the selected tax.');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseJSON);
                    alert('An error occurred while fetching the tax details.');
                }
            });
        });
        //end tax calculation

        //calculate total
        function totalCostCalculation() {
            let totalExtended = parseFloat($('#subtotal_extended').val()) || 0;
            let markupMultipler = parseFloat($('#total_markup_multiplier').val()) || 0;
            let TaxAmount = parseFloat($('#total_tax_amount').val()) || 0;
            let addtionCharges = parseFloat($('#additional_charges').val()) || 0;
            let deliveryCharges = parseFloat($('#delivery_charges').val()) || 0;
            let totalCost = totalExtended + markupMultipler + TaxAmount + addtionCharges + deliveryCharges;
            $('#total_cost').val(totalCost.toFixed(2));
        }

        $(document).on('change', '#additional_charges', function() {
            totalCostCalculation();
        });
        $(document).on('change', '#delivery_charges', function() {
            totalCostCalculation();
        });

        //copy total
        $(document).on('click', '#copy_total', function() {
            let total = parseFloat($('#total_cost').val()) || 0;
            let productChargesAmount = parseFloat($('#product_charges_amount').val()) || 0;
            let productCharges = parseFloat($('#product_charges').val()) || 0;
            let amount = total / productCharges;
            if (total < productChargesAmount) {
                $('#warning-message').html(`
              <div class="col text-end text-danger">
            <label class="d-block">Calculated Cost $${total.toFixed(2)} < $${productChargesAmount.toFixed(2)} Current Quoted Price</label>
               <div class="form-check d-flex justify-content-end align-items-center">
                <input class="form-check-input me-2" type="checkbox" id="overrideCheckbox">
               <label class="form-check-label" for="overrideCheckbox">
               I still want to reduce my Selling Price
              </label>
           </div>
           </div>`);
            } else {
                $('#product_charges_amount').val(amount.toFixed(4));
                $('#product_charges_total').val(total.toFixed(4));
                totalPriceAmountCalculation();
                totalPriceCalculation();
            }
        });

        $(document).on('change', '#overrideCheckbox', function() {
            if ($(this).is(':checked')) {
                let total = parseFloat($('#total_cost').val()) || 0;
                let productCharges = parseFloat($('#product_charges').val()) || 0;
                let amount = total / productCharges;
                $('#product_charges_amount').val(amount.toFixed(4));
                $('#product_charges_total').val(total.toFixed(4));
                $('#warning-message').empty();
                totalPriceAmountCalculation();
                totalPriceCalculation();
            } else {

            }
        });
        //end copy total

        //calculate Product Charges
        $(document).on('change', '#product_charges_amount', function() {
            let amount = parseFloat($(this).val()) || 0;
            let productCharges = $('#product_charges').val();
            let total = amount * productCharges || 0;
            $('#product_charges_total').val(total.toFixed(4));
            totalPriceAmountCalculation();
            totalPriceCalculation();
        });

        //calculate Fab/Other
        $(document).on('change', '#fab_other_amount', function() {
            let amount = parseFloat($(this).val()) || 0;
            let fabOthers = $('#fab_other').val();
            let total = amount * fabOthers || 0;
            $('#fab_other_total').val(total.toFixed(4));
            totalPriceAmountCalculation();
            totalPriceCalculation();
        });

        //Total Price Amount calculation
        function totalPriceAmountCalculation() {
            let productCharges = $('#product_charges_amount').val();
            let fabOthers = $('#fab_other_amount').val();
            let total = (parseFloat(productCharges) + parseFloat(fabOthers)) || 0;
            $('#total_quote_price').val(total.toFixed(4));
        }
        //end Total Price Amount calculation

        //Total Price calculation
        function totalPriceCalculation() {
            let productChargesTotal = $('#product_charges_total').val();
            let fabOthersTotal = $('#fab_other_total').val();
            let total = (parseFloat(productChargesTotal) + parseFloat(fabOthersTotal)) || 0;
            $('#quote_total').val(total.toFixed(4));
        }
        //end Total Price calculation

        //calculate Wastage
        function wastagesCalculation() {
            let subtotalSlab = $('#subtotal_area').val() || 0;
            let quoteSlabs = $('#product_charges').val() || 0;
            let wastage = (subtotalSlab - quoteSlabs);
            if (wastage > 0) {
                $('#wastage_amount').val(wastage.toFixed(2));
                let percentage = (wastage / subtotalSlab) * 100;
                $('#wastage_percentage').val(percentage.toFixed(2));
            }
        }
        wastagesCalculation();

        //save price caluctaor from cost
        $('#productPriceCalculatorForm input, #productPriceCalculatorForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#savePriceCalculatorBtn').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('quote.price_calculator_store') }}";
            var type = "POST";
            var data = {
                supplier_id: $('#productPriceCalculatorForm #supplier_id').val(),
                quote_product_id: $('#productPriceCalculatorForm #quote_product_id').val(),
                supplier_unit_cost: $('#productPriceCalculatorForm #supplier_unit_cost').val(),
                subtotal_area: $('#subtotal_area').val(),
                subtotal_extended: $('#subtotal_extended').val(),
                markup_multiplier: $('#markup_multiplier').val(),
                total_markup_multiplier: $('#total_markup_multiplier').val(),
                tax_id: $('#tax_id').val(),
                tax_amount: $('#tax_amount').val(),
                total_tax_amount: $('#total_tax_amount').val(),
                additional_charges: $('#additional_charges').val(),
                delivery_charges: $('#delivery_charges').val(),
                total_cost: $('#total_cost').val(),
                product_charges: $('#product_charges').val(),
                product_charges_amount: $('#product_charges_amount').val(),
                product_charges_total: $('#product_charges_total').val(),
                fab_other: $('#fab_other').val(),
                fab_other_amount: $('#fab_other_amount').val(),
                fab_other_total: $('#fab_other_total').val(),
                total_quote_slab: $('#total_quote_slab').val(),
                total_quote_price: $('#total_quote_price').val(),
                quote_total: $('#quote_total').val(),
                wastage_amount: $('#wastage_amount').val(),
                wastage_percentage: $('#wastage_percentage').val(),
                internal_notes: $('#internal_notes').val(),
                products: [] // Initialize products array
            };
            $('#productPriceCalculatorForm tbody tr').each(function() {
                var row = $(this);
                var product = {
                    serial_number: row.find('input[name="serial_number[]"]').val(),
                    lot_name: row.find('input[name="lot_name[]"]').val(),
                    bundle: row.find('input[name="bundle[]"]').val(),
                    length: row.find('input[name="length[]"]').val(),
                    width: row.find('input[name="width[]"]').val(),
                    slabs: row.find('input[name="slabs[]"]').val(),
                    unit_cost: row.find('input[name="unit_cost[]"]').val(),
                    amount: row.find('input[name="amount[]"]').val(),
                    notes: row.find('input[name="notes[]"]').val(),
                };
                data.products.push(product);
            });
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#productPriceCalculatorForm').trigger("reset");
                        sending(button, true);
                        $('#addProductPriceCalculatorModel').modal('hide');
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
        //end item line

        //show price calculator
        function showPriceCalculator($id) {
            var url = "{{ route('quote.price_calculator_show', ':id') }}".replace(':id', $id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success' && response.data.price_calculator) {
                        let price = response.data.price_calculator;
                        $('#productPriceCalculatorForm #supplier_id').val(price.supplier_id);
                        $('#productPriceCalculatorForm #quote_product_id').val(price.quote_product_id);
                        $('#productPriceCalculatorForm #supplier_unit_cost').val(price.supplier_unit_cost);
                        $('#subtotal_area').val(price.subtotal_area);
                        $('#subtotal_extended').val(price.subtotal_extended);
                        $('#markup_multiplier').val(price.markup_multiplier);
                        $('#total_markup_multiplier').val(price.total_markup_multiplier);
                        $('#tax_id').val(price.tax_id);
                        $('#tax_amount').val(price.tax_amount);
                        $('#total_tax_amount').val(price.total_tax_amount);
                        $('#additional_charges').val(price.additional_charges);
                        $('#delivery_charges').val(price.delivery_charges);
                        $('#total_cost').val(price.total_cost);
                        $('#product_charges').val(price.product_charges);
                        $('#product_charges_amount').val(price.product_charges_amount);
                        $('#product_charges_total').val(price.product_charges_total);
                        $('#fab_other').val(price.fab_other);
                        $('#fab_other_amount').val(price.fab_other_amount);
                        $('#fab_other_total').val(price.fab_other_total);
                        $('#total_quote_slab').val(price.total_quote_slab);
                        $('#total_quote_price').val(price.total_quote_price);
                        $('#quote_total').val(price.quote_total);
                        $('#wastage_amount').val(price.wastage_amount);
                        $('#wastage_percentage').val(price.wastage_percentage);
                        $('#internal_notes').val(price.internal_notes);
                        let inventory = response.data.inventory;
                        $('#product_price_calculator').empty();
                        inventory.forEach(function(data, index) {
                            var row = `
                        <tr>
                            <td><input type="text" class="form-control form-control-sm" name="serial_number[]" value="${data.serial_number}"></td>
                            <td><input type="text" class="form-control form-control-sm" name="lot_name[]" value="${data.lot_name}"></td>
                            <td><input type="text" class="form-control form-control-sm" name="bundle[]" value="${data.bundle}"></td>
                            <td><div class="d-flex align-items-center"><input type="text" class="form-control form-control-sm" name="length[]" value="${data.length}"><span class="mx-1" style="font-size:8pt">X</span><input type="text" class="form-control form-control-sm" name="width[]" value="${data.width}"></div></td>
                            <td><div class="d-flex align-items-center gap-1 text-primary fw-bold"><i class="fi fi-rr-minus" style="cursor: pointer;"></i><input type="number" class="form-control form-control-sm" name="slabs[]" value="${data.slabs}"><i class="fi fi-rr-plus" style="cursor: pointer;"></i></div></td>
                            <td><input type="text" class="form-control form-control-sm" readonly name="area[]" value="${data.area}"></td>
                            <td><input type="text" class="form-control form-control-sm" name="unit_cost[]" value="${data.unit_cost}"></td>
                            <td><input type="text" class="form-control form-control-sm" readonly name="amount[]" value="${data.amount}"></td>
                            <td><input type="text" class="form-control form-control-sm" name="notes[]" value="${data.notes}"></td>
                            <td><div class="d-flex gap-2 text-danger fw-bold" style="font-size:9pt"><span class="text-primary fw-bold copy_previous_data"><i class="fi fi-rr-arrow-turn-down-left"></i></span><i class="fi fi-rr-cross-circle text-danger fw-bold fs-4 deletePriceInventory" style="cursor: pointer;" data-id="${data.id}"></i></div></td>
                        </tr>`;
                            $('#product_price_calculator').append(row);
                        });
                    } else {
                        // alert('No data found.');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseJSON);
                    alert('An error occurred while fetching the product.');
                }
            });
        }
        //end show price calculator

        //delete Price Inventory
        $('body').on('click', '.deletePriceInventory', function() {
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            confirmDelete(id, function() {
                deleteProductPriceInventory(id, row);
            });
        });

        function deleteProductPriceInventory(id, row) {
            var url = "{{ route('quote.price_calculator_inventory_delete', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, '');
                    row.remove();
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }
        //end delete Price Inventory
    });
</script>