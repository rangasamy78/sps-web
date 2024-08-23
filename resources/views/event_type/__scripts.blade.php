<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('event_types.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'event_type_name', name: 'event_type_name' },
                { data: 'event_type_code', name: 'event_type_code' },
                { data: 'event_category_id', name: 'event_category_id' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createEventType').click(function () {
            $('#savedata').val("create-event-type");
            $('#savedata').html("Save Event Type");
            $('#event_type_id').val('');
            $('#eventTypeForm').trigger("reset");
            $('.event_type_name_error').html('');
            $('#modelHeading').html("Create New Event Type");
            $('#eventTypeModel').modal('show');
        });

        $('#eventTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#event_type_id').val() ? "{{ route('event_types.update', ':id') }}".replace(':id', $('#event_type_id').val()) : "{{ route('event_types.store') }}";
            var type = $('#event_type_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#eventTypeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#eventTypeForm').trigger("reset");
                        $('#eventTypeModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Event Type Added Successfully!' : 'Event Type Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('event_types.index') }}" +'/' + id +'/edit', function (data) {
                $(".event_type_name_error").html("");
                $('#modelHeading').html("Edit Event Type");
                $('#savedata').val("edit-event-type");
                $('#savedata').html("Update Event Type");
                $('#eventTypeModel').modal('show');
                $('#event_type_id').val(data.id);
                $('#event_type_name').val(data.event_type_name);
                $('#event_type_code').val(data.event_type_code);
                $('#event_category_id').val(data.event_category_id);
            });
        });


        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteEventType(id);
            });
        });

        function deleteEventType(id) {
            var url = "{{ route('event_types.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Event Type Deleted Successfully!');
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

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('event_types.index') }}" +'/' + id, function (data) {
                $('#modelHeading').html("Show Event Type");
                $('#savedata').val("show-event-type");
                $('#showEventTypeModal').modal('show');
                $('#showEventTypeForm #event_type_name').val(data.model.event_type_name);
                $('#showEventTypeForm #event_type_code').val(data.model.event_type_code);
                $('#showEventTypeForm #event_category_id').val(data.model.event_category_id);
            });
        });

    });
</script>
