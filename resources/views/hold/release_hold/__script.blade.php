<script type="text/javascript">
    $(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function calculateTotals() {
            var subtotal = 0;
            var tax_subtotal = 0;
            var taxRate = parseFloat($('#tax_code_amount').val()) || 0;
            $('.product-amount').each(function() {
                var amount = parseFloat($(this).val()) || 0;
                subtotal += amount;
                tax_subtotal += amount;
            });
            $('.service-amount').each(function() {
                var amount = parseFloat($(this).val()) || 0;
                subtotal += amount;
                if ($(this).closest('tr').find('.tax-check').is(':checked')) {
                    tax_subtotal += amount;
                }
            });
            var tax = (tax_subtotal * taxRate) / 100;
            var total = subtotal + tax;
            $('#hold_sub_total').html('$' + subtotal.toFixed(2));
            $('#tax_code_amount_label').html('$' + tax.toFixed(2));
            $('#hold_total').html('$' + total.toFixed(2));
            $('#total').val(total.toFixed(2));
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

        // Attach change event to service select dropdowns
        $(document).on('change', 'select[name="service_id[]"]', function() {
            var id = $(this).val();
            var row = $(this).closest('tr');
            var priceInput = row.find('.service-unit-price');
            var quantityInput = row.find('.service-quantity');
            quantityInput.val(1);
            var amountInput = row.find('.service-amount');
            var url = "{{ route('products.get_service_price') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response && response.status === 'success' && response.data) {
                        priceInput.val(response.data.unit_price);
                        var quantity = quantityInput.val() || 0;
                        amountInput.val((quantity * response.data.unit_price).toFixed(2));
                        calculateTotals();
                    } else {
                        alert('Failed to fetch service price');
                        priceInput.val('');
                        amountInput.val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while fetching service price.');
                    priceInput.val('');
                    amountInput.val('');
                }
            });
        });

        $('#saveReleaseHoldBtn').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);

            var formData = new FormData($('#releaseHoldForm')[0]);

            // Group product data
            var products = [];
            $('#releaseHoldForm #holdProductDataTable tbody tr').each(function() {
                var row = $(this);
                products.push({
                    hold_product_id: row.find('input[name="hold_product_id[]"]').val(),
                    product_id: row.find('input[name="product_id[]"]').val(),
                    product_quantity: parseFloat(row.find('input[name="product_quantity[]"]').val()) || 0,
                    product_unit_price: parseFloat(row.find('input[name="product_unit_price[]"]').val()) || 0,
                    product_amount: parseFloat(row.find('input[name="product_amount[]"]').val()) || 0
                });
            });
            formData.append('hold_products', JSON.stringify(products));

            // Group service data
            var services = [];
            $('#releaseHoldForm #holdServiceDataTable tbody tr').each(function() {
                var row = $(this);
                services.push({
                    hold_service_id: row.find('input[name="hold_service_id[]"]').val(),
                    service_id: row.find('select[name="service_id[]"]').val(),
                    service_description: row.find('input[name="service_description[]"]').val(),
                    service_quantity: parseFloat(row.find('input[name="service_quantity[]"]').val()) || 0,
                    service_unit_price: parseFloat(row.find('input[name="service_unit_price[]"]').val()) || 0,
                    service_amount: parseFloat(row.find('input[name="service_amount[]"]').val()) || 0,
                    is_tax: row.find('input[name="is_tax[]"]').prop('checked') ? 1 : 0
                });
            });
            formData.append('hold_services', JSON.stringify(services));

            // Additional fields
            var releaseHoldReason = $('#releaseHoldForm #release_hold_reason:checked').val();
            if (releaseHoldReason) {
                formData.append('release_hold_reason', releaseHoldReason);
            }
            formData.append('release_date', $('#releaseHoldForm #release_date').val());

            // // Debugging the data
            // console.log("FormData values:");
            // for (var pair of formData.entries()) {
            //     console.log(pair[0] + ': ' + pair[1]);
            // }

            // Send the AJAX request
            var url = "{{ route('hold.update_release') }}";
            $.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status === "success") {
                        $('#holdProductForm').trigger("reset");
                        sending(button, true);
                        showToast('success', response.msg);
                        window.location.href = "{{ route('hold.holds.show', ':id') }}".replace(':id', $('#hold_id').val());
                    } else {
                        sending(button, true);
                        showToast('error', 'Failed to save the visit data.');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

    });
</script>