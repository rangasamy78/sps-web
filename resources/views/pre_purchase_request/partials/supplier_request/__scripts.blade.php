<script type="text/javascript">
    $(function() {
        var id = $("#internalNoteForm #pre_purchase_request_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#prePurchaseRequestSupplierRequest').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('pre_purchase_supplier_requests.list') }}",
                data: function(d) {
                    d.id = id;
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
                }, // Row index column
                {
                    data: 'requested_date',
                    name: 'requested_date',
                },
                {
                    data: 'requested_sent',
                    name: 'requested_sent',
                },
                {
                    data: 'supplier_name',
                    name: 'supplier_name',
                },
                {
                    data: 'response_date',
                    name: 'response_date',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'compare',
                    name: 'compare',
                },
                {
                    data: 'request',
                    name: 'request',
                },
                {
                    data: 'response',
                    name: 'response',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                    text: '<span class="d-none d-sm-inline-block">Add Supplier Requests</span>',
                    className: 'btn btn-secondary me-2',
                    attr: {
                        id: 'createSupplierRequests',
                    },
                    action: function(e, dt, node, config) {
                        var createUrl = "{{ route('pre_purchase_supplier_requests.create') }}?id=" + id;
                            window.location.href = createUrl;
                    }
                },
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Multiple Supplier Requests</span>',
                    className: 'create-new btn btn-primary me-2',
                    attr: {
                        id: 'createMultipleSupplierRequests',
                    },
                    action: function(e, dt, node, config) {
                        var createUrl = "{{ route('pre_purchase.multiple.create') }}?id=" + id;
                        window.location.href = createUrl;
                    }
                }
            ]
        });

        $('#supplier_id').change(function() {
            var addressUrl = "{{ route('get_supplier_address') }}";
            var supplierId = $(this).val();
            $.ajax({
                url: addressUrl,
                method: 'GET',
                data: {
                    id: supplierId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        setSupplierFields(response.data);
                        $('#email_contact_id').empty();
                        $('#email_contact_id').append(new Option('Select Email Contact', '', true, true));
                        $.each(response.data.contacts, function(index, address) {
                            if (address.contact_name) {
                                $('#email_contact_id').append(new Option(address.contact_name + " - " + response.data.name, address.id));
                            }
                        });
                    } else {
                        setSupplierFields({});
                    }
                },
                error: function() {
                    setSupplierFields({});
                    Swal.fire('Error', 'Failed to fetch supplier address',
                        'error');
                }
            });
        });

        function setSupplierFields(data) {
            $("#supplierRequestForm #email_contact").show();
            $('#supplier_address').val(data.supplier_address || '');
            $('#supplier_suite').val(data.supplier_suite || '');
            $('#supplier_city').val(data.supplier_city || '');
            $('#supplier_state').val(data.supplier_state || '');
            $('#supplier_zip').val(data.supplier_zip || '');
            $('#supplier_country_id').val(data.supplier_country_id || '').trigger('change');
            $('#payment_term_id').val(data.payment_term_id || '').trigger('change');
        }


        $('#email_contact_id').change(function() {
            var emailContactUrl = "{{ route('get_contact_address') }}";
            var email_contactId = $(this).val();
            $.ajax({
                url: emailContactUrl,
                method: 'GET',
                data: {
                    id: email_contactId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $("#email").val(response.data.email);
                    } else {
                        $("#email").val('');
                    }
                },
                error: function() {

                    Swal.fire('Error', 'Failed to fetch email_contact address',
                        'error');
                }
            });
        });

        $('#saveSupplierData').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = $('#supplier_request_id').val() ? "{{ route('pre_purchase_supplier_requests.update', ':id') }}".replace(':id',
                $('#supplier_request_id').val()) : "{{ route('pre_purchase_supplier_requests.store') }}";
            var type = $('#supplier_request_id').val() ? "PUT" : "POST";
            var id = $("#pre_purchase_request_id").val();
            $.ajax({
                url: url,
                type: type,
                data: $('#supplierRequestForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        setTimeout(function() {
                            window.location.href = "{{ route('pre_purchase_requests.show', ':id') }}".replace(':id', id);
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    handleArrayAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        // $('#supplier_id').select2({
        //     placeholder: 'Select supplier',
        //     dropdownParent: $('#supplier_id').parent()
        // });

        $('#requested_by_id').select2({
            placeholder: 'Select Requested by',
            dropdownParent: $('#requested_by_id').parent()
        });

        $('#supplier_country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#supplier_country_id').parent()
        });

        $('#payment_term_id').select2({
            placeholder: 'Select Payment term',
            dropdownParent: $('#payment_term_id').parent()
        });

    });

</script>
