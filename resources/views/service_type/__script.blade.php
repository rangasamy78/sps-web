<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#serviceTypeFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#serviceTypeTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('service_types.list') }}",
                data: function(d) {
                    d.service_type_search = $('#serviceTypeFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }]; // Order by the correct column index
                }
            },
            columns: [{
                    data: null,
                    name: 'serial',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'service_type',
                    name: 'service_type'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Add the serial number in the first column
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Service Type</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#serviceTypeModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Service Type");
                    $('#service_type_id').val('');
                    $('#serviceTypeForm').trigger("reset");
                    $(".service_type_error").html("");
                    $('#modelHeading').html("Create New Service Type");
                    $('#serviceTypeModel').modal('show');
                }
            }],

        });

        $('#service_type').on('input', function() {
            $('.service_type_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#service_type_id').val() ? "{{ route('service_types.update', ':id') }}".replace(':id', $('#service_type_id').val()) : "{{ route('service_types.store') }}";
            var type = $('#service_type_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#serviceTypeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#serviceTypeForm').trigger("reset");
                        $('#serviceTypeModel').modal('hide');
                        table.draw();
                        showToast('success', response.msg);
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
            $(".service_type_error").html("");
            $.get("{{ route('service_types.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Service Type");
                $('#savedata').val("service-type");
                $('#savedata').html("Update Service Type");
                $('#serviceTypeModel').modal('show');
                $('#service_type_id').val(data.id);
                $('#service_type').val(data.service_type);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteServiceType(id);
            });
        });

        function deleteServiceType(id) {
            var url = "{{ route('service_types.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('service_types.index') }}" + '/' + id, function(data) {
                $('#showServiceTypeModal').modal('show');
                $('#showServiceTypeForm #service_type').val(data.service_type);
            });
        });

    });
</script>
