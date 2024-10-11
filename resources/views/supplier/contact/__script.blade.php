<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Get supplier ID from the input field
        $id = $('#supplier_id').val();

        // Initialize the DataTable
        var table_contact = $('#supplierContact').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('supplier_contacts.list', ':id') }}".replace(':id', $id), // Replace placeholder with the actual ID
                type: 'GET',
                data: function(d) {
                    // Adjust the sorting column dynamically
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1, // Adjust the column number as needed
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
                }
            ],
            rowCallback: function(row, data, index) {
                // Adjust row numbering
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
                    // Add contact button functionality
                }
            }]
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
                url: "{{ route('contacts.save') }}",
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

    });
</script>
