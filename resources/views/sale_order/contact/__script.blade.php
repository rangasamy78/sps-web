<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_sales_order_bill_to_contact = $('#sales_orderBillToContact').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('sale_orders.bill_to_contacts.list', ':id') }}".replace(':id', $(
                    '#customer_id').val()),
                type: 'GET',
                data: function(d) {},
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
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#listCustomerContact',
                    'aria-controls': 'crmEvent',
                },
                action: function(e, dt, node, config) {}
            }],
        });

        $(document).on('click', '.addContactBtn', function() {
            var contact_id = $(this).data('id');
            var sales_order_id = $('input[name="sales_order_id"]').val();
            if (contact_id && sales_order_id) {
                $.ajax({
                    url: "{{ route('sale_orders.contact.save') }}",
                    method: 'POST',
                    data: {
                        sales_order_id: sales_order_id,
                        contact_id: [contact_id],
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            window.location.reload();
                            let contactHTML = '';
                            response.contacts.forEach(function(contact) {
                                contactHTML += `
                            <div class="contact-item d-flex justify-content-between border-bottom align-items-center p-1 rounded mb-1" style="font-size:0.75rem;" id="contact_${contact.sales_order_contact_id}">
                                <span class="fw-semibold">${contact.name}</span>
                                <button class="btn btn-label-danger btn-sm rounded-circle delete-contact p-2" data-id="${contact.sales_order_contact_id}">
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

        $(document).on('click', '.deleteBillToContactBtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteSaleOrderBillToContact(id);
            });
        });

        function deleteSaleOrderBillToContact(id) {
            var url = "{{ route('sale_orders.bill_to_contacts.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        handleAjaxResponse(response, table_sales_order_bill_to_contact);
                        $(`#contact_${response.id}`).remove();
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
