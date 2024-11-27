<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#vendorPoPaymentForm').on('input change', 'input, select', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });

    var table = $('#datatable_bill').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('vendor_pos.list') }}",
            data: function(d) {
                d.vendor_po_search = $('#vendorPoFilter').val();
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
                data: 'transaction_number',
                name: 'transaction_number'
            },
            {
                data: 'transaction_date',
                name: 'transaction_date'
            },
            {
                data: 'vendor_id',
                name: 'vendor_id'
            },
            {
                data: 'cust_ref',
                name: 'cust_ref'
            },
            {
                data: 'eta_date',
                name: 'eta_date'
            },

            {
                data: 'phone_combined',
                name: 'phone'
            },
            {
                data: 'payment_term_id',
                name: 'payment_term_id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'extended_total',
                name: 'extended_total'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add PrePayment</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    id: 'createVendorPo',
                    style: 'margin-right: 10px;',
                },
                action: function(e, dt, node, config) {
                    var vendorPoId = $('#vendor_po_id').val();
                    window.location.href = "{{ route('vendor_pos.pre_payment', ':id') }}"
                        .replace(':id', vendorPoId);

                }

            },
            {
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Bill</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    id: 'createNewBill',
                },
                action: function(e, dt, node, config) {
                    var vendorPoId = $('#vendor_po_id').val();
                    window.location.href = "{{ route('vendor_pos.new_bill', ':id') }}".replace(
                        ':id', vendorPoId);
                }
            }
        ],

    });


    $('#vendorPoPaymentForm input').on('input', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    })
    $('#savedataPayment').click(function(e) {
        e.preventDefault();
        var button = $(this);
        sending(button);
        var url = "{{ route('vendor_pos.prepaymentsave', ':id') }}".replace(':id', $('#vendor_po_id')
            .val());
        var type = "POST";
        $.ajax({
            url: url,
            type: type,
            data: $('#vendorPoPaymentForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status == "success") {
                    $('#vendorPoPaymentForm').trigger("reset");
                    showToast('success', response.msg);
                    var id = $('#vendor_po_id').val();
                    window.location.href = "{{ route('vendor_pos.Vpayment', ':id') }}"
                        .replace(':id', id);
                    table.draw();

                }
            },
            error: function(xhr) {
                handleAjaxError(xhr);
                sending(button, true);
            }
        });
    });

    $('body').on('click', '.deletebtn', function() {
        var id = $(this).data('id');
        confirmDelete(id, function() {
            deleteVendorPo(id);
        });
    });

    function deleteVendorPo(id) {
        var url = "{{ route('vendor_pos.destroy', ':id') }}".replace(':id', id);
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
    $(document).ready(function() {
        let rowIndex = 15;
        let selectedServices = [];

        $('#addRow').on('click', function() {
            let newRows = '';
            for (let i = 0; i < 5; i++) {
                newRows += `
                <tr>
                  <td style="position: relative; display: flex; align-items: center;">
                    <input type="text" class="form-control form-control-sm service-input" name="items[${rowIndex}][service]" placeholder="Search..">

                    <!-- Suggestions list below the input -->
                    <ul class="suggestions-list" id="suggestions-${rowIndex}" style="display: none; position: absolute; left: 35px; top: 82%; width: 75%; background-color: white; border: 1px solid #ccc; z-index: 10;"></ul>

                    <!-- Red cross delete icon -->
                    <span class="delete-service" style="display: none; cursor: pointer; color: red; font-size: 18px; margin-left: 10px;">&times;</span>
                </td>
                    <td>
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="purchase_check" name="items[${rowIndex}][purchase_check]" style="width: 80px;">
                    <input type="text" class="form-control form-control-sm me-2 purchase-input" name="items[${rowIndex}][purchase]" disabled>
                </div>

                    </td>
                    <td><input type="text" class="form-control form-control-sm" name="items[${rowIndex}][description]" >
                    <input type="hidden" class="form-control form-control-sm" name="items[${rowIndex}][service_id]" ></td>
                <td><span class="" name="items[${rowIndex}][alt_qty]" id="alt_qty_${rowIndex}"></span></td>
                <td><span class="" name="items[${rowIndex}][alt_uom]" id="alt_uom_${rowIndex}"></span></td>
                <td><span class="" name="items[${rowIndex}][alt_ucost]" id="alt_ucost_${rowIndex}"></span></td>

                    <td><input type="text" class="form-control form-control-sm" name="items[${rowIndex}][quantity]" ></td>
                    <td><input type="text" class="form-control form-control-sm" name="items[${rowIndex}][uom]" readonly>

                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <input type="text" class="form-control form-control-sm me-2" name="items[${rowIndex}][unit_cost]" style="width: 80px;">
                            <input type="button" style="color: #007bff;" value="vp">
                        </div>
                    </td>
                    <td><input type="text" class="form-control form-control-sm" name="items[${rowIndex}][extended]" ></td>
                    <td><button type="button" class="btn btn-danger removeRow"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
                rowIndex++;
            }
            $('#vendorPoItemsBody').append(newRows);
        });

        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('keyup', 'input[name^="items"][name$="[service]"]', function() {
            let inputField = $(this).val();
            let rowIndex = $(this).closest('tr').index();
            let suggestionList = $(this).siblings('.suggestions-list');

            if (inputField.length >= 1) {
                $.ajax({
                    url: "{{ route('fetch_service_details') }}",
                    method: "GET",
                    data: {
                        search: inputField
                    },
                    success: function(response) {
                        suggestionList.empty();

                        if (response.length > 0) {
                            suggestionList.show();


                            let filteredServices = response.filter(function(
                                service) {
                                return !selectedServices.includes(service
                                    .id);
                            });


                            $.each(filteredServices, function(index,
                                serviceDetails) {
                                suggestionList.append(`
                                <ul class="suggestion-item" style="margin-left:-57px;" data-service="${serviceDetails.id}" data-uom="${serviceDetails.unit_measure_name}">
                                    ${serviceDetails.service_name}
                                </ul>
                            `);
                            });
                        } else {
                            suggestionList.hide();
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetching service details:", xhr
                            .responseText);
                    }
                });
            } else {
                suggestionList.hide();
            }
        });

        $(document).on('click', '.suggestion-item', function() {
            let serviceName = $(this).text().trim();
            let serviceId = $(this).data('service');
            let uom = $(this).data('uom');
            const unitcost = "0.00";

            let inputField = $(this).closest('td').find(
                'input[name^="items"][name$="[service]"]');
            inputField.val(serviceName);

            let rowIndex = $(this).closest('tr').index();

            $('input[name="items[' + rowIndex + '][uom]"]').val(uom);
            $('input[name="items[' + rowIndex + '][unit_cost]"]').val(unitcost);
            $('input[name="items[' + rowIndex + '][service_id]"]').val(serviceId);

            $(this).parent().hide();
            const $deleteIcon = inputField.siblings('.delete-service');
            $deleteIcon.show();
            selectedServices.push(serviceId);
        });


        $(document).on('input', '.service-input', function() {
            const $input = $(this);
            const $deleteIcon = $input.siblings('.delete-service');
            const uomInput = $input.closest('tr').find('input[name$="[uom]"]');

            if ($input.val().trim() !== "") {
                $deleteIcon.show();
            } else {
                $deleteIcon.hide();
                uomInput.val('');
            }
        });

        $(document).on('click', '.delete-service', function() {
            const $deleteIcon = $(this);
            const $input = $deleteIcon.siblings('.service-input');
            const uomInput = $input.closest('tr').find('input[name$="[uom]"]');
            const unitcostInput = $input.closest('tr').find('input[name$="[unit_cost]"]');
            const serviceIdInput = $input.closest('tr').find('input[name$="[service_id]"]');
            const quantityInput = $input.closest('tr').find('input[name$="[quantity]"]');
            const extendedInput = $input.closest('tr').find('input[name$="[extended]"]');
            let rowIndex = $(this).closest('tr').index();
            let serviceId = serviceIdInput.val();
            selectedServices = selectedServices.filter(service => service !== serviceId);
            $input.val('');
            uomInput.val('');
            unitcostInput.val('');
            serviceIdInput.val('');
            quantityInput.val('');
            extendedInput.val('');
            $deleteIcon.hide();
        });

    });

    $('#vendorPoItemsBody').on('input', 'input[name*="[quantity]"], input[name*="[unit_cost]"]', function() {
        var row = $(this).closest('tr');
        var quantity = parseFloat(row.find('input[name*="[quantity]"]').val()) || 0;
        var unitCost = parseFloat(row.find('input[name*="[unit_cost]"]').val()) || 0;
        var extended = quantity * unitCost;
        row.find('input[name*="[extended]"]').val(extended.toFixed(2));
        var totalExtended = 0;
        $('#vendorPoItemsBody tr').each(function() {
            var rowExtended = parseFloat($(this).find('input[name*="[extended]"]').val()) || 0;
            totalExtended += rowExtended;
        });

        $('#extended_total').val(totalExtended.toFixed(2));
    });


    function toggleInputField($checkbox, $inputField) {
        if ($checkbox.prop('checked')) {
            $inputField.prop('disabled', false);
        } else {
            $inputField.prop('disabled', true);
        }
    }


    $('.purchase_check').each(function() {
        var $checkbox = $(this);
        var $inputField = $(this).closest('div').find('.purchase-input');


        if ($inputField.val().trim() !== "") {
            $checkbox.prop('checked', true);
            toggleInputField($checkbox, $inputField);
        } else {
            $checkbox.prop('checked', false);
            toggleInputField($checkbox, $inputField);
        }
    });


    $('#vendorPoItemsBody').on('change', '.purchase_check', function() {
        var $inputField = $(this).closest('div').find('.purchase-input');
        toggleInputField($(this), $inputField);
    });


    $(document).ready(function() {



        $('input[name="amount"]').on('change', function() {
            const totalAmountText = document.getElementById('extended_total').innerText;
            const totalAmount = parseFloat(totalAmountText.replace(/[$,]/g, ''));
            const amountText = document.getElementById('amount').value;
            const amountFloat = parseFloat(amountText.replace(/[$,]/g, ''));

            if (amountFloat < totalAmount) {
                const balance = totalAmount - amountFloat;

                document.getElementById('extended_net_total').innerText =
                    `${balance.toFixed(2)}`;
            } else {

                const newNetTotal = totalAmount - amountFloat;
                document.getElementById('extended_net_total').innerText =
                    `${newNetTotal.toFixed(2)}`;
            }


            if (isNaN(amountFloat)) {
                alert('Please enter a valid amount.');
                document.getElementById('amount').value("");
            }

        });
        $('input[name="po_percentage"]').on('change', function() {
            var selectedPercentage = $(this).val();
            const totalAmountText = $('#extended_total').text();
            const totalAmount = parseFloat(totalAmountText.replace(/[$,]/g, ''));
            const calculatedNetTotal = (totalAmount * (selectedPercentage / 100)).toFixed(2);
            const netval = totalAmount - calculatedNetTotal;

            $('#amount').val(calculatedNetTotal);
            $('#extended_net_total').text(netval);

        });
    });




});
</script>