<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productColorFilter').on('keyup change', function(e) {
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
                url: "{{ route('product_colors.list') }}",
                data: function (d) {
                    d.product_color_search = $('#productColorFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'product_color', name: 'product_color' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [
                {
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Product Price Range</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#productPriceRangeModel',
                        'id': 'createBin',
                    },
                    action: function(e, dt, node, config) {

                        $('#savedata').html("Save Product Color");
                        $('#product_color_id').val('');
                        $('#productColorForm').trigger("reset");
                        $('.product_color_error').html('');
                        $('#modelHeading').html("Create New Product Color");
                        $('#productColorModel').modal('show');
                    }
                }
            ],
        });

        $('#productColorForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
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
                    sending(button,true);
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
     });
</script>
