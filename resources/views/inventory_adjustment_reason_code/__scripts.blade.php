<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#reasonFilter, #adjustmentTypeFilter, #incomeExpenseAccountFilter').on('keyup change', function(e) {
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
                url: "{{ route('inventory_adjustment_reason_codes.list') }}",
                data: function(d) {
                    d.reason_search = $('#reasonFilter').val();
                    d.adjustment_type_search = $('#adjustmentTypeFilter').val();
                    d.income_expense_account_search = $('#incomeExpenseAccountFilter').val();
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
                    data: 'adjustment_type_id',
                    name: 'adjustment_type_id'
                },
                {
                    data: 'reason',
                    name: 'reason'
                },
                {
                    data: 'income_expense_account',
                    name: 'income_expense_account'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Inventory Adjustment Reason Code</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#inventoryAdjustmentReasonCodeModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Inventory Adjustment Reason Code");
                    $('.reason_error').html('');
                    $('#income_expense_account,#adjustment_type_id').val('').trigger('change');
                    $('#inventoryAdjustmentReasonCodeForm').trigger("reset");
                    $("#inventoryAdjustmentReasonCodeForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Inventory Adjustment Reason Code");
                    $('#inventoryAdjustmentReasonCodeModel').modal('show');
                }
            }],
        });

        $('#inventoryAdjustmentReasonCodeForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#inventory_adjustment_reason_code_id').val() ? "{{ route('inventory_adjustment_reason_codes.update', ':id') }}".replace(':id', $('#inventory_adjustment_reason_code_id').val()) : "{{ route('inventory_adjustment_reason_codes.store') }}";
            var type = $('#inventory_adjustment_reason_code_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#inventoryAdjustmentReasonCodeForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#inventoryAdjustmentReasonCodeForm').trigger("reset");
                        $('#inventoryAdjustmentReasonCodeModel').modal('hide');
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
            $('.reason_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('inventory_adjustment_reason_codes.index') }}" + '/' + id + '/edit', function(data) {
                $(".reason_error").html("");
                $('#modelHeading').html("Edit Inventory Adjustment Reason Code");
                $('#savedata').val("edit-inventory-adjustment-reason-code");
                $('#savedata').html("Update Inventory Adjustment Reason Code");
                $('#inventoryAdjustmentReasonCodeModel').modal('show');
                $('#inventory_adjustment_reason_code_id').val(data.id);
                $('#reason').val(data.reason);
                $('#adjustment_type_id').val(data.adjustment_type_id).trigger('change');
                $('#income_expense_account').val(data.income_expense_account).trigger('change');
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
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
            $.get("{{ route('inventory_adjustment_reason_codes.index') }}" + '/' + id, function(data) {
                $('#showInventoryAdjustmentReasonCodeModal').modal('show');
                $('#showInventoryAdjustmentReasonCodeForm #reason').val(data.reason);
                $('#showInventoryAdjustmentReasonCodeForm #adjustment_type_id').val(data.adjustment_type_id);
                $('#showInventoryAdjustmentReasonCodeForm #income_expense_account').val(data.income_expense_account);
            });
        });
    });
</script>