<script type="text/javascript">
    $(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var $id = $('#visit_id').val();
        var table_visit = $('#visitProductDataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('visits.list',':id') }}".replace(':id', $('#visit_id').val()),
                type: 'GET',
                data: function(d) {
                    // Optional data to be sent with the request
                },
            },
            columns: [{
                    data: 'item_name',
                    name: 'item_name',
                    orderable: false
                },
                {
                    data: 'slab',
                    name: 'slab'
                },
                {
                    data: 'serialNum',
                    name: 'serialNum'
                },
                {
                    data: 'location',
                    name: 'location'
                },
                {
                    data: 'barcode',
                    name: 'barcode'
                },
                {
                    data: 'lot',
                    name: 'lot'
                },
                {
                    data: 'bundle',
                    name: 'bundle'
                },
                {
                    data: 'supp_ref',
                    name: 'supp_ref'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'current_qty',
                    name: 'current_qty'
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
                    data: 'action',
                    name: 'action'
                }
            ],
            columnDefs: [{
                    targets: 0,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).css('font-size', '13px'); // Set font size
                    }
                },
                {
                    targets: 1,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).css('font-size', '14px'); // Set font size
                    }
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).addClass('row-' + data.id);
            },
            drawCallback: function(settings) {
                // Call the function to calculate totals after the table redraws
                calculateTotals();
            }
        });

        function calculateTotals() {
            let subtotal = 0;
            let taxSubtotal = 0;
            const taxRate = parseFloat($('#tax_code_amount').val()) || 0;
            // Iterate over visible rows in the DataTable
            $('#visitProductDataTable tbody tr').each(function() {
                const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
                const taxApplicable = $(this).find('.tax').val(1);
                subtotal += unitPrice;
                if (taxApplicable) {
                    taxSubtotal += unitPrice;
                }
            });
            const tax = (taxSubtotal * taxRate) / 100;
            const total = subtotal + tax;
            $('#visit_sub_total').html('$' + subtotal.toFixed(2));
            $('#tax_code_amount_label').html('$' + tax.toFixed(2));
            $('#visit_total').html('$' + total.toFixed(2));
        }
        $('#checkout').click(function() {
            var id = $(this).data('id');
            if (id) {
                $.ajax({
                    url: "{{ route('visits.checkout', ':id') }}".replace(':id', id),
                    type: 'PATCH',
                    data: {
                        checkout: 1,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            $('#checkout').hide();
                        } else {
                            alert('Failed to update opportunity stages: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating opportunity stages');
                    }
                });
            }
        });
    });
</script>