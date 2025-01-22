<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_sample_order = $('#datatablesSampleOrder').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('create.list') }}",
                data: function(d) {
                    // Pass additional parameters if needed
                }
            },
            columns: [{
                    data: 'date_time',
                    name: 'date_time'
                },
                {
                    data: 'opportunity',
                    name: 'opportunity'
                },
                {
                    data: 'job_name',
                    name: 'job_name'
                },
                {
                    data: 'bill_customer',
                    name: 'bill_customer'
                },
                {
                    data: 'company',
                    name: 'company'
                },
                {
                    data: 'sales_person',
                    name: 'sales_person'
                },
                {
                    data: 'notes',
                    name: 'notes'
                }
            ],

            rowCallback: function(row, data) {
                $(row).on('click', function() {
                    const id = data.opportunity_id;
                    $('#searchListSampleOrderModel').modal('show');
                    $('#opportunity_id').val(id);
                    // Ensure any existing instance of the table is destroyed
                    if ($.fn.DataTable.isDataTable('#sampleOrderListDataTable')) {
                        $('#sampleOrderListDataTable').DataTable().clear().destroy();
                    }
                    // Reinitialize the table with the new ID
                    initializeSampleOrderListTable(id);
                });
            }
        });

        function initializeSampleOrderListTable(id) {
            $('#sampleOrderListDataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('create.list_all', ':id') }}".replace(':id', id),
                    data: function(d) {
                        // Add any additional data if needed
                    }
                },
                columns: [{
                        data: 'date_time',
                        name: 'date_time'
                    },
                    {
                        data: 'sample_order',
                        name: 'sample_order'
                    },
                    {
                        data: 'sample_order_label',
                        name: 'sample_order_label'
                    },
                    {
                        data: 'day',
                        name: 'day'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'printed_notes',
                        name: 'printed_notes'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                columnDefs: [{
                    targets: 4,
                    width: '250px',
                    className: 'text-center',
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).css('width', '250px');
                    }
                }],
                rowCallback: function(row, data) {}
            });
        }

    });
</script>