<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productFinishCodeFilter, #finishFilter').on('keyup change', function(e) {
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
                url: "{{ route('product_finishes.list') }}",
                data: function(d) {
                    d.product_finish_code_search = $('#productFinishCodeFilter').val();
                    d.finish_search = $('#finishFilter').val();
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
                    data: 'product_finish_code',
                    name: 'product_finish_code'
                },
                {
                    data: 'finish',
                    name: 'finish'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Product Finish</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#productFinishModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Product Finish");
                    resetForm();
                    $('#product_finish_id').val('');
                    $('#productFinishForm').trigger("reset");
                    $("#productFinishForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Product Finish");
                    $('#productFinishModel').modal('show');
                }
            }],

        });
        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#product_finish_id').val() ? "{{ route('product_finishes.update', ':id') }}".replace(':id', $('#product_finish_id').val()) : "{{ route('product_finishes.store') }}";
            var type = $('#product_finish_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productFinishForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#productFinishForm').trigger("reset");
                        $('#productFinishModel').modal('hide');
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

        $('#productFinishForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })

        $('body').on('click', '.editbtn', function() {
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('product_finishes.index') }}" + '/' + id + '/edit', function(data) {
                $(".product_finish_code_error").html("");
                $('#modelHeading').html("Edit Product Finish");
                $('#savedata').val("edit-product-finish");
                $('#savedata').html("Update Product Finish");
                $('#productFinishModel').modal('show');
                $('#product_finish_id').val(data.id);
                $('#product_finish_code').val(data.product_finish_code);
                $('#finish').val(data.finish);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteProductFinish(id);
            });
        });

        function deleteProductFinish(id) {
            var url = "{{ route('product_finishes.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('product_finishes.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Product Finish");
                $('#savedata').val("edit-product-finish");
                $('#showProductFinishModal').modal('show');
                $('#showProductFinishForm #product_finish_code').val(data.product_finish_code);
                $('#showProductFinishForm #finish').val(data.finish);
            });
        });
    });

    function resetForm() {
        $('.product_finish_code_error').html('');
        $('.finish_error').html('');
    }
</script>
