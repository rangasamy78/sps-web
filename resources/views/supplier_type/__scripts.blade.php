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
                url: "{{ route('supplier_types.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'supplier_type_name', name: 'supplier_type_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createSupplierType').click(function () {
            $('.supplier_type_name_error').html('');
            $('#savedata').html("Save Supplier Type");
            $('#supplier_type_id').val('');
            $('#supplierTypeForm').trigger("reset");
            $('#modelHeading').html("Create New Supplier Type");
            $('#supplierTypeModel').modal('show');
        });
        $('#supplierTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#supplier_type_id').val() ? "{{ route('supplier_types.update', ':id') }}".replace(':id', $('#supplier_type_id').val()) : "{{ route('supplier_types.store') }}";
            var type = $('#supplier_type_id').val() ? "PUT" : "POST";
            var formData = $('#supplierTypeForm').serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === "success") {
                        $('#supplierTypeForm').trigger("reset");
                        $('#supplierTypeModel').modal('hide');
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
            $('.supplier_type_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('supplier_types.index') }}" + '/' + id + '/edit', function (data) {
                $(".supplier_type_name_error").html("");
                $('#modelHeading').html("Edit Supplier Type");
                $('#savedata').val("edit-supplier-type");
                $('#savedata').html("Update Supplier Type");
                $('#supplierTypeModel').modal('show');
                $('#supplier_type_id').val(data.id);
                $('#supplier_type_name').val(data.supplier_type_name);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteSupplierType(id);
            });
        });
        function deleteSupplierType(id) {
            var url = "{{ route('supplier_types.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, table);
                    } else {
                        showError('Deleted!', response.msg);
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
            $.get("{{ route('supplier_types.index') }}" + '/' + id, function (data) {
                $('#showSupplierTypeModal').modal('show');
                $('#showSupplierTypeForm #supplier_type_name').val(data.supplier_type_name);
            });
        });
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>
