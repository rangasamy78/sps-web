<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_visit = $('#datatablesVisit').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('visit.lists.list') }}",
                data: function(d) {
                    // Pass additional parameters if needed
                }
            },
            columns: [{
                    data: 'date_time',
                    name: 'date_time'
                },
                {
                    data: 'opportunity',
                    name: 'opportunity'
                },
                {
                    data: 'job_name',
                    name: 'job_name'
                },
                {
                    data: 'bill_customer',
                    name: 'bill_customer'
                },
                {
                    data: 'company',
                    name: 'company'
                },
                {
                    data: 'sales_person',
                    name: 'sales_person'
                },
                {
                    data: 'notes',
                    name: 'notes'
                }
            ],
            rowCallback: function(row, data) {
                $(row).on('click', function() {
                    const id = data.opportunity_id;
                    $('#searchListVisitModel').modal('show');
                    $('#opportunity_id').val(id);
                    // Ensure any existing instance of the table is destroyed
                    if ($.fn.DataTable.isDataTable('#visitListDataTable')) {
                        $('#visitListDataTable').DataTable().clear().destroy();
                    }
                    // Reinitialize the table with the new ID
                    initializeVisitListTable(id);
                });
            }
        });

        function initializeVisitListTable(id) {
            $('#visitListDataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('visit.lists.list_all', ':id') }}".replace(':id', id),
                    data: function(d) {
                        // Add any additional data if needed
                    }
                },
                columns: [{
                        data: 'date_time',
                        name: 'date_time'
                    },
                    {
                        data: 'visit',
                        name: 'visit'
                    },
                    {
                        data: 'visit_label',
                        name: 'visit_label'
                    },
                    {
                        data: 'helped_at',
                        name: 'helped_at'
                    },
                    {
                        data: 'help_cust',
                        name: 'help_cust'
                    },
                    {
                        data: 'checkout',
                        name: 'checkout'
                    },
                    {
                        data: 'printed_notes',
                        name: 'printed_notes'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                rowCallback: function(row, data) {
                    $(document).on('click', '#checkout', function() {
                        var dataId = $(this).data('id');
                        handleCheckout(dataId);
                    });
                }
            });
        }


        $('#opportunityForm input, #opportunityForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var activeDeliveryMethod = $('#pills-tab .nav-link.active').val();
            var url = $('#opportunity_id').val() ? "{{ route('opportunities.update', ':id') }}".replace(':id', $('#opportunity_id').val()) : "{{ route('opportunities.store') }}";
            var type = $('#opportunity_id').val() ? "PUT" : "POST";
            var data = $('#opportunity_id').val() ? $('#opportunityEditForm').serialize() + "&ship_to_type=" + activeDeliveryMethod : $('#opportunityForm').serialize() + "&ship_to_type=" + activeDeliveryMethod;
            var id = $('#opportunity_id').val();
            var redirect = id ?
                "{{ route('opportunities.show', ':id') }}".replace(':id', id) :
                "{{ route('opportunities.index') }}";
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#supplierForm').trigger("reset");
                        table_opportunity.draw();
                        showToast('success', response.msg);
                        window.location.href = redirect;
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $(document).on('click', '.checkout-button', function() {
            var id = $(this).data('id');
            handleCheckout(id);
        });

        function handleCheckout(id) {
            if (id) {
                $.ajax({
                    url: "{{ route('visits.checkout', ':id') }}".replace(':id', id),
                    type: 'PATCH',
                    data: {
                        checkout: 1,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            $('#checkout').hide();
                            let table = $('#visitListDataTable').DataTable();
                            let row = table.row($('button[data-id="' + id + '"]').closest('tr'));
                            row.data({
                                ...row.data(),
                                checkout: `<div style="font-size:8pt;">
                                       <span>${response.updated_time}</span><br>
                                       <span>${response.time_difference} help</span><br>
                                   </div>`
                            }).draw(false);
                        } else {
                            alert('Failed to update checkout: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating checkout.');
                    }
                });
            }
        }
    });
</script>