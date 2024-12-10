<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('batch_close_quotes.list') }}",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: null,
                    name: 'serial',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'opportunity_code',
                    name: 'opportunity_code'

                },
                {
                    data: 'opportunity_date',
                    name: 'opportunity_date'

                },
                {
                    data: 'ship_to_type',
                    name: 'ship_to_type'

                },
                {
                    data: 'close_quote',
                    name: 'close_quote',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function() {
                    // Attach the Select All checkbox behavior after drawing the table
                    $('input[type="checkbox"][name="opportunity_ids[]"]').on('change', function() {
                        var checkboxes = $('input[type="checkbox"][name="opportunity_ids[]"]');
                        var checkedCheckboxes = checkboxes.filter(':checked').length;
                        var totalCheckboxes = checkboxes.length;
                        // Update the #select-all checkbox state
                        if (checkedCheckboxes === totalCheckboxes) {
                            // All checkboxes are checked
                            $('#select-all').prop('checked', true).prop('indeterminate', false);
                        } else if (checkedCheckboxes > 0) {
                            // Some checkboxes are checked
                            $('#select-all').prop('checked', false).prop('indeterminate', true);
                        } else {
                            // No checkboxes are checked
                            $('#select-all').prop('checked', false).prop('indeterminate', false);
                        }
                    });
                    $('#select-all').on('change', function() {
                        var checkboxes = $('input[type="checkbox"][name="opportunity_ids[]"]');
                        checkboxes.prop('checked', $(this).prop('checked'));
                    });
                },
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{text: '<span class="d-none d-sm-inline-block" >Close Selected Quotes</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        type: 'submit',
                        id: 'change_status'
                    },
                    action: function(e, dt, node, config) {
                    }}],
        });

        $('#change_status').click(function(e) {
            var url = "{{ route('batch_close_quotes.updatestatus') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: $('#batchCloseForm').serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        showToast('success', response.msg);
                        window.location.href = response.search_url;
                    }
                }
            });
        });
    });
</script>
