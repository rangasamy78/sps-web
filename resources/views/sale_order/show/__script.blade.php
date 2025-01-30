<script type="text/javascript">
    $(function() {
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
                url: "{{ route('sale_orders.contacts.list', ':id') }}".replace(':id', $('#customer_id')
                    .val()),
                data: function(d) {}
            },
            columns: [{
                    data: 'select_all',
                    name: 'select_all',
                    orderable: false
                },
                {
                    data: 'contact_name',
                    name: 'contact_name',
                    orderable: true
                },
                {
                    data: 'lot_subdivision',
                    name: 'lot_subdivision',
                    orderable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    orderable: true
                }
            ],
            rowCallback: function(row, data, index) {}
        });

        $('#selectAllCheckbox').on('click', function() {
            var checked = this.checked;
            $('.contact-checkbox').each(function() {
                this.checked = checked;
            });
        });

        $('#saveContact').click(function() {
            let selectedContactIds = [];
            $('.contact-checkbox:checked').each(function() {
                selectedContactIds.push($(this).data('id'));
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
        $('#setupNewContact').on('click', function(e) {
            document.getElementById("taxCodeContainer").style.display = 'none';
            $('#saveCustomerContactForm')[0].reset();
        });

        $('#saveCustContact').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#contact_id').val() ? "{{ route('customers.contacts.update', ':id') }}"
                .replace(':id', $('#contact_id').val()) : "{{ route('customers.contacts.save') }}";
            var type = $('#contact_id').val() ? "PUT" : "POST";
            $.ajax({
                type: type,
                url: url,
                data: $('#saveCustomerContactForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                        $('#saveCustomerContactForm').trigger("reset");
                        $('#saveCustomerContactModal').modal('hide');
                        opportunity_contact_list.row.add([
                            response.data.contact_name,
                            response.data.title,
                            response.data.primary_phone,
                            response.data.email,
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

        $('#updateInternalNote').click(function() {
            var internalNotes = $('#internal_notes').val();
            var opportunityId = $('#sales_order_id').val();
            var loggedInUser = $('#logged_in_user').val();
            var currentDateTime = new Date().toLocaleString();
            var updatedNotes = `${loggedInUser} ${currentDateTime} : ${internalNotes} \n\n`;
            if (internalNotes) {
                $.ajax({
                    url: "{{ route('sale_orders.internal_notes', ':id ') }}".replace(':id',
                        opportunityId),
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

        $('#probability_to_close_id').change(function() {
            var selectedValue = $(this).val();
            var opportunityId = $('#opportunity_id').val();

            if (selectedValue) {
                $.ajax({
                    url: "{{ route('opportunities.probability_close', ':id') }}".replace(':id',
                        opportunityId),
                    type: 'PATCH',
                    data: {
                        probability_to_close_id: selectedValue,
                        _token: '{{ csrf_token() }}'
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

        $('#opportunity_stage_id').change(function() {
            var selectedValue = $(this).val();
            var opportunityId = $('#opportunity_id').val();
            if (selectedValue) {
                $.ajax({
                    url: "{{ route('opportunities.stages', ':id') }}".replace(':id',
                        opportunityId),
                    type: 'PATCH',
                    data: {
                        opportunity_stage_id: selectedValue,
                        _token: '{{ csrf_token() }}'
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
            taxCodeSelect.classList.add("is-invalid");
        } else {
            taxCodeContainer.style.display = "none";
            taxCodeSelect.removeAttribute("required");
            taxCodeSelect.classList.remove("is-invalid");
            taxCodeSelect.value = "";
        }
    }
</script>
