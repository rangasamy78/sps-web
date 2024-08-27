<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productPriceRangeFilter').on('keyup change', function(e) {
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
                url: "{{ route('product_price_ranges.list') }}",
                data: function (d) {
                    d.product_price_range_search = $('#productPriceRangeFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data:null, name: 'serial', orderable: false, searchable: false },
                { data: 'product_price_range', name: 'product_price_range' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
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

                        $('#savedata').html("Save Product Price Range");
                        $('#product_price_range_id').val('');
                        $('#productPriceRangeForm').trigger("reset");
                        $('.product_price_range_error').html('');
                        $('#modelHeading').html("Create New Product Price Range");
                        $('#productPriceRangeModel').modal('show');
                    }
                }
            ],
        });
       
        $('#productPriceRangeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
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
                        handleAjaxResponse(response, table);
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
    });
</script>
