<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productGroupNameFilter, #productGroupCodeFilter').on('keyup change', function(e) {
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
                url: "{{ route('product_groups.list') }}",
                data: function(d) {
                    d.product_group_name_search = $('#productGroupNameFilter').val();
                    d.product_group_code_search = $('#productGroupCodeFilter').val();
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
                    data: 'product_group_name',
                    name: 'product_group_name'
                },
                {
                    data: 'product_group_code',
                    name: 'product_group_code'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Product Group</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#productGroupModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Product Group");
                    $('.product_group_name_error').html('');
                    $('#product_group_id').val('');
                    $('#productGroupForm').trigger("reset");
                    $("#productGroupForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Product Group");
                    $('#productGroupModel').modal('show');
                }
            }],
        });

        $('#productGroupForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#product_group_id').val() ? "{{ route('product_groups.update', ':id') }}".replace(':id', $('#product_group_id').val()) : "{{ route('product_groups.store') }}";
            var type = $('#product_group_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productGroupForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#productGroupForm').trigger("reset");
                        $('#productGroupModel').modal('hide');
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
            $('.product_group_name_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('product_groups.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Edit Product Group");
                $('#savedata').val("edit-product-group");
                $('#savedata').html("Update Product Group");
                $('#productGroupModel').modal('show');
                $('#product_group_id').val(data.id);
                $('#product_group_name').val(data.product_group_name);
                $('#product_group_code').val(data.product_group_code);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteProductGroup(id);
            });
        });

        function deleteProductGroup(id) {
            var url = "{{ route('product_groups.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('product_groups.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Product Group");
                $('#savedata').val("edit-product-group");
                $('#showProductGroupModal').modal('show');
                $('#showProductGroupForm #product_group_name').val(data.product_group_name);
                $('#showProductGroupForm #product_group_code').val(data.product_group_code);
            });
        });
    });
</script>
