<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('select_type_categories.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'select_type_category_name', name: 'select_type_category_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            }
        });

        $('#createSelectTypeCategory').click(function () {
            $('.select_type_category_name_error').html('');
            $('#savedata').html("Save Select Type Category");
            $('#select_type_category_id').val('');
            $('#selectTypeCategoryForm').trigger("reset");
            $('#modelHeading').html("Create New Select Type Category");
            $('#selectTypeCategoryModel').modal('show');
        });

        $('#selectTypeCategoryForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#select_type_category_id').val() ? "{{ route('select_type_categories.update', ':id') }}".replace(':id', $('#select_type_category_id').val()) : "{{ route('select_type_categories.store') }}";
            var type = $('#select_type_category_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#selectTypeCategoryForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#selectTypeCategoryForm').trigger("reset");
                        $('#selectTypeCategoryModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('select_type_categories.index') }}" + '/' + id + '/edit', function (data) {
                $(".select_type_category_name_error").html("");
                $('#modelHeading').html("Edit Select Type Category");
                $('#savedata').val("edit-select-type-category");
                $('#savedata').html("Update Select Type Category");
                $('#selectTypeCategoryModel').modal('show');
                $('#select_type_category_id').val(data.id);
                $('#select_type_category_name').val(data.select_type_category_name);
            });
        });

        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
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
                success: function (response) {
                    console.log(response);
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        table.draw();
                    }
                    else if (response.status == "error") {
                        showToast('error', 'Category cannot be deleted because it has subcategories.');
                    }
                    else {
                        showToast('error', response.msg);
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('select_type_categories.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Select Type Category");
                $('#savedata').val("edit-select-type-category");
                $('#showSelectTypeCategoryModal').modal('show');
                $('#showSelectTypeCategoryForm #select_type_category_name').val(data.select_type_category_name);
            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
