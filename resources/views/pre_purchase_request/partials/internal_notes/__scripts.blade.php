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
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('project_types.list') }}",
                data: function(d) {
                    d.project_type_search = $('#projectTypeFilter').val();
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
                    data: 'project_type_name',
                    name: 'project_type_name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Project Type</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#projectTypeModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {

                    $('#savedata').html("Save Project Type");
                    $('#project_type_id').val('');
                    $('#projectTypeForm').trigger("reset");
                    $('.project_type_name_error').html('');
                    $('#modelHeading').html("Create New Project Type");
                    $('#projectTypeModel').modal('show');
                }
            }],
        });

        $('#internal_save_data').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = "{{ route('internal_notes.store') }}";
            var type = "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#internalNoteForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                    }
                    $("#internal_notes").val('');
                    displayData();
                    sending(button, true);
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        function displayData(){
            var displayUrl = "{{ route('internal_notes.list') }}";
            var id = $("#internalNoteForm #pre_purchase_request_id").val();
            $.ajax({
                type: 'GET',
                url: displayUrl,
                data: {id: id},
                success: function(data){
                    $('#internalData').html(data.data)
                }
            });
        }
        displayData();

        $('#internalNoteForm textarea').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
    });
</script>
