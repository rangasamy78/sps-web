<script type="text/javascript">
    $(function() {
        let id = $('#pre_purchase_request_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#prePurchaseRequestEvent').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('pre_purchase_request_events.list') }}",
                data: function(d) {
                    d.id = id;
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: null,
                    name: 'serial',
                    orderable: false,
                    searchable: false
                }, // Row index column
                {
                    data: 'entered_by_id',
                    name: 'entered_by_id'
                },
                {
                    data: 'assigned_to_id',
                    name: 'assigned_to_id'
                },
                {
                    data: 'description',
                    name: 'description'
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
                    data: 'price',
                    name: 'price',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Event</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#prePurchaseRequestEventModel',
                    'id': 'createEvent',
                },
                action: function(e, dt, node, config) {
                    $('#saveEventData').html("Save Event");
                    $('#pre_purchase_request_event_id').val('');
                    $('#prePurchaseRequestEventModelForm').trigger("reset");
                    $('.event_type_id_error,.assigned_to_id_error,.title_error,.product_id_error,.price_error').html('');
                    $('#prePurchaseRequestEventModel #modelHeading').html("Create New Event");
                    $('#prePurchaseRequestEventModel').modal('show');
                }
            }],
        });

        $('#saveEventData').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#pre_purchase_request_event_id').val() ? "{{ route('pre_purchase_request_events.update', ':id') }}".replace(':id', $('#pre_purchase_request_event_id').val()) : "{{ route('pre_purchase_request_events.store') }}";
            var type = $('#pre_purchase_request_event_id').val() ? "PUT" : "POST";
            var formData = $('#prePurchaseRequestEventModelForm').serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#prePurchaseRequestEventModelForm').trigger("reset");
                        $('#prePurchaseRequestEventModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('body').on('click', '.editEventbtn', function() {
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('pre_purchase_request_events.index') }}" + '/' + id + '/edit', function(data) {
                $('#prePurchaseRequestEventModel #modelHeading').html("Edit Event");
                $('#saveEventData').val("edit-event");
                $('#saveEventData').html("Update Event");
                $('#prePurchaseRequestEventModel').modal('show');
                $('#pre_purchase_request_event_id').val(data.id);
                $('#event_type_id').val(data.event_type_id).trigger('change');
                $('#schedule_date').val(data.schedule_date);
                $('#schedule_time').val(data.schedule_time);
                $('#assigned_to_id').val(data.assigned_to_id).trigger('change');
                var followerIds = data.follower_id ? data.follower_id.split('~') : [];
                $('#follower_id').val(followerIds).trigger('change');
                $('#event_title').val(data.event_title);
                $('#prePurchaseRequestEventModelForm #product_id').val(data.product_id).trigger('change');
                $('#price').val(data.price);
                $('#prePurchaseRequestEventModelForm #description').val(data.description);
            });
        });

        function resetForm() {
            $(".event_id_error").html("");
            $(".qty_error").html("");
        }

        $('body').on('click', '.deleteEventbtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteEvent(id);
            });
        });

        function deleteEvent(id) {
            var url = "{{ route('pre_purchase_request_events.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, table);
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }


    });
</script>
