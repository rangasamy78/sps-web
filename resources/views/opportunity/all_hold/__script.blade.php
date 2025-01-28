<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            var table_hold = $('#datatablesHold').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                order: [
                    [1, 'desc']
                ],
                ajax: {
                    url: "{{ route('hold.hold_list') }}",
                    data: function(d) {
                        sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                        d.order = [{
                            column: 1,
                            dir: sort
                        }];
                    }
                },
                columns: [{
                        data: 'add',
                        name: 'add'
                    },
                    {
                        data: 'hold_code',
                        name: 'hold_code'
                    },
                    {
                        data: 'opportunity',
                        name: 'opportunity'
                    },
                    {
                        data: 'hold_date',
                        name: 'hold_date'
                    },
                    {
                        data: 'expiry_date',
                        name: 'expiry_date'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'location_name',
                        name: 'location_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'notes',
                        name: 'notes'
                    }
                ],
                columnDefs: [{
                    targets: 7,
                    width: '250px',
                    className: 'text-center',
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).css('width', '250px');
                    }
                }],
                rowCallback: function(row, data, index) {
                    $(row).on('click', '.add_click', function() {
                        const id = $(this).data('hold-id');
                        $('#holdModalHeader').html(`List of Item for Hold #<span class="text-primary fw-bold">${data.hold_code}</span>`);
                        $('#taxCodeText').html(`Tax(${data.taxCode})`);
                        $('#tax_code_amount').val(data.taxAmount);
                        $('#searchListHoldModel').modal('show');
                        if ($.fn.DataTable.isDataTable('#holdProductListDataTable')) {
                            $('#holdProductListDataTable').DataTable().clear().destroy();
                        }
                        HoldProductListTable(id);
                    });
                },

            });
        });


        function HoldProductListTable(id) {
            $('#holdProductListDataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('hold.products.list', ':id') }}".replace(':id', id),
                    data: function(d) {
                        // Add any additional data if needed
                    }
                },
                columns: [{
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'serialNum',
                        name: 'serialNum'
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
                    }
                ],
                rowCallback: function(row, data) {},
                drawCallback: function(settings) {
                    calculateTotals();
                }
            });
        }

        function calculateTotals() {
            let subtotal = 0;
            let taxSubtotal = 0;
            const taxRate = parseFloat($('#tax_code_amount').val()) || 0;
            $('#holdProductListDataTable tbody tr').each(function() {
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