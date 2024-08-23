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
                url: "{{ route('product_price_ranges.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'product_price_range', name: 'product_price_range' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createProductPriceRange').click(function () {
            $('.product_price_range_error').html('');
            $('#savedata').html("Save Product Price Range");
            $('#product_price_range_id').val('');
            $('#productPriceRangeForm').trigger("reset");
            $('#modelHeading').html("Create New Product Price Range");
            $('#productPriceRangeModel').modal('show');
        });
        $('#productPriceRangeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#product_price_range_id').val() ? "{{ route('product_price_ranges.update', ':id') }}".replace(':id', $('#product_price_range_id').val()) : "{{ route('product_price_ranges.store') }}";
            var type = $('#product_price_range_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productPriceRangeForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#productPriceRangeForm').trigger("reset");
                        $('#productPriceRangeModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Product Price Range Added Successfully!' : 'Product Price Range Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });
        $('body').on('click', '.editbtn', function () {
            $('.product_price_range_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('product_price_ranges.index') }}" + '/' + id + '/edit', function (data) {
                $(".product_price_range_code_error").html("");
                $('#modelHeading').html("Edit Product Price Range");
                $('#savedata').val("edit-product-price-range");
                $('#savedata').html("Update Product Price Range");
                $('#productPriceRangeModel').modal('show');
                $('#product_price_range_id').val(data.id);
                $('#product_price_range').val(data.product_price_range);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteProductPriceRange(id);
            });
        });
        function deleteProductPriceRange(id) {
            var url = "{{ route('product_price_ranges.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Product Price Range Deleted Successfully!');
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('product_price_ranges.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Product Price Range");
                $('#savedata').val("edit-product-price-range");
                $('#showProductPriceRangeModal').modal('show');
                $('#showProductPriceRangeForm #product_price_range').val(data.product_price_range);

            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
