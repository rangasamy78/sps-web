<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        
        $('#associateNameFilter, #addressFilter, #phoneFilter, #associateTypeFilter').on('keyup change', function(e) {
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
                url: "{{ route('associates.list') }}",
                data: function(d) {
                    d.associate_name_code_contact_search = $('#associateNameFilter').val();
                    d.address_search = $('#addressFilter').val();
                    d.phone_fax_email_search = $('#phoneFilter').val();
                    d.associate_type_search = $('#associateTypeFilter').val();

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
                    data: 'associate_name',
                    name: 'associate_name'
                },
                {
                    data: 'associate_type_id',
                    name: 'associate_type_id'
                },
                {
                    data: 'location_id',
                    name: 'location_id'
                },
                {
                    data: 'address_combined',
                    name: 'address'
                },
                {
                    data: 'phone_combined',
                    name: 'primary_phone'
                },
                {
                    data: 'email_combined',
                    name: 'email'
                },
                {
                    data: 'internal_notes',
                    name: 'internal_notes'
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
            buttons: [{
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Associate</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        id: 'createAssociate',
                    },
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('associates.create') }}";
                    }
                }],
                action: function(e, dt, node, config) {

                    $('#savedata').html("Save Associate");
                    $('#associate_id').val('');
                    $('#associateForm').trigger("reset");
                    $('.associate_name_error').html('');
                    $('#modelHeading').html("Create New Associate");
                    $('#associateModel').modal('show');
                }

        });


        $('#country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#country_id').parent()
        });

        $('#associate_type_id').select2({
            placeholder: 'Select Associate Type',
            dropdownParent: $('#associate_type_id').parent()
        });

        $('#associateTypeFilter').select2({
            placeholder: 'Select Associate Type',
            dropdownParent: $('#associateTypeFilter').parent()
        });

        $('#referred_by_id').select2({
            placeholder: 'Select Referred By',
            dropdownParent: $('#referred_by_id').parent()
        });

        $('#location_id').select2({
            placeholder: 'Select Location',
            dropdownParent: $('#location_id').parent()
        });
        $('#route_id').select2({
            placeholder: 'Select Route',
            dropdownParent: $('#route_id').parent()
        });
        $('#primary_sales_id').select2({
            placeholder: 'Select Primary Sales Person',
            dropdownParent: $('#primary_sales_id').parent()
        });

        $('#secondary_sales_id').select2({
            placeholder: 'Select Secondary Sales Person',
            dropdownParent: $('#secondary_sales_id').parent()
        });



        $('#associateForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#associate_id').val() ? "{{ route('associates.update', ':id') }}".replace(':id', $('#associate_id').val()) : "{{ route('associates.store') }}";
            var type = $('#associate_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#associateForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#associateForm').trigger("reset");
                        $('#associateModel').modal('hide');
                        showToast('success', response.msg);
                        window.location.href = "{{ route('associates.index') }}";
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
                deleteAssociate(id);
            });
        });

        function deleteAssociate(id) {
            var url = "{{ route('associates.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('associates.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Associate");
                $('#savedata').val("edit-associate");
                $('#showAssociateModal').modal('show');
                $('#showAssociateForm #associate_name').val(data.associate_name);

            });
        });

    $(document).on('click', '.change_status', function() {

    var id = $(this).data('id');
    var button = $(this);
    var url = "{{ route('associates.associate_change_status', ':id') }}";
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
