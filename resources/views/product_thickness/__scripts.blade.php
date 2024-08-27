<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productThicknessNameFilter, #productThicknessUnitFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('product_thicknesses.list') }}",
                data: function (d) {
                    d.product_thickness_name_search = $('#productThicknessNameFilter').val();
                    d.product_thickness_unit_search = $('#productThicknessUnitFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'product_thickness_name', name: 'product_thickness_name' },
                { data: 'product_thickness_unit', name: 'product_thickness_unit' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Product Thickness</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#productThicknessModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Product Thickness");
                    resetForm();
                    $('#productThicknessForm').trigger("reset");
                    $("#productThicknessForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Product Thickness");
                    $('#productThicknessModel').modal('show');
                }
            }],
        });

        $('#productThicknessForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#product_thickness_id').val() ? "{{ route('product_thicknesses.update', ':id') }}".replace(':id', $('#product_thickness_id').val()) : "{{ route('product_thicknesses.store') }}";
            var type = $('#product_thickness_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productThicknessForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#productThicknessForm').trigger("reset");
                        $('#productThicknessModel').modal('hide');
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
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('product_thicknesses.index') }}" + '/' + id + '/edit', function (data) {
                $('#modelHeading').html("Edit Product Thickness");
                $('#savedata').val("edit-product-thickness");
                $('#savedata').html("Update Product Thickness");
                $('#productThicknessModel').modal('show');
                $('#product_thickness_id').val(data.id);
                $('#product_thickness_name').val(data.product_thickness_name);
                $('#product_thickness_unit').val(data.product_thickness_unit);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteProductThickness(id);
            });
        });

        function deleteProductThickness(id) {
            var url = "{{ route('product_thicknesses.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('product_thicknesses.index') }}" +'/' + id, function (data) {
                $('#showProductThicknessModal').modal('show');
                $('#showProductThicknessForm #product_thickness_name').val(data.product_thickness_name);
                $('#showProductThicknessForm #product_thickness_unit').val(data.product_thickness_unit);
            });
        });

       function resetForm() {
        $('.product_thickness_name_error').html('');
        $('.product_thickness_unit_error').html('');
    }
    });
</script>
