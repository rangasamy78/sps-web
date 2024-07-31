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
                url: "{{ route('supplier_ports.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'supplier_port_name', name: 'supplier_port_name' },
                { data: 'avg_days', name: 'avg_days' },
                { data: 'country_name', name: 'country_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createSupplierPort').click(function () {
            $('.supplier_port_name_error').html('');
            $('#savedata').html("Save Supplier Port");
            $('#supplier_port_id').val('');
            $('#supplierPortForm').trigger("reset");
            $('#modelHeading').html("Create New Supplier Port");
            $('#supplierPortModel').modal('show');
        });
        $('#supplierPortForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#supplier_port_id').val() ? "{{ route('supplier_ports.update', ':id') }}".replace(':id', $('#supplier_port_id').val()) : "{{ route('supplier_ports.store') }}";
            var type = $('#supplier_port_id').val() ? "PUT" : "POST";
            var formData = $('#supplierPortForm').serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === "success") {
                        $('#supplierPortForm').trigger("reset");
                        $('#supplierPortModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Supplier Port Added Successfully!' : 'Supplier Port Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            $('.supplier_port_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('supplier_ports.index') }}" + '/' + id + '/edit', function (data) {
                $(".supplier_port_name_error").html("");
                $('#modelHeading').html("Edit Supplier Port");
                $('#savedata').val("edit-supplier-type");
                $('#savedata').html("Update Supplier Port");
                $('#supplierPortModel').modal('show');
                $('#supplier_port_id').val(data.id);
                $('#supplier_port_name').val(data.supplier_port_name);
                $('#avg_days').val(data.avg_days);
                $('#country_id').val(data.country_id);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteSupplierPort(id);
            });
        });
        function deleteSupplierPort(id) {
            var url = "{{ route('supplier_ports.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === "success") {
                        table.draw();
                        showSuccessMessage('Deleted!', 'Supplier Port Deleted Successfully!');
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
            $.get("{{ route('supplier_ports.index') }}" + '/' + id, function (data) {
                $('#showSupplierPortModal').modal('show');
                $('#showSupplierPortForm #supplier_port_name').val(data.model.supplier_port_name);
                $('#showSupplierPortForm #avg_days').val(data.model.avg_days);
                $('#showSupplierPortForm #country_id').val(data.model.country_id);
            });
        });
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>
