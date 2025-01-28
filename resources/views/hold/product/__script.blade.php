<script type="text/javascript">
    $(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var $id = $('#hold_id').val();
        var table_hold = $('#holdProductDataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('hold.products.list',':id') }}".replace(':id', $('#hold_id').val()),
                type: 'GET',
                data: function(d) {},
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
                        $(td).css('font-size', '13px');
                    }
                },
                {
                    targets: 1,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).css('font-size', '14px');
                    }
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).addClass('row-' + data.id);
            },
            drawCallback: function(settings) {
                calculateTotals();
            }
        });

        function calculateTotals() {
            let subtotal = 0;
            let taxSubtotal = 0;
            const taxRate = parseFloat($('#tax_code_amount').val()) || 0;
            $('#holdProductDataTable tbody tr').each(function() {
                const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
                const taxApplicable = $(this).find('.tax').val();
                subtotal += unitPrice;
                if (taxApplicable == 1) {
                    taxSubtotal += unitPrice;
                }
            });
            const tax = (taxSubtotal * taxRate) / 100;
            const total = subtotal + tax;
            $('#hold_sub_total').html('$' + subtotal.toFixed(2));
            $('#tax_code_amount_label').html('$' + tax.toFixed(2));
            $('#hold_total').html('$' + total.toFixed(2));
        }

    });
</script>