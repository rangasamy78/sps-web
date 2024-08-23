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
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('product_thicknesses.list') }}",
                data: function (d) {
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
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            
        });
        

        $('#productThicknessForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })

        $('#createProductThickness').click(function () {
            resetForm();
            $('#savedata').val("create-product-thickness");
            $('#savedata').html("Save Product Thickness");
            $('#product_thickness_id').val('');
            $('#productThicknessForm').trigger("reset");
            $('#modelHeading').html("Create New Product Thickness");
            $('#productThicknessModel').modal('show');
        });


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
                        table.draw();
                        var successMessage = type === 'POST' ? 'Product Thickness Added Successfully!' : 'Product Thickness Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
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
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Product Thickness Deleted Successfully!');
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
