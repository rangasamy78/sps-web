<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#countyNameFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('counties.list') }}",
                data: function(d) {
                    d.county_name_search = $('#countyNameFilter').val();
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
                },
                {
                    data: 'county_name',
                    name: 'county_name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add County</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#countyModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save County");
                    $(".county_name_error").html("");
                    $('#county_id').val('');
                    $('#countyForm').trigger("reset");
                    $('#countyForm').trigger("reset");
                    $("#countyForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New County");
                    $('#countyModel').modal('show');
                }
            }],

        });

        $('#countyForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#county_id').val() ? "{{ route('counties.update', ':id') }}".replace(':id', $('#county_id').val()) : "{{ route('counties.store') }}";
            var type = $('#county_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#countyForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#countyForm').trigger("reset");
                        $('#countyModel').modal('hide');
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

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('counties.index') }}" + '/' + id + '/edit', function(data) {
                $(".county_name_error").html("");
                $('#modelHeading').html("Edit County");
                $('#savedata').val("edit-county");
                $('#savedata').html("Update County");
                $('#countyModel').modal('show');
                $('#county_id').val(data.id);
                $('#county_name').val(data.county_name);
            });
        });


        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCounty(id);
            });
        });

        function deleteCounty(id) {
            var url = "{{ route('counties.destroy', ':id') }}".replace(':id', id);

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

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('counties.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show County");
                $('#savedata').val("show-county");
                $('#showCountymodal').modal('show');
                $('#showCountyForm #county_name').val(data.county_name);
            });
        });
    });
</script>
