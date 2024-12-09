<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#formAddNewVisit input, #formAddNewVisit select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#nextStepAddProductBtn').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('visits.store') }}";
            var type = "POST";
            var data = $('#formAddNewVisit').serialize();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#formAddNewVisit').trigger("reset");
                        sending(button, true);
                        showToast('success', response.msg);
                        const url = "{{ route('visits.show_add_product', ':id') }}".replace(':id', response.visit_id);
                        window.location.href = url;
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
        //search product
        $('#searchProductBtn').click(function() {
            var table_search_product = $('#searchProductsTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('visits.search_product') }}",
                    type: 'GET',
                    data: function(d) {
                        d.name = $('#search_product_name_sku').val();
                        d.type = $('#search_product_type').val();
                        d.category = $('#search_category_type').val();
                        d.supplier = $('#search_supplier').val();
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
                var url = "{{ route('visits.get_product') }}";

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: dataId,
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.data) {
                            var product = response.data;
                            var rowIndex = $('#visit_product tr').length + 1;
                            var imageSrc = (rowIndex === 1) ? '{{ asset("public/images/import.png") }}' : '{{ asset("public/images/icon_import.png") }}';
                            var class_name = (rowIndex === 1) ? 'copy_all' : 'copy_down';
                            var row = `
            <tr>
                <td><span style="font-size: 8pt;">${product.product_name}</span><div class="d-flex align-items-center mt-1"><input type="hidden" class="form-control" name="product_id[]" id="product_id[]" value="${product.id}"><input type="checkbox" class="form-check-input me-2" id="is_sold_as[]" value="1" name="is_sold_as[]"><label class="text-dark fw-bold me-2 mb-0" style="font-size: 7pt;white-space: nowrap;">Sold As:</label><input type="text" class="form-control form-control-sm" value="" id="product_description[]" name="product_description[]" style="width: 80px;"></div><span class="text-danger error-text product_id_error"></span></td>
                <td><input type="number" class="form-control form-control-sm product-quantity" value="1" name="product_quantity[]" id="product_quantity[]" data-id="${product.id}" style="width: 80px;"></td>
                <td><div class="d-flex align-items-center"><span class="me-1">$</span><input type="number" class="form-control product-price form-control-sm" name="product_unit_price[]" id="product_unit_price[]" value="${product.price.homeowner_price || 0}" data-id="${product.id}" style="width: 80px;">
                    <img src="{{ asset('public/images/icon_additionalcharge.png') }}" class="me-1 product_price_list" alt="image not found" style="width: 20px; height: 20px;" data-id="${product.id}" id="product_price_list">
                    <img src="${imageSrc}" class="me-1 ${class_name}" alt="image not found" style="width: 20px; height: 20px;"></div></td>
                <td><div class="d-flex align-items-center"><span class="me-2">$</span><input type="text" class="form-control form-control-sm product-amount" id="product_amount[]" name="product_amount[]" value="${(product.price.homeowner_price || 0) * 1}" readonly style="width: 60px;"></div></td>
                <td><button type="button" class="btn btn-border p-0 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" value="${product.id}" data-id="${product.id}"><i class="fi fi-rr-cross text-danger fw-bold" style="font-size: 12px;"></i></button></td>
            </tr>`;
                            $('#visit_product').append(row);
                            // Recalculate totals after adding a new row
                            calculateTotals();
                        } else {
                            $('#visit_product').html('<tr><td colspan="5" class="text-center">No products found.</td></tr>');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseJSON);
                        alert('An error occurred while fetching the product.');
                    }
                });
            }
        });

        // Update the amount when quantity or price changes
        $(document).on('input', '.product-quantity, .product-price', function() {
            var quantity = parseFloat($(this).closest('tr').find('.product-quantity').val()) || 0;
            var price = parseFloat($(this).closest('tr').find('.product-price').val()) || 0;
            var amount = quantity * price;
            $(this).closest('tr').find('.product-amount').val(amount.toFixed(2));
            calculateTotals();
        });

        $(document).on('change', '.tax-check', function() {
            calculateTotals();
        });

        // Recalculate totals when a row is deleted
        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            calculateTotals();
        });

        //copy value 
        $('#visit_product').on('click', '.copy_down', function() {
            var currentRow = $(this).closest('tr');
            var prevRow = currentRow.prev('tr');
            var unitPrice = prevRow.find('.product-price').val();
            if (unitPrice) {
                currentRow.find('.product-price').val(unitPrice);
            }
        });

        $('#visit_product').on('click', '.copy_all', function() {
            var currentRow = $(this).closest('tr');
            var unitPrice = currentRow.find('.product-price').val();
            if (unitPrice) {
                currentRow.nextAll('tr').each(function() {
                    $(this).find('.product-price').val(unitPrice);
                });
                // Also update the service table rows with the same unit price
                $('#visit_service').find('tr').each(function() {
                    $(this).find('.service-unit-price').val(unitPrice);
                });
            }
        });

        // Function to calculate totals
        function calculateTotals() {
            var subtotal = 0;
            var tax_subtotal = 0;
            var taxRate = parseFloat($('#tax_code_amount').val()) || 0;
            $('.product-amount').each(function() {
                var amount = parseFloat($(this).val()) || 0;
                subtotal += amount;
                tax_subtotal += amount;
            });
            // Calculate service amounts
            $('.service-amount').each(function() {
                var amount = parseFloat($(this).val()) || 0;
                subtotal += amount;
                // Check if tax should be added for this row
                if ($(this).closest('tr').find('.tax-check').is(':checked')) {
                    tax_subtotal += amount;
                }
            });
            // Calculate the total tax for services where tax is applicable
            var tax = (tax_subtotal * taxRate) / 100;
            // Final total (subtotal + tax)
            var total = subtotal + tax;
            // Update the fields
            $('#visit_sub_total').html('$' + subtotal.toFixed(2));
            $('#tax_code_amount_label').html('$' + tax.toFixed(2));
            $('#visit_total').html('$' + total.toFixed(2));
        }
        calculateTotals();
        $(document).on('input', '.service-quantity, .service-unit-price', function() {
            var row = $(this).closest('tr');
            var quantity = parseFloat(row.find('.service-quantity').val()) || 0;
            var price = parseFloat(row.find('.service-unit-price').val()) || 0;
            var amount = quantity * price;
            // Update the amount in the same row
            row.find('.service-amount').val(amount.toFixed(2));
            calculateTotals();
        });

        //remove row
        $(document).on('click', 'button[data-id]', function() {
            $(this).closest('tr').remove();
            calculateTotals();
        });

        $(document).on('click', '#product_price_list', function() {
            $('#priceModal').modal('show');
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            var priceInput = row.find('.product-price');
            var quantityInput = row.find('.product-quantity');
            var amountInput = row.find('.product-amount');
            var url = "{{ route('visits.get_product_price') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response && response.status === 'success' && response.data) {
                        var prices = response.data;
                        var priceFields = {
                            price1: prices.homeowner_price,
                            price2: prices.bundle_price,
                            price3: prices.special_price,
                            price4: prices.loose_slab_price,
                            price5: prices.bundle_price_sqft,
                            price6: prices.special_price_per_sqft,
                            price7: prices.owner_approval_price,
                            price8: prices.loose_slab_per_slab,
                            price9: prices.bundle_price_per_slab,
                            price10: prices.special_price_per_slab,
                            price11: prices.owner_approval_price_per_slab,
                            price12: prices.price12
                        };
                        for (var fieldId in priceFields) {
                            $('#' + fieldId).html(priceFields[fieldId] || 'N/A');
                        }
                        // Add click listener to update the input field with selected price
                        $('#priceModal .modal-body span.price-clickable').off('click').on('click', function() {
                            var selectedPrice = parseFloat($(this).text().replace(/[^0-9.-]+/g, '')) || 0;
                            priceInput.val(selectedPrice);
                            $('#priceModal').modal('hide');
                            // Calculate and update the amount dynamically
                            var quantity = parseFloat(quantityInput.val()) || 0;
                            if (quantity > 0 && selectedPrice > 0) {
                                var amount = (selectedPrice * quantity).toFixed(2);
                                amountInput.val(amount);
                            } else {
                                amountInput.val('0.00');
                            }
                            calculateTotals();
                        });
                    } else {
                        alert('Error fetching price. Please try again.');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseJSON);
                    alert('An error occurred while fetching the product.');
                }
            });
        });

        // Function to collect form data and send it via AJAX
        $(document).ready(function() {
            $('#updateVisitProductBtn').click(function(e) {
                e.preventDefault();
                var button = $(this);
                sending(button);
                var formData = new FormData($('#updateVisitProductForm')[0]);
                $('#updateVisitProductForm #visit_product tbody tr').each(function(index) {
                    var row = $(this);
                    var productId = row.find('input[name="product_id[]"]').val();
                    if (productId) { // Only append if productId is not empty
                        formData.append(`visit_products[${index}][product_id]`, productId);
                        formData.append(`visit_products[${index}][is_sold_as]`, row.find('input[name="is_sold_as[]"]').prop('checked') ? 1 : 0);
                        formData.append(`visit_products[${index}][product_description]`, row.find('input[name="product_description[]"]').val());
                        formData.append(`visit_products[${index}][product_quantity]`, parseFloat(row.find('input[name="product_quantity[]"]').val()) || 0);
                        formData.append(`visit_products[${index}][product_unit_price]`, parseFloat(row.find('input[name="product_unit_price[]"]').val()) || 0);
                        formData.append(`visit_products[${index}][product_amount]`, parseFloat(row.find('input[name="product_amount[]"]').val()) || 0);
                    }
                });
                // Collect service data
                $('#updateVisitProductForm #visit_service tbody tr').each(function(index) {
                    var row = $(this);
                    var serviceId = row.find('select[name="service_id[]"]').val();
                    if (serviceId) { // Only append if serviceId is not empty
                        formData.append(`visit_services[${index}][service_id]`, serviceId);
                        formData.append(`visit_services[${index}][service_description]`, row.find('input[name="service_description[]"]').val());
                        formData.append(`visit_services[${index}][service_quantity]`, parseFloat(row.find('input[name="service_quantity[]"]').val()) || 0);
                        formData.append(`visit_services[${index}][service_unit_price]`, parseFloat(row.find('input[name="service_unit_price[]"]').val()) || 0);
                        formData.append(`visit_services[${index}][service_amount]`, parseFloat(row.find('input[name="service_amount[]"]').val()) || 0);
                        formData.append(`visit_services[${index}][is_tax]`, row.find('input[name="is_tax[]"]').prop('checked') ? 1 : 0);
                    }
                });
                // Construct the URL dynamically
                var url = "{{ route('visits.update_visit_product', ':id') }}".replace(':id', $('#visit_id').val());

                // Perform AJAX request
                $.ajax({
                    url: url,
                    type: "POST", // Use POST for Laravel's method spoofing
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT' // Spoof PUT method
                    },
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        console.log('Response:', response);

                        if (response.status === "success") {
                            $('#updateVisitProductForm').trigger("reset");
                            sending(button, true);
                            showToast('success', response.msg);
                            window.location.href = "{{ route('visits.show', ':id') }}".replace(':id', $('#visit_id').val());
                        } else {
                            sending(button, true);
                            showToast('error', response.msg || 'Failed to save the visit data.');
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.responseText);
                        handleAjaxError(xhr);
                        sending(button, true);
                    }
                });
            });
        });


        $('.btnClear').click(function() {
            var row = $(this).closest('tr');
            row.find('input, select').val('').prop('checked', false);
        });

        $('.reset_search').click(function() {
            $('#search_product_name_sku').val('');
            $('#search_product_type').val('').trigger('change');
            $('#search_category_type').val('').trigger('change');
            $('#search_supplier').val('').trigger('change');

        });

        $('#cancelVisitProductBtn').click(function() {
            const opportunityId = $('#opportunity_id').val();
            const url = "{{ route('opportunities.show', ':id') }}".replace(':id', opportunityId);
            window.location.href = url;
        });

        //delete visit product
        $('body').on('click', '.delete-visit-product', function() {
            var id = $(this).closest('button').data('id');
            confirmDelete(id, function() {
                deleteVisitProduct(id);
            });
        });

        function deleteVisitProduct(id) {
            var url = "{{ route('visits.delete_visit_product', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, '');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

    });
</script>