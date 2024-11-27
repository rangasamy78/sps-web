<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#vendorPoFilter').on('keyup change', function(e) {
        e.preventDefault();
        table.draw();
    });
    $('#vendorPoForm').on('input change', 'input, select', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });


    var table = $('#datatable').DataTable({
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
                text: '<span class="d-none d-sm-inline-block">Vendor Pos</span>',
                className: 'btn btn-secondary me-2',
                attr: {
                    id: 'product',
                },
                action: function(e, dt, node, config) {
                    window.location.href = "{{ route('vendor_pos.index') }}";
                }
            },
            {
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">New Vendor PO</span>',
                className: 'create-new btn btn-primary me-2',
                attr: {
                    id: 'createProduct',
                },
                action: function(e, dt, node, config) {
                    window.location.href = "{{ route('vendor_pos.create') }}";
                }
            },
            {
                text: '<span class="d-none d-sm-inline-block">Open Vendor POs</span>',
                className: 'btn btn-info me-2',
                attr: {
                    id: 'product',
                },
                action: function(e, dt, node, config) {
                    window.location.href = "{{ route('vendor_pos.index') }}";
                }
            },
            {
                extend: 'collection',
                className: 'btn btn-label-secondary dropdown-toggle mx-3',
                text: '<i class="bx bx-export me-1"></i>Export',
                buttons: [{
                        extend: 'print',
                        text: '<i class="bx bx-printer me-2"></i>Print',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="bx bx-file me-2"></i>Csv',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="bx bxs-file-export me-2"></i>Excel',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'copy',
                        text: '<i class="bx bx-copy me-2"></i>Copy',
                        className: 'dropdown-item'
                    }
                ]
            }
        ],
    });


    $('#vendorPoForm input').on('input', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    })
    $('#savedata').click(function(e) {
        e.preventDefault();
        var button = $(this);
        sending(button);


        var url = $('#vendor_po_id').val() ? "{{ route('vendor_pos.update', ':id') }}".replace(':id', $(
            '#vendor_po_id').val()) : "{{ route('vendor_pos.store') }}";
        var type = $('#vendor_po_id').val() ? "PUT" : "POST";
        $.ajax({
            url: url,
            type: type,
            data: $('#vendorPoForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status == "success") {
                    $('#vendorPoForm').trigger("reset");
                    $('#vendorPoModel').modal('hide');
                    var id = response.id;
                    var vendorPoId = $('#vendor_po_id').val();
                    if (!vendorPoId) {
                        alert(
                            'Do you want to overwrite service prices in Vendor Price Sheet?'
                        );
                    }

                    window.location.href = "{{ route('vendor_pos.show', ':id') }}".replace(
                        ':id', id);

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
                                    service -${serviceDetails.service_name}
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

        function calculateTotalExtended() {
            let total = 0;
            $('input[name^="items"][name$="[extended]"]').each(function() {
                let value = parseFloat($(this).val()) ||
                    0;
                total += value;
            });

            $('#totalExtended').val(total.toFixed(2));
        }
        $(document).ready(function() {
            calculateTotalExtended
                ();
        });

        $(document).on('input', 'input[name^="items"][name$="[extended]"]', function() {
            calculateTotalExtended();
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


            calculateTotalExtended();
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
            const serviceIdInput = $input.closest('tr').find(
                'input[name$="[service_id]"]');
            const quantityInput = $input.closest('tr').find(
                'input[name$="[quantity]"]');
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

    $(document).on('input', 'input[name*="[quantity]"], input[name*="[unit_cost]"]', function() {
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


        $('#totalExtended').val(totalExtended.toFixed(2));
    });



    $(document).ready(function() {
        $('#vendor_id').on('change', function() {
            var vendorId = $(this).val();

            if (vendorId) {
                var url = "{{ route('fetch_vendor_details', ':id') }}";
                url = url.replace(':id', vendorId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#address').val(response.data.shipping_address);
                            $('#address2').val(response.data.address);
                            $('#city').val(response.data.shipping_city);
                            $('#state').val(response.data.shipping_state);
                            $('#zip').val(response.data.shipping_zip);
                            $('#country_id').val(response.data.shipping_country_id)
                                .trigger('change');
                            $('#location_id').val(response.data.parent_location_id)
                                .trigger('change');
                            $('#location_id').val(response.data.parent_location_id)
                                .trigger('change');
                            $('#payment_term_id').val(response.data.payment_terms)
                                .trigger('change');
                            $('#phone').val(response.data.primary_phone);
                            $('#fax').val(response.data.fax);
                            $('#email').val(response.data.email);

                        } else {
                            alert('Vendor details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            } else {

                $('#vendor_name').val('');
                $('#vendor_address').val('');
            }
        });
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



});
</script>