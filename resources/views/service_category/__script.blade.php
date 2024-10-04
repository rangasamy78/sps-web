<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#serviceCategoryFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#serviceCategoryTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('service_categories.list') }}",
                data: function(d) {
                    d.service_category_search = $('#serviceCategoryFilter').val();
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
                    data: 'service_category',
                    name: 'service_category'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Service Category</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#serviceCategoryModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Service Category");
                    $('#service_category_id').val('');
                    $('#serviceCategoryForm').trigger("reset");
                    $(".service_category_error").html("");
                    $('#modelHeading').html("Create New Service Category");
                    $('#serviceCategoryModel').modal('show');
                }
            }],

        });

        $('#service_category').on('input', function() {
            $('.service_category_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#service_category_id').val() ? "{{ route('service_categories.update', ':id') }}".replace(':id', $('#service_category_id').val()) : "{{ route('service_categories.store') }}";
            var type = $('#service_category_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#serviceCategoryForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#serviceCategoryForm').trigger("reset");
                        $('#serviceCategoryModel').modal('hide');
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
            $(".service_category_error").html("");
            $.get("{{ route('service_categories.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Service Category");
                $('#savedata').val("service-category");
                $('#savedata').html("Update Service Category");
                $('#serviceCategoryModel').modal('show');
                $('#service_category_id').val(data.id);
                $('#service_category').val(data.service_category);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteServiceCategory(id);
            });
        });

        function deleteServiceCategory(id) {
            var url = "{{ route('service_categories.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('service_categories.index') }}" + '/' + id, function(data) {
                $('#showServiceCategoryModal').modal('show');
                $('#showServiceCategoryForm #service_category').val(data.service_category);
            });
        });

    });
</script>
