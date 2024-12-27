<script type="text/javascript">
    $(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_sales_order_event = $('#saleOrderCrmEvent').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('events.list', ':id') }}".replace(':id', $('#sales_order_id').val()),
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
                    data: 'entered_by_id',
                    name: 'entered_by_id'
                },
                {
                    data: 'assigned_to_id',
                    name: 'assigned_to_id'
                },
                {
                    data: 'title_description',
                    name: 'title_description'
                },
                {
                    data: 'event_type_id',
                    name: 'event_type_id'
                },
                {
                    data: 'time_date',
                    name: 'time_date'
                },
                {
                    data: 'product_name_price',
                    name: 'product_name_price',
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).addClass('row-' + data.id);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Event</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'offcanvas',
                    'data-bs-target': '#crmEvent',
                    'aria-controls': 'crmEvent',
                },
                action: function(e, dt, node, config) {
                    // Custom action here
                }
            }],
        });

        // Save Event button functionality
        $('#saveEvent').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var data = $('#addCrmEventForm').serialize();
            $.ajax({
                url: '{{ route("events.store") }}',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    // alert(response.msg);
                    if (response.status == "success") {
                        $('#addCrmEventForm').trigger("reset");
                        sending(button, true);
                        $('#crmEvent').offcanvas('hide');
                        table_sales_order_event.draw();
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $(document).on("change", ".event_check", function() {
            var id = $(this).data('id'); // Get the ID of the checkbox that triggered the event

            var data = {
                mark_as_complete: $(this).is(":checked") ? 1 : 0 // Send 1 if checked, otherwise 0
            };

            $.ajax({
                url: '{{ route("events.update", ":id") }}'.replace(':id', id), // Replace ":id" with the actual id
                type: 'PUT',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        // Optionally reset the form and refresh the data table if needed
                        table_sales_order_event.draw();
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        });


        // Initialize DataTable for productListTable with search filters
        $(' #productNameFilter,#codeFilter').on('keyup change', function(e) {
            e.preventDefault();
            table_product_list.draw();
        });

        var table_product_list = $('#productListTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('events.product_list') }}",
                data: function(d) {
                    d.productName = $('#productNameFilter').val();
                    d.productCode = $('#codeFilter').val();
                }
            },
            columns: [{
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'product_sku',
                    name: 'product_sku'
                },
                {
                    data: 'type',
                    name: 'type'
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).css('cursor', 'pointer');
                $(row).on('click', function() {
                    $('#product_id').val(data.id);
                    $('#product_name').val(data.product_name);
                    $('#searchProduct').modal('hide');
                });
            }
        });

        // Function to update date and time
        const updateDateTime = () => {
            const now = new Date();
            const date = now.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
            const time = now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            });
            document.getElementById('currentDateTime').textContent = `${date}, ${time}`;
        };

        setInterval(updateDateTime, 1000);
        updateDateTime();


    });
</script>
