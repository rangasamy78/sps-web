<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#selectTypeCategoryFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "{{ route('select_type_categories.list') }}",
                data: function(d) {
                    d.select_type_category_search = $('#selectTypeCategoryFilter').val();
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
                    data: 'select_type_category_name',
                    name: 'select_type_category_name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Select Type Category</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#selectTypeCategoryModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {

                    $('#savedata').html("Save Select Type Category");
                    $('#select_type_category_id').val('');
                    $('#selectTypeCategoryForm').trigger("reset");
                    $('.select_type_category_name_error').html('');
                    $('#modelHeading').html("Create New Select Type Category");
                    $('#selectTypeCategoryModel').modal('show');
                }
            }],
        });

        $('#selectTypeCategoryForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#select_type_category_id').val() ? "{{ route('select_type_categories.update', ':id') }}".replace(':id', $('#select_type_category_id').val()) : "{{ route('select_type_categories.store') }}";
            var type = $('#select_type_category_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#selectTypeCategoryForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#selectTypeCategoryForm').trigger("reset");
                        $('#selectTypeCategoryModel').modal('hide');
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
            $.get("{{ route('select_type_categories.index') }}" + '/' + id + '/edit', function(data) {
                $(".select_type_category_name_error").html("");
                $('#modelHeading').html("Edit Select Type Category");
                $('#savedata').val("edit-select-type-category");
                $('#savedata').html("Update Select Type Category");
                $('#selectTypeCategoryModel').modal('show');
                $('#select_type_category_id').val(data.id);
                $('#select_type_category_name').val(data.select_type_category_name);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteSelectTypeCategory(id);
            });
        });

        function deleteSelectTypeCategory(id) {
            var url = "{{ route('select_type_categories.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        table.draw();
                    } else if (response.status == "error") {
                        showToast('error', 'Category cannot be deleted because it has subcategories.');
                    } else {
                        showToast('error', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('select_type_categories.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Select Type Category");
                $('#savedata').val("edit-select-type-category");
                $('#showSelectTypeCategoryModal').modal('show');
                $('#showSelectTypeCategoryForm #select_type_category_name').val(data.select_type_category_name);
            });
        });
    });
</script>