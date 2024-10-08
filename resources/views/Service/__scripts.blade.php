<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#serviceNameFilter, #serviceCategoryFilter, #serviceTypeFilter, #serviceGroupFilter, #servicePriceFilter, #serviceUomFilter').on('keyup change', function(e) {
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
                url: "{{ route('services.list') }}",
                data: function(d) {
                    d.service_name_search = $('#serviceNameFilter').val();
                    d.service_category_search = $('#serviceCategoryFilter').val();
                    d.service_type_search = $('#serviceTypeFilter').val();
                    d.service_group_search = $('#serviceGroupFilter').val();
                    d.service_type_search = $('#serviceTypeFilter').val();
                    d.service_price_search = $('#servicePriceFilter').val();
                    d.service_uom_search = $('#serviceUomFilter').val();
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
                    data: 'service_name',
                    name: 'service_name'
                },
                {
                    data: 'service_sku',
                    name: 'service_sku'
                },
                {
                    data: 'service_category_id',
                    name: 'service_category_id'
                },
                {
                    data: 'service_type_id',
                    name: 'service_type_id'
                },
                {
                    data: 'service_group_id',
                    name: 'service_group_id'
                },
                {
                    data: 'homeowner_price',
                    name: 'homeowner_price'
                },
                {
                    data: 'unit_of_measure_id',
                    name: 'unit_of_measure_id'
                },
                {
                    data: 'status',
                    name: 'status'
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
            buttons: [
                {
                    text: ' <span class="d-none d-sm-inline-block">Add Service Category</span>',
                    className: 'btn btn-secondary me-2',
                    attr: {
                        id: 'Add Service Category',
                    },
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ ('service_categories') }}";
                    }
                },
                {
                    text: ' <span class="d-none d-sm-inline-block">Add Service Type</span>',
                   className: 'btn btn-dark me-2',
                    attr: {
                        id: 'Add Service Type',
                    },
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ ('service_types') }}";
                    }
                },
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Service</span>',
                    className: 'create-new btn btn-primary me-2',
                    attr: {
                        id: 'createService',
                    },
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('services.create') }}";
                    }
                }

            ]


        });



        $('#serviceForm').on('input', 'input, select', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savedata').click(function(e) {

            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#service_id').val() ? "{{ route('services.update', ':id') }}".replace(':id', $('#service_id').val()) : "{{ route('services.store') }}";
            var type = $('#service_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#serviceForm').serialize(),
                dataType: 'json',
                success: function(response) {

                    if (response.status == "success") {
                        $('#serviceForm').trigger("reset");
                        $('#serviceModel').modal('hide');
                        window.location.href = "{{ route('services.index') }}";
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                    window.scrollTo(0, 0);
                }
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteService(id);
            });
        });

        function deleteService(id) {
            var url = "{{ route('services.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('services.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Service");
                $('#showServiceModal').modal('show');
                $('#showServiceForm #service_name').val(data.service_name);

            });
        });

        $('#serviceUomFilter').select2({
            placeholder: 'Select Units of Measure',
            dropdownParent: $('#serviceUomFilter').parent()
        });

        $('#serviceCategoryFilter').select2({
            placeholder: 'Select Service Category',
            dropdownParent: $('#serviceCategoryFilter').parent()
        });

        $('#serviceTypeFilter').select2({
            placeholder: 'Select Service Type',
            dropdownParent: $('#serviceTypeFilter').parent()
        });

        $('#serviceGroupFilter').select2({
            placeholder: 'Select Group',
            dropdownParent: $('#serviceGroupFilter').parent()
        });

        $('#unit_of_measure_id').select2({
            placeholder: 'Select Units of Measure',
            dropdownParent: $('#unit_of_measure_id').parent()
        });

        $('#service_category_id').select2({
            placeholder: 'Select Service Category',
            dropdownParent: $('#service_category_id').parent()
        });

        $('#service_type_id').select2({
            placeholder: 'Select Service Type',
            dropdownParent: $('#service_type_id').parent()
        });

        $('#service_group_id').select2({
            placeholder: 'Select Group',
            dropdownParent: $('#service_group_id').parent()
        });

        $('#gl_sales_account_id').select2({
            placeholder: 'Select Sales/Income Account',
            dropdownParent: $('#gl_sales_account_id').parent()
        });

        $('#gl_cost_of_sales_account_id').select2({
            placeholder: 'Select Purchasing/Expense',
            dropdownParent: $('#gl_cost_of_sales_account_id').parent()
        });

        $('#expenditure_id').select2({
            placeholder: 'Select Expenditure',
            dropdownParent: $('#expenditure_id').parent()
        });

        $('#price_range_id').select2({
            placeholder: 'Select Price Range',
            dropdownParent: $('#price_range_id').parent()
        });



        $(document).on('click', '.change_status', function() {

        var id = $(this).data('id');
        var button = $(this);
        var url = "{{ route('services.service_change_status', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status === 'success') {
                    if (response.new_status == 1) {
                        button.removeClass('btn-danger').addClass('btn-success').text('Active');
                    } else {
                        button.removeClass('btn-success').addClass('btn-danger').text('Inactive');
                    }
                    showToast('success', response.msg);
                }
            }
        });
        });

    });
</script>
