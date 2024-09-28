<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#authorityNameFilter, #codeFilter, #cityFilter, #stateFilter, #zipFilter, #taxNumberFilter').on('keyup change', function(e) {
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
                url: "{{ route('tax_authorities.list') }}",
                data: function(d) {
                    d.authority_name = $('#authorityNameFilter').val();
                    d.authority_code = $('#codeFilter').val();
                    d.city = $('#cityFilter').val();
                    d.state = $('#stateFilter').val();
                    d.zip = $('#zipFilter').val();
                    d.tax_number = $('#taxNumberFilter').val();

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
                    data: 'authority_name',
                    name: 'authority_name'
                },
                {
                    data: 'authority_code',
                    name: 'authority_code'
                },
                {
                    data: 'city',
                    name: 'city'
                },
                {
                    data: 'state',
                    name: 'state'
                },
                {
                    data: 'zip',
                    name: 'zip'
                },
                {
                    data: 'tax_number',
                    name: 'tax_number'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Tax Authorities</span>',
                className: 'create-new btn btn-primary',
                action: function (e, dt, node, config) {
                    // Redirect to Laravel route
                    window.location.href = "{{ route('tax_authorities.create') }}";
                }
            }],

        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = $('#tax_authority_id').val() ? "{{ route('tax_authorities.update', ':id') }}".replace(':id', $('#tax_authority_id').val()) : "{{ route('tax_authorities.store') }}";
            var type = $('#tax_authority_id').val() ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: type,
                data: $('#taxAuthorityForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        setTimeout(function() {
                            window.location.href = "{{ route('tax_authorities.index') }}";
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('#country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#country_id').parent()
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCustomer(id);
            });
        });

        function deleteCustomer(id) {
            var url = "{{ route('tax_authorities.destroy', ':id') }}".replace(':id', id);
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
