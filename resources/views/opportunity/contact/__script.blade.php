<script type="text/javascript">
    $(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable for opportunityCrmEvent
        // var $id = $('#opportunity_id').val();
        var table_opportunity_bill_to_contact = $('#opportunityBillToContact').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('opportunities.bill_to_contacts.list',':id') }}".replace(':id', $('#customer_id').val()),
                type: 'GET',
                data: function(d) {
                    // Optional data to be sent with the request
                },
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
                    data: 'lot_subdivision',
                    name: 'lot_subdivision'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'fax_email',
                    name: 'fax_email'
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
                $(row).addClass('row-' + data.id);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: ' <span class="d-none d-sm-inline-block">Attach Contact</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal', // Corrected from 'model' to 'modal'
                    'data-bs-target': '#listCustomerContact',
                    'aria-controls': 'crmEvent',
                },
                action: function(e, dt, node, config) {
                    // Custom action here
                }
            }],
        });
        // Save bill to contact 
        $(document).on('click', '.addContactBtn', function() {
            var contact_id = $(this).data('id');
            var opportunity_id = $('input[name="opportunity_id"]').val();
            if (contact_id && opportunity_id) {
                $.ajax({
                    url: "{{ route('opportunities.contact.save') }}",
                    method: 'POST',
                    data: {
                        opportunity_id: opportunity_id,
                        contact_id: [contact_id],
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            table_opportunity_bill_to_contact.draw();
                            opportunity_contact_list.draw();
                            let contactHTML = '';
                            response.contacts.forEach(function(contact) {
                                contactHTML += `
                            <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_${contact.opportunity_contact_id}">
                                <span class="fw-semibold">${contact.name}</span>
                                <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="${contact.opportunity_contact_id}">
                                    <i class="fas fa-trash-alt fa-xs"></i>
                                </button>
                            </div>`;
                            });
                            $('.showContact').html(contactHTML);

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
                showToast('warning', 'Please select a contact first.');
            }
        });

        $('body').on('click', '.editContactBtn', function() {
            var id = $(this).data('id');
            // $("#modalCenterTitle").html("");
            $.get("{{ route('customers.contacts.edit', ':id') }}".replace(':id', id), function(data) {
                $('#modalTitle').html("Update Contact");
                $('#saveCustContact').html("Update Contact");
                $('#saveCustomerContactModal').modal('show');
                $('#contact_id').val(data.id);
                $('#contact_name').val(data.contact_name);
                $('#type').val(data.type);
                $('#type_id').val(data.type_id);
                $('#title').val(data.title);
                $('#address').val(data.address);
                $('#address_2').val(data.address_2);
                $('#city').val(data.city);
                $('#state').val(data.state);
                $('#zip').val(data.zip);
                $('#county_id').val(data.county_id);
                $('#country_id').val(data.country_id);
                $('#primary_phone').val(data.primary_phone);
                $('#secondary_phone').val(data.secondary_phone);
                $('#mobile').val(data.mobile);
                $('#email').val(data.email);
                $('#fax').val(data.fax);
                $('.internal_notes').val(data.internal_notes);
                $('#is_ship_to_address').prop('checked', data.is_ship_to_address);
                if (data.is_ship_to_address == 1) {
                    $('#taxCodeContainer').show();
                    $('#tax_code_id').val(data.tax_code_id);
                } else {
                    $('#tax_code_id').val('');
                    $('#taxCodeContainer').hide();
                }
            });
        });
        // Delete opportunity contact using delegated event handler
        $(document).on('click', '.deleteBillToContactBtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteOpportunityBillToContact(id);
            });
        });

        function deleteOpportunityBillToContact(id) {
            var url = "{{ route('opportunities.bill_to_contacts.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Remove the deleted contact from the DOM
                        handleAjaxResponse(response, table_opportunity_bill_to_contact);
                        $(`#contact_${response.id}`).remove();
                        table_opportunity_bill_to_contact.draw();
                        opportunity_contact_list.draw();
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

        //opportunity contact save (02-01-2025)
        var opportunity_contact_list = $('#customerContactListTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('opportunities.contacts.list', ':id') }}".replace(':id', $('#customer_id').val()),
                data: function(d) {
                    // You can add additional parameters to the request if needed
                }
            },
            columns: [{
                    data: 'select_all',
                    name: 'select_all', // This column should be orderable as false
                    orderable: false // Checkbox column should not be orderable
                },
                {
                    data: 'contact_name',
                    name: 'contact_name',
                    orderable: true // Enable ordering for the contact name column
                },
                {
                    data: 'lot_subdivision',
                    name: 'lot_subdivision',
                    orderable: true // Enable ordering for lot/subdivision
                },
                {
                    data: 'phone',
                    name: 'phone',
                    orderable: true // Enable ordering for the phone number column
                }
            ],
            rowCallback: function(row, data, index) {
                // Optional: Add any row-specific logic if needed
            }
        });

        // Select All Checkbox Functionality
        $('#selectAllCheckbox').on('click', function() {
            var checked = this.checked;
            $('.contact-checkbox').each(function() {
                this.checked = checked;
            });
        });


        // Save Contact - Collects selected contacts and sends them to the server
        $('#saveContact').click(function() {
            let selectedContactIds = [];
            $('.contact-checkbox:checked').each(function() {
                selectedContactIds.push($(this).data('id')); // Collect IDs from data-id attribute
            });

            if (selectedContactIds.length > 0) {
                $.ajax({
                    url: "{{ route('opportunities.contact.save') }}",
                    method: 'POST',
                    data: {
                        opportunity_id: $('input[name="opportunity_id"]').val(),
                        contact_id: selectedContactIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            resetTableCheckboxes();
                            let contactHTML = '';
                            response.contacts.forEach(function(contact) {
                                contactHTML += `
                                <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_${contact.opportunity_contact_id}">
                                <span class="fw-semibold">${contact.name}</span>
                                <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="${contact.opportunity_contact_id}">
                                <i class="fas fa-trash-alt fa-xs"></i>
                                </button>
                                </div>`;
                            });
                            $('.showContact').html(contactHTML);
                            table_opportunity_bill_to_contact.draw();
                            opportunity_contact_list.draw();
                        } else {
                            showToast('danger', response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                    }
                });
            } else {
                alert("Please select at least one contact.");
            }
        });


        function resetTableCheckboxes() {
            const checkboxes = document.querySelectorAll('#customerContactListTable .contact-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            document.getElementById('selectAllCheckbox').checked = false;
        }

        // Delete opportunity contact using delegated event handler
        $(document).on('click', '.delete-contact', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteOpportunityContact(id);
            });
        });

        function deleteOpportunityContact(id) {
            var url = "{{ route('opportunities.contacts.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Remove the deleted contact from the DOM
                        $(`#contact_${id}`).remove();
                        showToast('success', response.msg);
                        $('#listCustomerContact').modal('hide');
                        setTimeout(function() {
                            table_opportunity_bill_to_contact.draw();
                            opportunity_contact_list.draw();
                        }, 2000);
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

        $('#saveCustomerContactForm input, #saveCustomerContactForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        //reset customer contact form
        $('#setupNewContact').on('click', function(e) {
            document.getElementById("taxCodeContainer").style.display = 'none';
            $('#saveCustomerContactForm')[0].reset(); // Reset form
        });

        $('#saveCustContact').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission
            var button = $(this);
            sending(button);
            var url = $('#contact_id').val() ? "{{ route('customers.contacts.update', ':id') }}".replace(':id', $('#contact_id').val()) : "{{ route('customers.contacts.save') }}";
            var type = $('#contact_id').val() ? "PUT" : "POST";
            $.ajax({
                type: type,
                url: url,
                data: $('#saveCustomerContactForm').serialize(), // Serialize form data
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
                },
                success: function(response) {
                    // Check if response indicates success
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        table_opportunity_bill_to_contact.draw();
                        opportunity_contact_list.draw();
                        $('#saveCustomerContactForm').trigger("reset");
                        $('#saveCustomerContactModal').modal('hide');
                        opportunity_contact_list.row.add([
                            response.data.contact_name, // Adjust these based on your response structure
                            response.data.title,
                            response.data.primary_phone,
                            response.data.email,
                            // Add other fields as needed
                        ]).draw(false)
                        sending(button, true);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
        $('#setupNewContact').on('click', function(e) {
            $('#modalTitle').html("SetUp New Contact");
            $('#saveCustContact').html("Save Contact");
        });

    });
</script>