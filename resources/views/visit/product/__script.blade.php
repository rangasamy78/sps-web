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
                    name: 'bundle',
                },
                {
                    data: 'supp_ref',
                    name: 'supp_ref',
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                },
                {
                    data: 'current_qty',
                    name: 'current_qty',
                },
                {
                    data: 'unit_price',
                    name: 'unit_price',
                },
                {
                    data: 'amount',
                    name: 'amount',
                },
                {
                    data: 'tax',
                    name: 'tax',
                },
                {
                    data: 'action',
                    name: 'action',
                }
            ],
            "columnDefs": [{
                    "targets": 0,
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css('font-size', '13px'); // Set the font size to 18px
                    }
                },
                {
                    "targets": 1, // Targeting the second column (index 1)
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).css('font-size', '14px'); // Set the font size to 14px
                    }
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).addClass('row-' + data.id);
            },
        });

    });
</script>