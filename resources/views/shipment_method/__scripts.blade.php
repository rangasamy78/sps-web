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
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('shipment_methods.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'shipment_method_name', name: 'shipment_method_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createShipmentMethod').click(function () {
            $('#savedata').val("create-shipment-method");
            $('#savedata').html("Save Shipment Method");
            $('#shipment_method_id').val('');
            $('#shipmentMethodForm').trigger("reset");
            $('.shipment_method_name_error').html('');
            $('#modelHeading').html("Create New Shipment Method");
            $('#shipmentMethodModel').modal('show');
        });

        $('#shipmentMethodForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            var url = $('#shipment_method_id').val() ? "{{ route('shipment_methods.update', ':id') }}".replace(':id', $('#shipment_method_id').val()) : "{{ route('shipment_methods.store') }}";
            var type = $('#shipment_method_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#shipmentMethodForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#shipmentMethodForm').trigger("reset");
                        $('#shipmentMethodModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Shipment Method Added Successfully!' : 'Shipment Method Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    var button = type === 'POST' ? 'Save Shipment Method' : 'Update Shipment Method';
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('shipment_methods.index') }}" +'/' + id +'/edit', function (data) {
                $(".shipment_method_name_error").html("");
                $('#modelHeading').html("Edit Shipment Method");
                $('#savedata').val("edit-shipment-method");
                $('#savedata').html("Update Shipment Method");
                $('#shipmentMethodModel').modal('show');
                $('#shipment_method_id').val(data.id);
                $('#shipment_method_name').val(data.shipment_method_name);
            });
        });


        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteShipmentMethod(id);
            });
        });

        function deleteShipmentMethod(id) {
            var url = "{{ route('shipment_methods.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Shipment Method Deleted Successfully!');
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
            $.get("{{ route('shipment_methods.index') }}" +'/' + id, function (data) {
                $('#showShipmentMethodModal').modal('show');
                $('#showShipmentMethodForm #shipment_method_name').val(data.shipment_method_name);
            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>