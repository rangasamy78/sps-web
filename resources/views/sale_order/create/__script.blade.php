<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#formAddNewCustomer input, #formAddNewCustomer select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });
        $('#print_doc_disclaimer_id').on('change', function() {
            var selectedStep = document.getElementById("print_doc_disclaimer_id").value;
            axios.get(`/sps-web/sale_orders/get-record/${selectedStep}`)
                .then(function(response) {
                    document.querySelector('.ql-editor').innerHTML = response.data.data;
                })
                .catch(function(error) {
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
                        $('#customer_type_id, #parent_customer_id, #referred_by_id,#parent_location_id,#sales_person_id,#secondary_sales_person_id,#payment_terms_id,#sales_tax_id,#price_list_label_id')
                            .val(null).trigger('change');
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
                document.getElementById('shipping_address').value = document.getElementById('address')
                    .value;
                document.getElementById('shipping_address_2').value = document.getElementById(
                    'address_2').value;
                document.getElementById('shipping_city').value = document.getElementById('city').value;
                document.getElementById('shipping_state').value = document.getElementById('state')
                .value;
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
                        $('#associate_type_id,#country_id, #location_id, #primary_sales_id')
                            .val(null).trigger('change');
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

        $(' #customerNameFilter,#customerCodeFilter,#contactFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_customer_list.draw();
        });
        var table_customer_list = $('#customerListTable').DataTable({
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
                    $('#price_level_label_id').val(data.price_list_label_id).trigger(
                        'change');
                    $('#primary_sales_person_id').val(data.sales_person_id).trigger(
                        'change');
                    $('#secondary_sales_person_id').val(data.secondary_sales_person_id);
                    $('#sales_tax_id').val(data.sales_tax_id).trigger('change');
                    $('#searchCustomer').modal('hide');
                });
            },
        });

        $(' #nameFilter,#codeFilter,#phoneFilter', ).on('keyup change', function(e) {
            e.preventDefault();
            table_associate_list.draw();
        });
        let currentNameField = null;
        let currentIdField = null;

        $('.input-group-text').on('click', function() {
            const container = $(this).closest('.d-flex');
            currentNameField = container.find('input[type="text"]');
            currentIdField = container.find('input[type="hidden"]');
        });

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
                $(row).attr('data-associate-id', data.id);
                $(row).on('click', function() {
                    if (currentNameField && currentIdField) {
                        currentNameField.val(data.associate_name);
                        currentIdField.val(data.id);
                        $('#searchAssociate').modal('hide');
                    }
                });
            },
        });

        $('.clear-associate').on('click', function(event) {
            event.preventDefault();
            const target = $(this).data('target');
            $(`#${target}_id`).val('');
            $(`#${target}_name`).val('');
        });

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
                        "{{ route('opportunities.ship_to_list', ':id') }}".replace(':id',
                            customer_id)
                    ).load();
                } else {
                    table_ship_to_list = $('#shipToListTable').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        searching: false,
                        ajax: {
                            url: "{{ route('opportunities.ship_to_list', ':id') }}".replace(
                                ':id', customer_id),
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

        function copyBillingCustomer(target) {
            let billingCustomer = $('#billing_customer_name').val();
            $(target).val(billingCustomer || '');
        }

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

            fields.forEach(({
                from,
                to
            }) => {
                $(`#${to}`).val($(`#${from}`).val());
            });
        });

        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(button => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-type');
                document.querySelectorAll('.conditional-fields').forEach(field => field
                    .classList.add('d-none'));
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

        clearEditor()

        function clearEditor() {
            descriptionEditor.setContents([]);
        }

    });
</script>
