<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#aboutUsOptionTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [
                [1, 'desc']
            ], // Order by the second column ('how_did_you_hear_option')
            ajax: {
                url: "{{ route('about_us_options.list') }}",
                data: function(d) {
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
                    data: 'how_did_you_hear_option',
                    name: 'how_did_you_hear_option'
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
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add How did you hear Option</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#aboutUsOptionModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    // Custom action for Add New Record button
                    $('#savedata').html("Save How did you hear Option");
                    $('#how_did_you_hear_option_id').val('');
                    $('#aboutUsOptionForm').trigger("reset");
                    $(".how_did_you_hear_option_error").html("");
                    $('#modelHeading').html("Create New How did you hear Option");
                    $('#aboutUsOptionModel').modal('show');
                }
            }],
        });

        $('#how_did_you_hear_option').on('input', function() {
            $('.how_did_you_hear_option_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#how_did_you_hear_option_id').val() ? "{{ route('about_us_options.update', ':id') }}".replace(':id', $('#how_did_you_hear_option_id').val()) : "{{ route('about_us_options.store') }}";
            var type = $('#how_did_you_hear_option_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#aboutUsOptionForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#aboutUsOptionForm').trigger("reset");
                        $('#aboutUsOptionModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'How did you hear Option Added Successfully!' : 'How did you hear Option Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $(".how_did_you_hear_option_error").html("");
            $.get("{{ route('about_us_options.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update How did you hear Option");
                $('#savedata').val("how-did-you-hear-option");
                $('#savedata').html("Update How did you hear Option");
                $('#aboutUsOptionModel').modal('show');
                $('#how_did_you_hear_option_id').val(data.id);
                $('#how_did_you_hear_option').val(data.how_did_you_hear_option);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteAboutUsOption(id);
            });
        });

        function deleteAboutUsOption(id) {
            var url = "{{ route('about_us_options.destroy', ':id') }}".replace(':id', id);
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
                        showSuccessMessage('Deleted!', 'How did you hear Option Deleted Successfully!');
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
        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('about_us_options.index') }}" + '/' + id, function(data) {
                $('#showAboutUsOptionModal').modal('show');
                $('#showAboutUsOptionForm #how_did_you_hear_option').val(data.how_did_you_hear_option);
            });
        });

    });
</script>