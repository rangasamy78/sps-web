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
                url: "{{ route('inventory_adjustment_reason_codes.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'adjustment_type_id', name: 'adjustment_type_id' },
                { data: 'reason', name: 'reason' },
                { data: 'income_expense_account', name: 'income_expense_account' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createInventoryAdjustmentReasonCode').click(function () {
            $('.reason_error').html('');
            $('#savedata').html("Save Inventory Adjustment Reason Code");
            $('#inventory_adjustment_reason_code_id').val('');
            $('#inventoryAdjustmentReasonCodeForm').trigger("reset");
            $('#modelHeading').html("Create New Inventory Adjustment Reason Code");
            $('#inventoryAdjustmentReasonCodeModel').modal('show');
        });
        $('#inventoryAdjustmentReasonCodeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#inventory_adjustment_reason_code_id').val() ? "{{ route('inventory_adjustment_reason_codes.update', ':id') }}".replace(':id', $('#inventory_adjustment_reason_code_id').val()) : "{{ route('inventory_adjustment_reason_codes.store') }}";
            var type = $('#inventory_adjustment_reason_code_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#inventoryAdjustmentReasonCodeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#inventoryAdjustmentReasonCodeForm').trigger("reset");
                        $('#inventoryAdjustmentReasonCodeModel').modal('hide');
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
            $('.reason_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('inventory_adjustment_reason_codes.index') }}" + '/' + id + '/edit', function (data) {
                $(".reason_error").html("");
                $('#modelHeading').html("Edit Inventory Adjustment Reason Code");
                $('#savedata').val("edit-inventory-adjustment-reason-code");
                $('#savedata').html("Update Inventory Adjustment Reason Code");
                $('#inventoryAdjustmentReasonCodeModel').modal('show');
                $('#inventory_adjustment_reason_code_id').val(data.id);
                $('#reason').val(data.reason);
                $('#adjustment_type_id').val(data.adjustment_type_id);
                $('#income_expense_account').val(data.income_expense_account);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteInventoryAdjustmentReasonCode(id);
            });
        });
        function deleteInventoryAdjustmentReasonCode(id) {
            var url = "{{ route('inventory_adjustment_reason_codes.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    handleAjaxResponse(response, table);
                },
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('inventory_adjustment_reason_codes.index') }}" + '/' + id, function (data) {
                $('#showInventoryAdjustmentReasonCodeModal').modal('show');
                $('#showInventoryAdjustmentReasonCodeForm #reason').val(data.reason);
                $('#showInventoryAdjustmentReasonCodeForm #adjustment_type_id').val(data.adjustment_type_id);
                $('#showInventoryAdjustmentReasonCodeForm #income_expense_account').val(data.income_expense_account);
            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
