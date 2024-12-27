<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#enteredByAssignedToFilter, #eventTitleFilter, #dateFilter, #timeFilter, #productFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });
        var table = $('#dataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('my_events.list') }}",
                data: function(d) {
                    d.date_search                   = $('#dateFilter').val();
                    d.time_search                   = $('#timeFilter').val();
                    d.product_search                = $('#productFilter').val();
                    d.event_title_search            = $('#eventTitleFilter').val();
                    d.toggleBtnVal                  = $('button[name="my_event"].btn-primary').val();
                    d.status_filter                 = $('input[name="statusFilter"]:checked').val();
                    d.enteredby_assignedto_search   = $('#enteredByAssignedToFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }]; // Order by the correct column index
                }
            },
            columns: [{
                    data: null,
                    name: 'serial',
                    orderable: false,
                    searchable: false
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
                    data: 'event_title',
                    name: 'event_title'
                },
                {
                    data: 'product_type_id',
                    name: 'product_type_id'
                },
                {
                    data: 'schedule_date',
                    name: 'schedule_date'
                },
                {
                    data: 'party_name',
                    name: 'party_name'
                },
                {
                    data: 'product_id',
                    name: 'product_id'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Add the serial number in the first column
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: ' <span class="d-none d-sm-inline-block ">All Events</span>',
                    className: 'btn btn-secondary me-2 btn-primary',
                    attr: {
                        id: 'all_event',
                    },
                    action: function(e, dt, node, config) {
                    }
                },
                {
                    text: ' <span class="d-none d-sm-inline-block">My Events</span>',
                    className: 'btn btn-secondary me-2',
                    attr: {
                        id: 'my_event',
                        name: 'my_event',
                        value: @json(auth()->user()->id),
                    },
                    action: function(e, dt, node, config) {
                    }
                },
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Event</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'id': 'createEvent',
                    },
                        action: function(e, dt, node, config) {
                            window.location.href = "{{ route('my_events.create') }}";
                        }
                }
            ]
        });

        $('#statusFilterContainer').html(`
            <div class="btn-group">
                <label>
                    <input type="radio" name="statusFilter" value="2"> All
                </label>
                <label>
                    <input type="radio" name="statusFilter" value="0" checked> InComplete
                </label>
                <label>
                    <input type="radio" name="statusFilter" value="1"> Completed
                </label>
            </div>
        `);

        function reloadTableWithFilter() {
            // If using ajax-based table reload, use this:
            table.ajax.reload(); // Or implement your custom filter logic here
        }

        // Trigger reload on page load based on the current selection
        reloadTableWithFilter();
        // Event listener for radio button changes
        $('input[name="statusFilter"]').on('change', function() {
            reloadTableWithFilter(); // Reload the table with the new status filter
        });

        $('#eventForm').on('input', 'input, #event_type_id, #assigned_to_id', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#event_id').val() ? "{{ route('my_events.update', ':id') }}".replace(':id', $('#event_id').val()) : "{{ route('my_events.store') }}";
            var type = $('#event_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#eventForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#eventForm').trigger("reset");
                        window.location.href = "{{ route('my_events.index') }}";
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('#event_type_id').select2({
            placeholder: 'Select Event Type',
            dropdownParent: $('#event_type_id').parent()
        });
        $('#assigned_to_id').select2({
            placeholder: 'Select Assigned TO',
            dropdownParent: $('#assigned_to_id').parent()
        });
        $('#follower_id').select2({
            placeholder: 'Select Follwers(CC)',
            dropdownParent: $('#follower_id').parent()
        });
        $('#party_name').select2({
            placeholder: 'Select Party',
            dropdownParent: $('#party_name').parent()
        });
        $('#product_id').select2({
            placeholder: 'Select Products',
            dropdownParent: $('#product_id').parent()
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteMyEvent(id);
            });
        });

        function deleteMyEvent(id) {
            var url = "{{ route('my_events.destroy', ':id') }}".replace(':id', id);
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

        $(document).on('click', '#my_event', function() {
            var id = $(this).data('id');
            document.getElementById('my_event').classList.add('btn-primary');
            document.getElementById('all_event').classList.remove('btn-primary');
            table.draw();
        });

        $(document).on('click', '#all_event', function() {
            location.reload();
        });

        $(document).on('click', '.completebtn', function() {
            var id = $(this).data('id');
            var button = $(this);
            var url = "{{ route('my_events.set_as_complete', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = "{{ route('my_event.show', ':id') }}".replace(':id', id);
                        showToast('success', response.msg);
                    }
                }
            });
        });
            var pathname = window.location.pathname;
            var dateMatch = pathname.match(/\/(\d{4}-\d{2}-\d{2})$/);

            if (dateMatch) {
                var scheduleDateInput = document.getElementById('schedule_date');
                scheduleDateInput.value = dateMatch[1];  
            }

    });
</script>
