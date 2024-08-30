<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#customerContactTitleFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#customerContactTitleTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('customer_contact_titles.list') }}",
                data: function(d) {
                    d.customer_contact_title_search = $('#customerContactTitleFilter').val();
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
                    data: 'customer_title',
                    name: 'customer_title'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Customer Contact Title</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#customerContactTitleModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    // Custom action for Add New Record button
                    $('#savedata').html("Save Customer Contact Title");
                    $('#customer_title_id').val('');
                    $('#customerContactTitleForm').trigger("reset");
                    $(".customer_title_error").html("");
                    $('#modelHeading').html("Create New Customer Contact Title");
                    $('#customerContactTitleModel').modal('show');
                }
            }],
        });

        $('#customer_title').on('input', function() {
            $('.customer_title_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#customer_title_id').val() ? "{{ route('customer_contact_titles.update', ':id') }}".replace(':id', $('#customer_title_id').val()) : "{{ route('customer_contact_titles.store') }}";
            var type = $('#customer_title_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#customerContactTitleForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#customerContactTitleForm').trigger("reset");
                        $('#customerContactTitleModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $(".customer_title_error").html("");
            $.get("{{ route('customer_contact_titles.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Customer Contact Title");
                $('#savedata').val("customer-contact-title");
                $('#savedata').html("Update Customer Contact Title");
                $('#customerContactTitleModel').modal('show');
                $('#customer_title_id').val(data.id);
                $('#customer_title').val(data.customer_title);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCustomerContactTitle(id);
            });
        });

        function deleteCustomerContactTitle(id) {
            var url = "{{ route('customer_contact_titles.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, table);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }
        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('customer_contact_titles.index') }}" + '/' + id, function(data) {
                $('#showCustomerContactTitleModal').modal('show');
                $('#showCustomerContactTitleForm #customer_title').val(data.customer_title);
            });
        });

    });
</script>
