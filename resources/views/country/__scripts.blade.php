<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#countryNameFilter, #countryCodeFilter, #leadTimeFilter').on('keyup change', function(e) {
                e.preventDefault();
                table.draw();
            });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('countries.list') }}",
                data: function (d) {
                    d.country_name_search = $('#countryNameFilter').val();
                    d.country_code_search = $('#countryCodeFilter').val();
                    d.lead_time_search = $('#leadTimeFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'country_name', name: 'country_name' },
                { data: 'country_code', name: 'country_code' },
                { data: 'lead_time', name: 'lead_time' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
            ,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Country</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#countryModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Country");
                    $(".country_name_error").html("");
                    $('#country_id').val('');
                    $('#countryForm').trigger("reset");
                    $('#countryForm').trigger("reset");
                    $("#countryForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Country");
                    $('#countryModel').modal('show');
                }
            }],

        });

        $('#countryForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            var url = $('#country_id').val() ? "{{ route('countries.update', ':id') }}".replace(':id', $('#country_id').val()) : "{{ route('countries.store') }}";
            var type = $('#country_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#countryForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#countryForm').trigger("reset");
                        $('#countryModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Country Added Successfully!' : 'Country Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    var button = type === 'POST' ? 'Save Country' : 'Update Country';
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('countries.index') }}" +'/' + id +'/edit', function (data) {
                $(".country_name_error").html("");
                $('#modelHeading').html("Edit Country");
                $('#savedata').val("edit-country");
                $('#savedata').html("Update Country");
                $('#countryModel').modal('show');
                $('#country_id').val(data.id);
                $('#country_name').val(data.country_name);
                $('#country_code').val(data.country_code);
                $('#lead_time').val(data.lead_time);
            });
        });


        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCountry(id);
            });
        });

        function deleteCountry(id) {
            var url = "{{ route('countries.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        table.draw();
                        showSuccessMessage('Deleted!', 'Country Deleted Successfully!');
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
            $.get("{{ route('countries.index') }}" +'/' + id, function (data) {
                $('#modelHeading').html("Show Country");
                $('#savedata').val("show-country");
                $('#showCountrymodal').modal('show');
                $('#showCountryForm #country_name').val(data.country_name);
                $('#showCountryForm #country_code').val(data.country_code);
                $('#showCountryForm #lead_time').val(data.lead_time);
            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>
