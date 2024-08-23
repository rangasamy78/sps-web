<script type="text/javascript">
    $(function() {
        var initialCountPriceListLabel = @json($countPriceListLabel);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#priceLabelFilter, #priceCodeFilter, #discountFilter, #marginFilter, #markupFilter, #salesPersonCommissionFilter').on('keyup', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#priceListLabelTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('price_list_labels.list') }}",
                data: function(d) {
                    d.price_label_search = $('#priceLabelFilter').val();
                    d.price_code_search = $('#priceCodeFilter').val();
                    d.discount_search = $('#discountFilter').val();
                    d.margin_search = $('#marginFilter').val();
                    d.markup_search = $('#markupFilter').val();
                    d.sales_person_commission_search = $('#salesPersonCommissionFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 0,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'price_label',
                    name: 'price_label'
                },
                {
                    data: 'price_code',
                    name: 'price_code'
                },
                {
                    data: 'default_discount',
                    name: 'default_discount'
                },
                {
                    data: 'default_margin',
                    name: 'default_margin'
                },
                {
                    data: 'default_markup',
                    name: 'default_markup'
                },
                {
                    data: 'sales_person_commission',
                    name: 'sales_person_commission'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Price List Label</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#priceListLabelModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    // Custom action for Add New Record button
                    $('#savedata').html("Save Price List Label");
                    $('#price_list_label_id').val('');
                    $('#priceListLabelForm').trigger("reset");
                    $('#price_level').val('Price ' + (initialCountPriceListLabel + 1));
                    $('#modelHeading').html("Create New Price List Label");
                    $('#priceListLabelModel').modal('show');
                    clearErrorMessage();
                }
            }],
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right',
                '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left',
                '30px');
        }, 300);
        $('#priceListLabelForm input').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#price_list_label_id').val() ? "{{ route('price_list_labels.update', ':id') }}".replace(':id', $('#price_list_label_id').val()) : "{{ route('price_list_labels.store') }}";
            var type = $('#price_list_label_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#priceListLabelForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#priceListLabelForm').trigger("reset");
                        if (type === 'POST') {
                            initialCountPriceListLabel++;
                            $('#price_level').val('Price ' + (initialCountPriceListLabel + 1));
                        }
                        $('#priceListLabelModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });
        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            clearErrorMessage();
            $.get("{{ route('price_list_labels.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Price List Label");
                $('#savedata').val("edit-price-list-label");
                $('#savedata').html("Update Price List Label");
                $('#priceListLabelModel').modal('show');
                $('#price_list_label_id').val(data.id);
                $('#price_level').val(data.price_level);
                $('#price_code').val(data.price_code);
                $('#price_label').val(data.price_label);
                $('#price_notes').val(data.price_notes);
                $('#default_discount').val(data.default_discount);
                $('#default_margin').val(data.default_margin);
                $('#default_markup').val(data.default_markup);
                $('#sales_person_commission').val(data.sales_person_commission);
                $('input[name="customer_type_id[][customer_type_id]"]').prop('checked', false)
                $.each(data.price_list_customer_type, function(index, item) {
                    $('input[name="customer_type_id[][customer_type_id]"][value="' + item.customer_type_id + '"]').prop('checked', true);
                });
                $('input[name="location_id[][location_id]"]').prop('checked', false);
                $.each(data.price_list_location, function(index, item) {
                    $('input[name="location_id[][location_id]"][value="' + item.location_id + '"]').prop('checked', true);
                });
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deletePriceListLabel(id);
            });
        });

        function deletePriceListLabel(id) {
            var url = "{{ route('price_list_labels.destroy', ':id') }}".replace(':id', id);
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
            clearErrorMessage();
            var id = $(this).data('id');
            $.get("{{ route('price_list_labels.index') }}" + '/' + id, function(data) {
                $('#showPriceListLabelModal').modal('show');
                $('#showPriceListLabelForm #price_level').val(data.price_level);
                $('#showPriceListLabelForm #price_code').val(data.price_code);
                $('#showPriceListLabelForm #price_label').val(data.price_label);
                $('#showPriceListLabelForm #price_notes').val(data.price_notes);
                $('#showPriceListLabelForm #default_discount').val(data.default_discount);
                $('#showPriceListLabelForm #default_margin').val(data.default_margin);
                $('#showPriceListLabelForm #default_markup').val(data.default_markup);
                $('#showPriceListLabelForm #sales_person_commission').val(data.sales_person_commission);
                $('input[name="customer_type_id[][customer_type_id]"]').prop('checked', false)
                $.each(data.price_list_customer_type, function(index, item) {
                    $('input[name="customer_type_id[][customer_type_id]"][value="' + item.customer_type_id + '"]').prop('checked', true);
                });
                $('input[name="location_id[][location_id]"]').prop('checked', false);
                $.each(data.price_list_location, function(index, item) {
                    $('input[name="location_id[][location_id]"][value="' + item.location_id + '"]').prop('checked', true);
                });
            });
        });

        function clearErrorMessage() {
            $('.price_level_error').empty();
            $('.price_code_error').empty();
            $('.price_label_error').empty();
            $('.price_notes_error').empty();
            $('.sales_person_commission_error').empty();
            $('.default_discount_error').empty();
            $('.default_margin_error').empty();
            $('.default_markup_error').empty();
            $('#searchCustomerType').val('');
            $('#searchLocation').val('');
            $('#locationList .location-item').show();
            $('#customerTypeList .customer-item').show();
        }

        //search
        $('#searchCustomerType').on('keyup', function() {
            var searchQuery = $(this).val().toLowerCase();
            $('#customerTypeList .customer-item').each(function() {
                var customerName = $(this).find('.customer-name').text().toLowerCase();
                if (customerName.indexOf(searchQuery) > -1) {
                    $(this).show(); // Show if the query matches
                } else {
                    $(this).hide(); // Hide if the query does not match
                }
            });
        });
    });
</script>
