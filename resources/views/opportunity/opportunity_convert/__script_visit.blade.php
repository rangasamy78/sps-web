<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function calculateTotals() {
            let subtotal = 0;
            let taxSubtotal = 0;
            const taxRate = parseFloat($('#tax_code_amount').val()) || 0;

            // Iterate over visible rows in the DataTable
            $('#convertVisitDatatable tbody tr').each(function() {
                const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
                const quantity = parseFloat($(this).find('.quantity').val()) || 0;
                const isTaxChecked = $(this).find('.tax').is(':checked'); // Check if tax is applied
                const rowTotal = unitPrice * quantity;

                subtotal += rowTotal;
                if (isTaxChecked) {
                    taxSubtotal += rowTotal;
                }
                // Update row-specific amount
                $(this).find('.amount').val(rowTotal.toFixed(2));
            });

            // Calculate tax and total
            const tax = (taxSubtotal * taxRate) / 100;
            const total = subtotal + tax;

            // Update UI
            $('#sub_total').html('$' + subtotal.toFixed(2));
            $('#tax_code_amount_label').html('$' + tax.toFixed(2));
            $('#grand_total').html('$' + total.toFixed(2));
            $('#total').val(total.toFixed(2));
        }
        calculateTotals();
        // Update amount on quantity or unit price change
        $(document).on('input', '.quantity, .unit-price', function() {
            const $row = $(this).closest('tr');
            const quantity = parseFloat($row.find('.quantity').val()) || 0;
            const price = parseFloat($row.find('.unit-price').val()) || 0;
            const amount = quantity * price;

            $row.find('.amount').val(amount.toFixed(2));
            calculateTotals();
        });

        // Delegate change events for dynamically added elements
        $('#convertVisitDatatable').on('change', '.tax, .quantity, .unit-price', function() {
            calculateTotals();
        });

        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            calculateTotals();
        });

        $('#saveCreateVisit').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);

            // Create FormData object with form data
            var formData = new FormData($('#formAddConvertNewVisit')[0]);

            // Collect product data
            $('#convertVisitDatatable tbody tr.product-row').each(function(index) {
                var row = $(this);
                formData.append(`visit_products[${index}][product_id]`, row.find('input[name="product_id[]"]').val());
                formData.append(`visit_products[${index}][is_sold_as]`, row.find('input[name="is_sold_as[]"]').prop('checked') ? 1 : 0);
                formData.append(`visit_products[${index}][product_description]`, row.find('input[name="product_description[]"]').val());
                formData.append(`visit_products[${index}][product_quantity]`, parseFloat(row.find('input[name="product_quantity[]"]').val()) || 0);
                formData.append(`visit_products[${index}][product_unit_price]`, parseFloat(row.find('input[name="product_unit_price[]"]').val()) || 0);
                formData.append(`visit_products[${index}][product_amount]`, parseFloat(row.find('input[name="product_amount[]"]').val()) || 0);
                formData.append(`visit_products[${index}][is_tax]`, row.find('input[name="is_tax[]"]').prop('checked') ? 1 : 0);
            });

            // Collect visible service data
            $('#convertVisitDatatable tbody tr.service-row').each(function(index) {
                var row = $(this);
                formData.append(`visit_services[${index}][service_id]`, row.find('input[name="service_id[]"]').val());
                formData.append(`visit_services[${index}][service_description]`, row.find('input[name="service_description[]"]').val());
                formData.append(`visit_services[${index}][service_quantity]`, parseFloat(row.find('input[name="service_quantity[]"]').val()) || 0);
                formData.append(`visit_services[${index}][service_unit_price]`, parseFloat(row.find('input[name="service_unit_price[]"]').val()) || 0);
                formData.append(`visit_services[${index}][service_amount]`, parseFloat(row.find('input[name="service_amount[]"]').val()) || 0);
                formData.append(`visit_services[${index}][is_tax]`, row.find('input[name="is_tax[]"]').prop('checked') ? 1 : 0);
            });

            // for (var pair of formData.entries()) {
            //     console.log(pair[0] + ": " + pair[1]);
            // }
            // AJAX request
            var url = "{{ route('convert.save_convert_visit') }}";
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
                    sending(button, true);
                    if (response.status === "success") {
                        $('#formAddConvertNewVisit').trigger("reset");
                        showToast('success', response.msg);
                        window.location.href = "{{ route('visits.show', ':id') }}".replace(':id', response.visit_id);
                    } else {
                        showToast('error', 'Failed to save the visit.');
                    }
                },

                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

    });
</script>