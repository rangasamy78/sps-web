<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#salesOrderline tbody').on('change', '.form-check-input', function() {
            var row = $(this).closest('tr');
            var rowId = row.data('id');

            if (this.checked) {
                document.getElementById(rowId + '_pick_qty').value = document.getElementById(rowId +
                    '_un_invoiced_qty').textContent;
            } else {
                document.getElementById(rowId + '_pick_qty').value = 0.00;
            }
        });

        $('#select-all').on('change', function() {
            var isChecked = this.checked;

            $('#salesOrderline tbody .form-check-input').each(function() {
                this.checked = isChecked;
                var row = $(this).closest('tr');
                var rowId = row.data('id');

                if (isChecked) {
                    document.getElementById(rowId + '_pick_qty').value = document
                        .getElementById(rowId + '_un_invoiced_qty').textContent;

                    const input1 = document.getElementById(rowId + '_pick_qty');
                    const input2 = document.getElementById(rowId + '_unit_price');
                    const result = document.getElementById(rowId + '_extended_amount');

                    const value1 = parseFloat(input1.value) || 0;
                    const value2 = parseFloat(input2.value) || 0;
                    const multiplicationResult = value1 * value2;

                    const roundedResult = multiplicationResult.toFixed(2);

                    result.value = roundedResult;
                } else {
                    document.getElementById(rowId + '_pick_qty').value = 0.00;
                    document.getElementById(rowId + '_extended_amount').value = 0.00;
                }
            });
        });

        $('#salesOrderline tbody').on('change', 'td', function() {
            var row = $(this).closest('tr');
            var rowId = row.data('id');

            const input1 = document.getElementById(rowId + '_pick_qty');
            const input2 = document.getElementById(rowId + '_unit_price');
            const result = document.getElementById(rowId + '_extended_amount');

            const value1 = parseFloat(input1.value) || 0;
            const value2 = parseFloat(input2.value) || 0;
            const multiplicationResult = value1 * value2;

            const roundedResult = multiplicationResult.toFixed(2);

            result.value = roundedResult;

            let inputBox = document.getElementById(rowId + '_pick_qty');
            let checkbox = document.getElementById(rowId + '_item_id');

            inputBox.addEventListener('input', function() {
                if (parseInt(inputBox.value) > 0) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });

        });

        var table_sales_order_line = $('#salesOrderline').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('pick_tickets.list', ':id') }}".replace(':id', $('#sales_order_id')
                .val()),
                type: 'GET',
                data: function(d) {},
            },
            columns: [{
                    data: 'check_item',
                    name: 'check_item',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'so_line_no',
                    name: 'so_line_no'
                },
                {
                    data: 'item',
                    name: 'item'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'quantity_val',
                    name: 'quantity_val'
                },
                {
                    data: 'un_invoiced_qty',
                    name: 'un_invoiced_qty'
                },
                {
                    data: 'pick_qty',
                    name: 'pick_qty'
                },
                {
                    data: 'unit_price',
                    name: 'unit_price'
                },
                {
                    data: 'extended_amount',
                    name: 'extended_amount'
                },
                {
                    data: 'is_taxable',
                    name: 'is_taxable',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'is_hideon_print',
                    name: 'is_hideon_print',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).addClass('row-' + data.id);
                $(row).attr('data-id', data.id);
                $('#select-all').on('change', function() {
                    var checkboxes = $('input[type="checkbox"][name="item_ids[]"]');
                    checkboxes.prop('checked', $(this).prop('checked'));
                });
                $('#hide-all').on('change', function() {
                    var checkboxes = $(
                        'input[type="checkbox"][name="is_hideon_print_ids[]"]');
                    checkboxes.prop('checked', $(this).prop('checked'));
                });
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                    text: ' <span class="d-none d-sm-inline-block">Create PickTicket & Print</span>',
                    className: 'create-new btn btn-primary me-2',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#lineModel',
                        'aria-controls': 'crmEvent',
                    },
                    action: function(e, dt, node, config) {
                        $('#modelHeading').html("Add Item from Available Inventory");
                    }
                },
                {
                    text: '<span class="d-none d-sm-inline-block">Create PickTicket</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#serviceModel',
                        'aria-controls': 'crmEvent',
                    },
                    action: function(e, dt, node, config) {
                        $('#modelServiceHeading').html("Add Service");
                    }
                }
            ],
        });
        let rowIndex = 3;

        $('#addRow').on('click', function() {
            let newRows = '';
            for (let i = 0; i < 3; i++) {
                newRows += `
                <tr>
                  <td>
                    <select class="form-control" id="item_id" name="item_id">
                        <option value="">Select Service</option>
                        @foreach ($data['services'] as $id => $service_name)
                            <option value="{{ $id }}">{{ $service_name }}</option>
                        @endforeach
                    </select>
                    </td>
                    <td><select class="form-control" id="item_id" name="item_id">
                        <option value="">Select Account</option>
                        @foreach ($data['accounts'] as $account)
                            <option value="{{ $account->id }}">{{ $account->account_number }} - {{ $account->account_name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" class="form-control form-control-sm" name="items[${rowIndex}][item_id]" ></td>
                    <td><input type="text" class="form-control" name="items[${rowIndex}][description]" ></td>
                    <td><input type="text" class="form-control form-control-sm" name="items[${rowIndex}][extended]" style="width: 80%;float: right;"></td>
                    <td><div class="d-flex align-items-center">
                        <input type="checkbox" class="is_tax" name="items[${rowIndex}][is_tax]" style="width: 100%;">
                    </div></td>
                    <td><div class="d-flex align-items-center">
                        <input type="checkbox" class="is_hideon_print" name="items[${rowIndex}][is_hideon_print]" style="width: 100%">
                    </div></td>
                </tr>
            `;
                rowIndex++;
            }
            $('#pickTicketItemsBody').append(newRows);
        });
    });
</script>
