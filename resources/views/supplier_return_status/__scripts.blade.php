<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#supplierReturnStatusFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('supplier_return_statuses.list') }}",
                data: function (d) {
                    d.supplier_retun_status_search = $('#supplierReturnStatusFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'return_code_name', name: 'return_code_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Supplier Return Status</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#supplierReturnStatusModel',
                        'id': 'createBin',
                    },
                    action: function(e, dt, node, config) {

                        $('#savedata').html("Save Supplier Return Status");
                        $('#return_code_id').val('');
                        $('#supplierReturnStatusForm').trigger("reset");
                        $('.reason_code_name_error').html('');
                        $('#modelHeading').html("Create New Supplier Return Status");
                        $('#supplierReturnStatusModel').modal('show');
                    }
                }
            ],
        });
       
        $('#supplierReturnStatusForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#return_code_id').val() ? "{{ route('supplier_return_statuses.update', ':id') }}".replace(':id', $('#return_code_id').val()) : "{{ route('supplier_return_statuses.store') }}";
            var type = $('#return_code_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#supplierReturnStatusForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#supplierReturnStatusForm').trigger("reset");
                        $('#supplierReturnStatusModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
                }
            });
        });
        $('body').on('click', '.editbtn', function () {
            $('.return_code_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('supplier_return_statuses.index') }}" + '/' + id + '/edit', function (data) {
                $(".return_code_error").html("");
                $('#modelHeading').html("Edit Supplier Return Status");
                $('#savedata').val("edit-supplier-return-status");
                $('#savedata').html("Update Supplier Return Status");
                $('#supplierReturnStatusModel').modal('show');
                $('#return_code_id').val(data.id);
                $('#return_code_name').val(data.return_code_name);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteSupplierReturnStatus(id);
            });
        });
        function deleteSupplierReturnStatus(id) {
            var url = "{{ route('supplier_return_statuses.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('supplier_return_statuses.index') }}" + '/' + id, function (data) {
                $('#showSupplierReturnStatusModal').modal('show');
                $('#showSupplierReturnStatusForm #return_code_name').val(data.return_code_name);

            });
        });
    });
</script>
