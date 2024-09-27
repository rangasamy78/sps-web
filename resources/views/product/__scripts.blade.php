<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productNameFilter').on('keyup change', function(e) {
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
                url: "{{ route('products.list') }}",
                data: function(d) {
                    d.product_name_search = $('#productNameFilter').val();
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
                    data: 'product_name',
                    name: 'product_name'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Product</span>',
                className: 'create-new btn btn-primary',
                attr: {
                        id: 'createAssociate',
                    },
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('products.create') }}";
                    }
            }],
        });

        $('#productForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function(e) {
          
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#product_id').val() ? "{{ route('products.update', ':id') }}".replace(':id', $('#product_id').val()) : "{{ route('products.store') }}";
            var type = $('#product_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    alert(response)
                    if (response.status == "success") {
                        $('#productForm').trigger("reset");
                        $('#productModel').modal('hide');
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
            $('.product_name_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('products.index') }}" + '/' + id + '/edit', function(data) {
                $(".product_name_error").html("");
                $('#modelHeading').html("Edit Product");
                $('#savedata').html("Update Product");
                $('#productModel').modal('show');
                $('#product_id').val(data.id);
                $('#product_name').val(data.product_name);
            });
        });
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteProduct(id);
            });
        });

        function deleteProduct(id) {
            var url = "{{ route('products.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('products.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Product");
                $('#showProductModal').modal('show');
                $('#showProductForm #product_name').val(data.product_name);

            });
        });
    });
</script>
