<script type="text/javascript">
    $(function() {

        // CSRF token setup for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var opportunity_contact_list = $('#customerContactListTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('sale_orders.contacts.list', ':id') }}".replace(':id', $('#customer_id').val()),
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
                    url: "{{ route('sale_orders.contact.save') }}",
                    method: 'POST',
                    data: {
                        sales_order_id: $('input[name="sales_order_id"]').val(),
                        contact_id: selectedContactIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            resetTableCheckboxes();
                            window.location.reload();
                            let contactHTML = '';
                            response.contacts.forEach(function(contact) {
                                contactHTML += `
                            <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_${contact.sale_order_contact_id}">
                                <span class="fw-semibold">${contact.name}</span>
                                <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="${contact.sale_order_contact_id}">
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
            var url = "{{ route('sale_orders.contacts.destroy', ':id') }}".replace(':id', id);
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
                            window.location.reload();
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

        //internal notes update
        $('#updateInternalNote').click(function() {
            var internalNotes = $('#internal_notes').val();
            var opportunityId = $('#sales_order_id').val();
            var loggedInUser = $('#logged_in_user').val();
            var currentDateTime = new Date().toLocaleString();
            var updatedNotes = `${loggedInUser} ${currentDateTime} : ${internalNotes} \n\n`;
            if (internalNotes) {
                $.ajax({
                    url: "{{ route('sale_orders.internal_notes', ':id ') }}".replace(':id', opportunityId),
                    type: 'PATCH',
                    data: {
                        internal_notes: updatedNotes,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#internal_notes_input').val(response.data);
                            $('#internal_notes').val('');
                            showToast('success', response.msg);
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        } else {
                            alert('Failed to update internal notes: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating internal notes');
                    }
                });
            } else {
                alert('Please enter some notes');
            }
        });
        //probability close
        $('#probability_to_close_id').change(function() {
            var selectedValue = $(this).val(); // Get the selected value
            var opportunityId = $('#opportunity_id').val(); // Get the opportunity ID

            if (selectedValue) {
                $.ajax({
                    url: "{{ route('opportunities.probability_close', ':id') }}".replace(':id', opportunityId),
                    type: 'PATCH',
                    data: {
                        probability_to_close_id: selectedValue, // Send the selected value
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            opportunity_contact_list.draw();
                            handleAjaxResponse(response, opportunity_contact_list);
                        } else {
                            alert('Failed to update probability close: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating probability close');
                    }
                });
            }
        });
        //opportunity stage
        $('#opportunity_stage_id').change(function() {
            var selectedValue = $(this).val(); // Get the selected value
            var opportunityId = $('#opportunity_id').val(); // Get the opportunity ID

            if (selectedValue) {
                $.ajax({
                    url: "{{ route('opportunities.stages', ':id') }}".replace(':id', opportunityId),
                    type: 'PATCH',
                    data: {
                        opportunity_stage_id: selectedValue, // Send the selected value
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                        } else {
                            alert('Failed to update opportunity stages: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating opportunity stages');
                    }
                });
            }
        });


    });

    function toggleTaxCode() {
        const checkbox = document.getElementById("is_ship_to_address");
        const taxCodeContainer = document.getElementById("taxCodeContainer");
        const taxCodeSelect = document.getElementById("tax_code_id");

        if (checkbox.checked) {
            taxCodeContainer.style.display = "block";
            taxCodeSelect.setAttribute("required", "required");
            taxCodeSelect.classList.add("is-invalid"); // Add Bootstrap's red border
        } else {
            taxCodeContainer.style.display = "none";
            taxCodeSelect.removeAttribute("required");
            taxCodeSelect.classList.remove("is-invalid"); // Remove Bootstrap's red border
            taxCodeSelect.value = ""; // Optionally clear the selection
        }
    }
</script>
