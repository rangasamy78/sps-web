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
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('vendor_types.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'vendor_type_name', name: 'vendor_type_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            }
        });

        $('#createVendorType').click(function () {
            $('#savedata').val("create-event-type");
            $('#savedata').html("Save Vendor Type");
            $('#vendor_type_id').val('');
            $('#vendorTypeForm').trigger("reset");
            $('.vendor_type_name_error').html('');
            $('#modelHeading').html("Create New Vendor Type");
            $('#vendorTypeModel').modal('show');
        });

        $('#vendorTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#vendor_type_id').val() ? "{{ route('vendor_types.update', ':id') }}".replace(':id', $('#vendor_type_id').val()) : "{{ route('vendor_types.store') }}";
            var type = $('#vendor_type_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#vendorTypeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#vendorTypeForm').trigger("reset");
                        $('#vendorTypeModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('vendor_types.index') }}" +'/' + id +'/edit', function (data) {
                $(".vendor_type_name_error").html("");
                $('#modelHeading').html("Edit Vendor Type");
                $('#savedata').val("edit-event-type");
                $('#savedata').html("Update Vendor Type");
                $('#vendorTypeModel').modal('show');
                $('#vendor_type_id').val(data.id);
                $('#vendor_type_name').val(data.vendor_type_name);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteVendorType(id);
            });
        });
        function deleteVendorType(id) {
            var url = "{{ route('vendor_types.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, table);
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }
        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('vendor_types.index') }}" +'/' + id, function (data) {
                $('#showVendorTypeModal').modal('show');
                $('#showVendorTypeForm #vendor_type_name').val(data.vendor_type_name);
            });
        });
    });
</script>
