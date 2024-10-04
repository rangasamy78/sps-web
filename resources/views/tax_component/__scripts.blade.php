<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#componentNameFilter, #authorityFilter, #salesTaxIDFilter').on('keyup change', function(e) {
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
                url: "{{ route('tax_components.list') }}",
                data: function(d) {
                    d.component_name = $('#componentNameFilter').val();
                    d.authority_id = $('#authorityFilter').val();
                    d.sales_tax_id = $('#salesTaxIDFilter').val();
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
                    data: 'sort_order',
                    name: 'sort_order'
                },
                {
                    data: 'component_name',
                    name: 'component_name'
                },
                {
                    data: 'component_tax_id',
                    name: 'component_tax_id'
                },
                {
                    data: 'authority_name',
                    name: 'authority_name'
                },
                {
                    data: 'sales_tax_name',
                    name: 'sales_tax_name'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Tax Component</span>',
                className: 'create-new btn btn-primary',
                action: function (e, dt, node, config) {
                    // Redirect to Laravel route
                    window.location.href = "{{ route('tax_components.create') }}";
                }
            }],

        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = $('#tax_component_id').val() ? "{{ route('tax_components.update', ':id') }}".replace(':id', $('#tax_component_id').val()) : "{{ route('tax_components.store') }}";
            var type = $('#tax_component_id').val() ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: type,
                data: $('#taxComponentForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        setTimeout(function() {
                            window.location.href = "{{ route('tax_components.index') }}";
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('#authority_id').select2({
            placeholder: 'Select Authority',
            dropdownParent: $('#authority_id').parent()
        });

        $('#sales_tax_id').select2({
            placeholder: 'Select Sales Tax Account',
            dropdownParent: $('#sales_tax_id').parent()
        });

        $('#authorityFilter').select2({
            placeholder: 'Select Authority',
            dropdownParent: $('#authorityFilter').parent()
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCustomer(id);
            });
        });

        function deleteCustomer(id) {
            var url = "{{ route('tax_components.destroy', ':id') }}".replace(':id', id);
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

     });
</script>
