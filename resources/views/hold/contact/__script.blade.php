<script type="text/javascript">
    $(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_hold_contact = $('#holdContact').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('hold.contacts.list', ':id') }}".replace(':id', $('#customer_id').val()),
                type: 'GET',
            },
            columns: [{
                    data: 'check',
                    name: 'check',
                    orderable: false
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
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'notes',
                    name: 'notes',
                },
                {
                    data: 'action',
                    name: 'action',
                }
            ],
            rowCallback: function(row, data, index) {
                // Add a class to each row based on its id
                $(row).addClass('row-' + data.id);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: ' <span class="d-none d-sm-inline-block">Add to Hold</span>',
                className: 'create-new btn btn-secondary addContactBtn',
            }],
        });

        // Save bill to contact 
        $(document).on('click', '.addContactBtn', function() {
            var hold_id = $('input[name="hold_id"]').val();
            var selectedContacts = [];
            $('.contact-checkbox:checked').each(function() {
                selectedContacts.push($(this).val());
            });
            if (selectedContacts.length > 0 && hold_id) {
                $.ajax({
                    url: "{{ route('hold.contact.save') }}",
                    method: 'POST',
                    data: {
                        hold_id: hold_id,
                        contact_id: selectedContacts,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            let contactHTML = '';
                            response.contacts.forEach(function(contact) {
                                contactHTML += `
                                    <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_${contact.hold_contact_id}">
                                        <span class="fw-semibold">${contact.name}</span>
                                        <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="${contact.hold_contact_id}">
                                            <i class="fas fa-trash-alt fa-xs"></i>
                                        </button>
                                    </div>`;
                                $('#contact_' + contact.hold_contact_id).find('input[type="checkbox"]').prop('disabled', true);
                            });
                            $('.showContact').html(contactHTML);
                            table_hold_contact.ajax.reload(null, false); // Do not reset pagination
                        } else {
                            showToast('danger', response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        showToast('danger', 'An error occurred while adding contact.');
                    }
                });
            } else {
                showToast('warning', 'Please select at least one contact.');
            }
        });

        // Delete opportunity contact using delegated event handler
        $(document).on('click', '.delete-contact', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteHoldContact(id);
            });
        });

        function deleteHoldContact(id) {
            var url = "{{ route('hold.contacts.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        showToast('success', response.msg);
                        $(`#contact_${id}`)
                            .find('input[type="checkbox"]')
                            .prop('disabled', false);
                        $(`#contact_${id}`).remove();
                        table_hold_contact.ajax.reload(null, false);
                    } else {
                        showToast('danger', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to delete the contact.');
                }
            });
        }

    });
</script>