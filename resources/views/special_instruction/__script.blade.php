<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#specialInstructionFilter').on('keyup change', function(e) {
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
                url: "{{ route('special_instructions.list') }}",
                data: function(d) {
                    d.special_instruction = $('#specialInstructionFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                }, {
                    data: 'special_instruction_name',
                    name: 'special_instruction_name'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Special Instruction</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#specialInstructionModel',
                    'id': 'createspecialInstructionModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Special Instruction");
                    $('#special_instruction_id').val('');
                    $('#specialInstructionForm').trigger("reset");
                    $('.special_instruction_name_error').html('');
                    $('#modelHeading').html("Create New Special Instruction");
                    $('#specialInstructionModel').modal('show');
                }
            }],
        });

        $('#specialInstructionForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#special_instruction_id').val() ?
                "{{ route('special_instructions.update', ':id') }}".replace(':id', $(
                    '#special_instruction_id').val()) : "{{ route('special_instructions.store') }}";
            var type = $('#special_instruction_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#specialInstructionForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#specialInstructionForm').trigger("reset");
                        $('#specialInstructionModel').modal('hide');
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
            $.get("{{ route('special_instructions.index') }}" + '/' + id + '/edit', function(data) {
                $('.special_instruction_name_error').html('');
                $('#modelHeading').html("Update Special Instruction");
                $('#savedata').html("Update Special Instruction");
                $('#specialInstructionModel').modal('show');
                $('#special_instruction_id').val(data.id);
                $('#special_instruction_name').val(data.special_instruction_name);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteproductKind(id);
            });
        });

        function deleteproductKind(id) {
            var url = "{{ route('special_instructions.destroy', ':id') }}".replace(':id', id);
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

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('special_instructions.index') }}" + '/' + id, function(data) {
                $('#showSpecialInstructionModel').modal('show');
                $('#showSpecialInstructionForm #special_instruction_name').val(data.special_instruction_name);
            });
        });
    });
</script>
