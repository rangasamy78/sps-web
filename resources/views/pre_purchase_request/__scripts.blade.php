<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#transactionNumberFilter,#prePurchaseDateFilter,#supplierFilter,#requiredShipDateFilter,#requestedByFilter')
            .on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
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
                url: "{{ route('pre_purchase_requests.list') }}",
                data: function(d) {
                    d.transaction_number = $('#transactionNumberFilter').val();
                    d.pre_purchase_date = $('#prePurchaseDateFilter').val();
                    d.supplier_id = $('#supplierFilter').val();
                    d.required_ship_date = $('#requiredShipDateFilter').val();
                    d.requested_by_id = $('#requestedByFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [
                {
                    data: 'transaction_number',
                    name: 'transaction_number'
                },
                {
                    data: 'pre_purchase_date',
                    name: 'pre_purchase_date'
                },
                {
                    data: 'supplier_name',
                    name: 'supplier_name'
                },
                {
                    data: 'required_ship_date',
                    name: 'required_ship_date'
                },
                {
                    data: 'age',
                    name: 'age'
                },
                {
                    data: 'requested_by',
                    name: 'requested_by'
                },
                {
                    data: 'requested',
                    name: 'requested'
                },
                {
                    data: 'response',
                    name: 'response'
                },
                {
                    data: 'eta_date',
                    name: 'eta_date'
                },
                {
                    data: 'terms',
                    name: 'terms'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                // $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Pre Purchase Request</span>',
                    className: 'create-new btn btn-primary me-2',
                    attr: {
                        id: 'createPrePurchaseRequest',
                    },
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('pre_purchase_requests.create') }}";
                    }
                }
            ]
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = $('#pre_purchase_request_id').val() ? "{{ route('pre_purchase_requests.update', ':id') }}".replace(':id',
                $('#pre_purchase_request_id').val()) : "{{ route('pre_purchase_requests.store') }}";
            var type = $('#pre_purchase_request_id').val() ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: type,
                data: $('#prePurchaseRequestForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        setTimeout(function() {
                            window.location.href =
                            "{{ route('pre_purchase_requests.index') }}"; // Redirection after 2 seconds (adjust if needed)
                        }, 2000);
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
                deleteCustomer(id);
            });
        });

        function deleteCustomer(id) {
            var url = "{{ route('pre_purchase_requests.destroy', ':id') }}".replace(':id', id);
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
                        $('#supplier_primary_address').empty();
                        $('#supplier_primary_address').append(new Option('Select Address', '', true, true));
                        $.each(response.data.contacts, function(index, address) {
                            if (address.contact_name) {
                                $('#supplier_primary_address').append(new Option(address.contact_name + " - " + response.data.name, address.id));
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
            $('#supplier_address').val(data.supplier_address || '');
            $('#supplier_suite').val(data.supplier_suite || '');
            $('#supplier_city').val(data.supplier_city || '');
            $('#supplier_state').val(data.supplier_state || '');
            $('#supplier_zip').val(data.supplier_zip || '');
            $('#supplier_country_id').val(data.supplier_country_id || '').trigger('change');
            $('#payment_term_id').val(data.payment_term_id || '').trigger('change');
            $('#shipment_term_id').val(data.shipment_term_id || '').trigger('change');
        }

        $('#requested_by_id').select2({
            placeholder: 'Select Requested By Name',
            dropdownParent: $('#requested_by_id').parent()
        });

        $('#requestedByFilter').select2({
            placeholder: 'Select Requested By Name',
            dropdownParent: $('#requestedByFilter').parent()
        });

        $('#supplier_id').select2({
            placeholder: 'Select Supplier Name',
            dropdownParent: $('#supplier_id').parent()
        });

        $('#supplierFilter').select2({
            placeholder: 'Select Supplier Name',
            dropdownParent: $('#supplierFilter').parent()
        });

        $('#purchase_location_id').select2({
            placeholder: 'Select Location',
            dropdownParent: $('#purchase_location_id').parent()
        });

        $('#ship_to_location_id').select2({
            placeholder: 'Select Location',
            dropdownParent: $('#ship_to_location_id').parent()
        });

        $('#ship_to_location_country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#ship_to_location_country_id').parent()
        });

        $('#purchase_location_country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#purchase_location_country_id').parent()
        });

        $('#supplier_country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#supplier_country_id').parent()
        });

        $('#payment_term_id').select2({
            placeholder: 'Select Payment Term',
            dropdownParent: $('#payment_term_id').parent()
        });

        $('#shipment_term_id').select2({
            placeholder: 'Select Shipment Term',
            dropdownParent: $('#shipment_term_id').parent()
        });

        $('#supplier_primary_address').select2({
            placeholder: 'Select Address',
            dropdownParent: $('#supplier_primary_address').parent()
        });

        function fetchAddress(locationId, url, addressType) {
            $.ajax({
                url: url,
                method: 'GET',
                data: { id: locationId },
                success: function(response) {
                    if (response.status === 'success') {
                        setAddressFields(addressType, response.data); // Set fields with response data
                    } else {
                        setAddressFields(addressType, {}); // Clear fields if status is not success
                    }
                },
                error: function() {
                    setAddressFields(addressType, {});
                    Swal.fire('Error', 'Failed to fetch address', 'error');
                }
            });
        }

        function setAddressFields(addressType, data) {
            $('#' + addressType + '_address').val(data.address || '');
            $('#' + addressType + '_city').val(data.city || '');
            $('#' + addressType + '_state').val(data.state || '');
            $('#' + addressType + '_zip').val(data.zip || '');
            $('#' + addressType + '_country_id').val(data.country_id || '').trigger('change');
        }

        $('#purchase_location_id').change(function() {
            var locationId = $(this).val();
            var addressUrl = "{{ route('get_purchase_location_address') }}";  // Replace with actual route name
            fetchAddress(locationId, addressUrl, 'purchase_location');
        });

        $('#ship_to_location_id').change(function() {
            var locationId = $(this).val();
            var addressUrl = "{{ route('get_ship_to_location_address') }}";  // Replace with actual route name
            fetchAddress(locationId, addressUrl, 'ship_to_location');
        });

        var purchaseLocationId = $('#purchase_location_id').val();
        var shipToLocationId = $('#ship_to_location_id').val();

        if (purchaseLocationId) {
            fetchAddress(purchaseLocationId, "{{ route('get_purchase_location_address') }}", 'purchase_location');
        }

        if (shipToLocationId) {
            fetchAddress(shipToLocationId, "{{ route('get_ship_to_location_address') }}", 'ship_to_location');
        }

        setFormattedDateInput('#pre_purchase_date');

        function setFormattedDateInput(selector) {
            var today = new Date();
            var formattedDate = today.getFullYear() + '-' +
            ('0' + (today.getMonth() + 1)).slice(-2) + '-' +
            ('0' + today.getDate()).slice(-2);
            $(selector).val(formattedDate);
            // $(selector).attr('min', formattedDate).val(formattedDate);
        }

        $('#pre_purchase_term_id').change(function() {
            var prePurchaseTermUrl = "{{ route('get_pre_purchase_term_policy') }}";
            var prePurchaseTermId = $(this).val();
            $.ajax({
                url: prePurchaseTermUrl,
                method: 'GET',
                data: {
                    id: prePurchaseTermId
                },
                success: function(response) {
                    $('#terms').val(response.policy);
                },
                error: function() {
                    Swal.fire('Error', 'Failed to fetch supplier address',
                        'error');
                }
            });
        });

        $('#supplier_primary_address').on('change', function () {
            var supplierAddressUrl = "{{ route('get_supplier_primary_address') }}";
            var supplierAddressId = $(this).val();
            $.ajax({
                url: supplierAddressUrl,
                method: 'GET',
                data: {
                    id: supplierAddressId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        setSupplierPrimaryFields(response.data);
                    } else {
                        setSupplierPrimaryFields({});
                    }
                },
                error: function() {
                    setSupplierPrimaryFields({});
                    Swal.fire('Error', 'Failed to fetch supplier address','error');
                }
            });
        });

        function setSupplierPrimaryFields(data) {
            $('#supplier_address').val(data.address || '');
            $('#supplier_suite').val(data.suite || '');
            $('#supplier_city').val(data.city || '');
            $('#supplier_state').val(data.state || '');
            $('#supplier_zip').val(data.zip || '');
            $('#supplier_country_id').val(data.country_id || '').trigger('change');
        }
    });
</script>
