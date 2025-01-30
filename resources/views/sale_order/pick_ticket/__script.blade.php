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
                document.getElementById(rowId + '_pick_qty').value = document.getElementById(rowId + '_un_invoiced_qty').textContent;
            } else {
                document.getElementById(rowId + '_pick_qty').value = 0.00;
            }
        });

        $('#select-all').on('change', function() {
        var isChecked = this.checked;

        // Set all individual checkboxes based on the "Select All" checkbox state
        $('#salesOrderline tbody .form-check-input').each(function() {
            this.checked = isChecked;
            var row = $(this).closest('tr');
            var rowId = row.data('id');

            // Set the pick_qty value based on "Select All"
            if (isChecked) {
                document.getElementById(rowId + '_pick_qty').value = document.getElementById(rowId + '_un_invoiced_qty').textContent;

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

        // $('#pick_qty123').on('change', function() { alert(43);});
        // $('#salesOrderline').on('change', 'input[name="unit_price"]', function() {
        //     var value = $(this).val();
        // });
        // // var table = $('#salesOrderline').DataTable();

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

    // Add an event listener to the input box to check its value when it changes
    inputBox.addEventListener('input', function() {
        // If the input value is greater than 0, check the checkbox
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
                url: "{{ route('pick_tickets.list',':id') }}".replace(':id', $('#sales_order_id').val()),
                type: 'GET',
                data: function(d) {
                    // Optional data to be sent with the request
                },
            },
            columns: [
                {
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
                        var checkboxes = $('input[type="checkbox"][name="is_hideon_print_ids[]"]');
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
                        // Custom action here
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
                    }],
        });

        // $('#service_id').select2({
        //     placeholder: 'Select Service',
        //     dropdownParent: $('#service_id').parent()
        // });

        // const input1 = document.getElementById('pick_qty');
        // const input2 = document.getElementById('unit_price');
        // const result = document.getElementById('extended_amount');

        // function updateResult() {
        //     const value1 = parseFloat(input1.value) || 0;
        //     const value2 = parseFloat(input2.value) || 0;
        //     const multiplicationResult = value1 * value2;

        //     const roundedResult = multiplicationResult.toFixed(2);

        //     result.value = roundedResult;
        // }

        // pick_qty.addEventListener('input', updateResult);
        // unit_price.addEventListener('input', updateResult);




//         $(document).ready(function() {
//         function updateExtendedAmount() {
//         // Get the values from the input fields
//         var qty = parseFloat($('#pick_qty').val()) || 0;
//         var price = parseFloat($('#unit_price').val()) || 0;

//         // Calculate the extended amount
//         var extendedAmount = qty * price;

//         // Round to two decimal places
//         extendedAmount = extendedAmount.toFixed(2);

//         // Update the extended_amount input field
//         $('#extended_amount').val(extendedAmount);
//     }

//     // Trigger the update when the values change in either of the input fields
//     $('#pick_qty, #unit_price').on('change', updateExtendedAmount);
// });

// document.getElementById('pick_qty123').addEventListener('change', function() {
//     alert('Value changed: ' + this.value);
//   });

let rowIndex = 3;
        // let selectedServices = [];

        $('#addRow').on('click', function() {
            let newRows = '';
            for (let i = 0; i < 3; i++) {
                newRows += `
                <tr>
                  <td>
                    <select class="form-control" id="item_id" name="item_id">
                        <option value="">Select Service</option>
                        @foreach($data['services'] as $id => $service_name)
                            <option value="{{ $id }}">{{ $service_name }}</option>
                        @endforeach
                    </select>
                    </td>
                    <td><select class="form-control" id="item_id" name="item_id">
                        <option value="">Select Account</option>
                        @foreach($data['accounts'] as $account)
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


/*

        $('#formAddNewCustomer input, #formAddNewCustomer select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });
        $('#print_doc_disclaimer_id').on('change', function() {
            var selectedStep = document.getElementById("print_doc_disclaimer_id").value;
            axios.get(`/sps-web/sale_orders/get-record/${selectedStep}`)
                .then(function (response) {
                    document.querySelector('.ql-editor').innerHTML = response.data.data;
                })
                .catch(function (error) {
                    console.error("There was an error fetching the record:", error);
                });
        });
        $('#saveCustomer').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('customers.store') }}";
            var type = "POST";
            var data = $('#formAddNewCustomer').serialize();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#formAddNewCustomer').trigger("reset");
                        $('#customer_type_id, #parent_customer_id, #referred_by_id,#parent_location_id,#sales_person_id,#secondary_sales_person_id,#payment_terms_id,#sales_tax_id,#price_list_label_id').val(null).trigger('change');
                        $('#AddNewCustomer').modal('hide');
                        sending(button, true);
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        document.getElementById('sameAsBillTo').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('shipping_address').value = document.getElementById('address').value;
                document.getElementById('shipping_address_2').value = document.getElementById('address_2').value;
                document.getElementById('shipping_city').value = document.getElementById('city').value;
                document.getElementById('shipping_state').value = document.getElementById('state').value;
                document.getElementById('shipping_zip').value = document.getElementById('zip').value;
            } else {
                document.getElementById('shipping_address').value = '';
                document.getElementById('shipping_address_2').value = '';
                document.getElementById('shipping_city').value = '';
                document.getElementById('shipping_state').value = '';
                document.getElementById('shipping_zip').value = '';
            }
        });

        $('#formAddNewAssociate input, #formAddNewAssociate select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#saveAssociate').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('associates.store') }}";
            var type = "POST";
            var data = $('#formAddNewAssociate').serialize();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#formAddNewAssociate').trigger("reset");
                        $('#associate_type_id,#country_id, #location_id, #primary_sales_id').val(null).trigger('change');
                        $('#AddNewAssociate').modal('hide');
                        sending(button, true);
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        //pop up customer list
        $(' #customerNameFilter,#customerCodeFilter,#contactFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_customer_list.draw();
        });
        var table_customer_list = $('#customerListTable').DataTable({
            // scrollX: true, // Enable horizontal scrolling
            // paging: true,
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('opportunities.customer_list') }}",
                data: function(d) {
                    d.customerName = $('#customerNameFilter').val();
                    d.customerCode = $('#customerCodeFilter').val();
                    d.contact = $('#contactFilter').val();
                }
            },
            columns: [{
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'customer_code',
                    name: 'customer_code'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
            ],
            rowCallback: function(row, data, index) {
                $(row).on('click', function() {
                    $('#billing_customer_id').val(data.id);
                    $('#billing_customer_name').val(data.customer_name);
                    $('#address').val(data.address);
                    $('#suite').val(data.address_2);
                    $('#city').val(data.city);
                    $('#zip').val(data.zip);
                    $('#country').val(data.country_id);
                    $('#phone').val(data.phone);
                    $('#fax').val(data.fax);
                    $('#mobile').val(data.mobile);
                    $('#email').val(data.email);
                    $('#price_level_label_id').val(data.price_list_label_id).trigger('change');
                    $('#primary_sales_person_id').val(data.sales_person_id).trigger('change');
                    $('#secondary_sales_person_id').val(data.secondary_sales_person_id);
                    $('#sales_tax_id').val(data.sales_tax_id).trigger('change');
                    $('#searchCustomer').modal('hide');
                });
            },
        });

        //associate pop up
        $(' #nameFilter,#codeFilter,#phoneFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_associate_list.draw();
        });
        let currentNameField = null;
        let currentIdField = null;

        // Handle search icon click to store the correct input fields
        $('.input-group-text').on('click', function() {
            const container = $(this).closest('.d-flex');
            currentNameField = container.find('input[type="text"]');
            currentIdField = container.find('input[type="hidden"]');
        });

        // DataTable initialization
        var table_associate_list = $('#associateListTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('opportunities.associate_list') }}",
                data: function(d) {
                    d.associateName = $('#nameFilter').val();
                    d.associateCode = $('#codeFilter').val();
                    d.contact = $('#phoneFilter').val();
                }
            },
            columns: [{
                    data: 'associate_name',
                    name: 'associate_name'
                },
                {
                    data: 'associate_code',
                    name: 'associate_code'
                },
                {
                    data: 'primary_phone',
                    name: 'primary_phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
            ],
            rowCallback: function(row, data, index) {
                $(row).attr('data-associate-id', data.id); // Store associate ID in the row attribute

                // Handle row click to insert data into the correct fields
                $(row).on('click', function() {
                    if (currentNameField && currentIdField) {
                        currentNameField.val(data.associate_name); // Set the name in the text field
                        currentIdField.val(data.id); // Set the ID in the hidden field

                        // Close the modal
                        $('#searchAssociate').modal('hide');
                    }
                });
            },
        });

        //  clear button
        $('.clear-associate').on('click', function(event) {
            event.preventDefault(); // Prevent any default action, just in case
            const target = $(this).data('target');
            $(`#${target}_id`).val('');
            $(`#${target}_name`).val('');
        });

        //pop up ship to
        $(' #shipToNameFilter,#shipToCodeFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_ship_to_list.draw();
        });

        $('#ship_to,#ship_to_icon').on('click', function() {
            let customer_id = $('#billing_customer_id').val();
            if (customer_id) {
                $('#searchShipTo').modal('show');
                if ($.fn.DataTable.isDataTable('#shipToListTable')) {
                    table_ship_to_list.ajax.url(
                        "{{ route('opportunities.ship_to_list', ':id') }}".replace(':id', customer_id)
                    ).load();
                } else {
                    table_ship_to_list = $('#shipToListTable').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        searching: false,
                        ajax: {
                            url: "{{ route('opportunities.ship_to_list', ':id') }}".replace(':id', customer_id),
                            data: function(d) {
                                d.name = $('#shipToNameFilter').val();
                                d.code = $('#shipToCodeFilter').val();
                            }
                        },
                        columns: [{
                                data: 'customer_name',
                                name: 'customer_name'
                            },
                            {
                                data: 'customer_code',
                                name: 'customer_code'
                            },
                            {
                                data: 'address',
                                name: 'address'
                            }
                        ],
                        rowCallback: function(row, data, index) {
                            $(row).on('click', function() {
                                $('#ship_to_id').val(data.id);
                                $('#ship_to').val(data.customer_name);
                                $('#ship_to_name').val(data.customer_name_1);
                                $('#sales_tax_id').val(data.tax_code_id);

                                // Close the modal
                                $('#searchShipTo').modal('hide');
                            });
                        }
                    });
                }
            } else {
                alert('First select billing customer');
            }
        });

        $('#cancelButton').click(function() {
            window.location.href = "{{ route('opportunities.index') }}";
        });

        // Function to copy the billing customer name to a target field
        function copyBillingCustomer(target) {
            let billingCustomer = $('#billing_customer_name').val();
            $(target).val(billingCustomer || '');
        }

        // Function to concatenate lot and sub-division with the billing customer name
        function setCustomerWithLotAndDivision(lotSelector, subDivisionSelector, target) {
            let billingCustomer = $('#billing_customer_name').val();
            let lot = $(lotSelector).val();
            let subDivision = $(subDivisionSelector).val();
            let formattedCustomer = billingCustomer;
            if (lot || subDivision) {
                formattedCustomer += ` (${lot || ''}/${subDivision || ''})`;
            }
            $(target).val(formattedCustomer);
        }

        // Event listeners for pick and delivery operations
        $('#copy_bill_to').click(function() {
            copyBillingCustomer('#ship_to_job_name');
        });
        $('#copy_lot_division').click(function() {
            setCustomerWithLotAndDivision('#ship_to_lot', '#ship_to_sub_division', '#ship_to_job_name');
        });
        $('#ship_to_copy_bill').click(function() {
            const fields = [{
                    from: 'billing_customer_id',
                    to: 'ship_to_id'
                },
                {
                    from: 'billing_customer_name',
                    to: 'ship_to_name'
                },
                {
                    from: 'address',
                    to: 'ship_to_address'
                },
                {
                    from: 'suite',
                    to: 'ship_to_suite'
                },
                {
                    from: 'city',
                    to: 'ship_to_city'
                },
                {
                    from: 'state',
                    to: 'ship_to_state'
                },
                {
                    from: 'zip',
                    to: 'ship_to_zip'
                },
                {
                    from: 'country',
                    to: 'ship_to_country_id'
                },
                {
                    from: 'phone',
                    to: 'ship_to_phone'
                },
                {
                    from: 'fax',
                    to: 'ship_to_fax'
                },
                {
                    from: 'mobile',
                    to: 'ship_to_mobile'
                },
                {
                    from: 'email',
                    to: 'ship_to_email'
                }
            ];

            // Loop through each field and copy the values
            fields.forEach(({
                from,
                to
            }) => {
                $(`#${to}`).val($(`#${from}`).val());
            });
        });

        //ship to fields hide and show
        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(button => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-type');
                document.querySelectorAll('.conditional-fields').forEach(field => field.classList.add('d-none'));
                document.querySelector(`#${type}-fields`).classList.remove('d-none');
                document.querySelector(`#${type}-freight-fields`).classList.remove('d-none');
            });
        });


    const fullToolbar = [
        ['bold', 'italic', 'underline', 'strike'],
        [{
            color: []
        }, {
            background: []
        }],
        [{
            script: 'super'
        }, {
            script: 'sub'
        }],
        [{
            header: '1'
        }, {
            header: '2'
        }, 'blockquote', 'code-block'],
        [{
            list: 'ordered'
        }, {
            list: 'bullet'
        }, {
            indent: '-1'
        }, {
            indent: '+1'
        }],
        [{
            direction: 'rtl'
        }],
        ['clean']
    ];

    const descriptionEditor = new Quill('#print_doc_description_editor_content', {
        bounds: '#print_doc_description_editor_content',
        placeholder: 'Type Description...',
        modules: {
            formula: true,
            toolbar: fullToolbar
        },
        theme: 'snow',
    });

    // descriptionEditor.on('text-change', function() {
    //     document.getElementById('policy').value = descriptionEditor.root.innerHTML;
    // });

    clearEditor()

    function clearEditor() {
        descriptionEditor.setContents([]);
    }*/





    });
</script>
