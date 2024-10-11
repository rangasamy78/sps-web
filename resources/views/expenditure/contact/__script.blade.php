<script type="text/javascript">
    $(function() {
        var expenditureUrl =  "{{ route('expenditures.contacts.list', ':type_id') }}".replace(':type_id', $('#type_id').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_contact = $('#expenditureContact').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: expenditureUrl,
                data: function(d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'contact_name',
                    name: 'contact_name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'primary_phone',
                    name: 'primary_phone'
                },
                {
                    data: 'internal_notes',
                    name: 'internal_notes'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table_contact.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12"i><"col-sm-12"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Contact</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'offcanvas',
                    'data-bs-target': '#offcanvasRight',
                    'aria-controls': 'offcanvasExample',
                },
                action: function(e, dt, node, config) {
                    $('#saveContactForm').trigger("reset");
                }
            }]
        });

        $('#country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#country_id').parent()
        });

        $('#county_id').select2({
            placeholder: 'Select County',
            dropdownParent: $('#country_id').parent()
        });

        $('#saveContactForm input, #saveContactForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savecontactdata').click(function(e) {
            e.preventDefault();
            var button = $('#savecontactdata');
            sending(button);
            $.ajax({
                url: "{{ route('expenditures.contacts.save') }}",
                type: "POST",
                data: $('#saveContactForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#saveContactForm').trigger("reset");
                        table_contact.draw();
                        showToast('success', response.msg);
                        $('#offcanvasRight').offcanvas('hide');
                        sending(button, true);
                        button.attr('data-bs-dismiss', 'offcanvas');
                    } else {
                        button.removeAttr('data-bs-dismiss');
                        if (response.errors) {
                            $.each(response.errors, function(field, error) {
                                $('.' + field + '_error').text(error[0]);
                            });
                        }
                    }
                    button.removeAttr('data-bs-dismiss');
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                    button.removeAttr('data-bs-dismiss');
                }
            });
        });
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteExpenditure(id);
            });
        });

        function deleteExpenditure(id) {
            var url = "{{ route('expenditures.contacts.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    function getIdFromUrl() {
                        let path = window.location.pathname;
                        let segments = path.split('/');
                        return segments.pop();
                    }

                    let id = getIdFromUrl();

                    window.location.href = "{{ route('expenditures.show', ':id') }}".replace(':id', id);
                    handleAjaxResponse(response, table);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.editbtn', function() {
            $('#offcanvasRight').offcanvas('show');
        });

    });
</script>
