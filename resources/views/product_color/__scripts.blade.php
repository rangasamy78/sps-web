<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('product_colors.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'product_color', name: 'product_color' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createProductColor').click(function () {
            $('.product_color_error').html('');
            $('#savedata').html("Save Product Color");
            $('#product_color_id').val('');
            $('#productColorForm').trigger("reset");
            $('#modelHeading').html("Create New Product Color");
            $('#productColorModel').modal('show');
        });
        $('#productColorForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#product_color_id').val() ? "{{ route('product_colors.update', ':id') }}".replace(':id', $('#product_color_id').val()) : "{{ route('product_colors.store') }}";
            var type = $('#product_color_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productColorForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#productColorForm').trigger("reset");
                        $('#productColorModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });
        $('body').on('click', '.editbtn', function () {
            $('.product_color_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('product_colors.index') }}" + '/' + id + '/edit', function (data) {
                $(".product_color_code_error").html("");
                $('#modelHeading').html("Edit Product Color");
                $('#savedata').val("edit-product-color");
                $('#savedata').html("Update Product Color");
                $('#productColorModel').modal('show');
                $('#product_color_id').val(data.id);
                $('#product_color').val(data.product_color);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteProductColor(id);
            });
        });
        function deleteProductColor(id) {
            var url = "{{ route('product_colors.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    handleAjaxResponse(response, table);
                },
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('product_colors.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Product Color");
                $('#savedata').val("edit-product-color");
                $('#showProductColorModal').modal('show');
                $('#showProductColorForm #product_color').val(data.product_color);

            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
