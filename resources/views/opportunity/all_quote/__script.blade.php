<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_quote = $('#datatablesQuote').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('quote.list') }}",
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
                    $('#searchListQuoteModel').modal('show');
                    $('#opportunity_id').val(id);
                    // Ensure any existing instance of the table is destroyed
                    if ($.fn.DataTable.isDataTable('#quoteListDataTable')) {
                        $('#quoteListDataTable').DataTable().clear().destroy();
                    }
                    // Reinitialize the table with the new ID
                    initializeQuoteListTable(id);
                });
            }
        });

        function initializeQuoteListTable(id) {
            $('#quoteListDataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('quote.list_all', ':id') }}".replace(':id', id),
                    data: function(d) {
                        // Add any additional data if needed
                    }
                },
                columns: [{
                        data: 'date_time',
                        name: 'date_time'
                    },
                    {
                        data: 'quote',
                        name: 'quote'
                    },
                    {
                        data: 'customer_po',
                        name: 'customer_po'
                    },
                    {
                        data: 'projectType',
                        name: 'projectType'
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
                        data: 'expiry_date',
                        name: 'expiry_date'
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
                        targets: 5,
                        width: '250px',
                        className: 'text-center',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css('width', '250px !important');
                        }
                    },
                    {
                        targets: 3,
                        width: '200px',
                        className: 'text-center',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css('width', '200px !important');
                        }
                    }
                ],
                rowCallback: function(row, data) {
                    if (data.quoteStatus === 'close') {
                        $(row).addClass('table-warning');
                    }
                }
            });
        }

    });
</script>