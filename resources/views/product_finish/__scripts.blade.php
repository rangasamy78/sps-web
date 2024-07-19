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
                url: "{{ route('product_finishes.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'product_finish_code', name: 'product_finish_code' },
                { data: 'finish', name: 'finish' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createProductFinish').click(function () {
            resetForm();
            $('#savedata').html("Save Product Finish");
            $('#product_finish_id').val('');
            $('#productFinishForm').trigger("reset");
            $('#modelHeading').html("Create New Product Finish");
            $('#productFinishModel').modal('show');
        });
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#product_finish_id').val() ? "{{ route('product_finishes.update', ':id') }}".replace(':id', $('#product_finish_id').val()) : "{{ route('product_finishes.store') }}";
            var type = $('#product_finish_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productFinishForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#productFinishForm').trigger("reset");
                        $('#productFinishModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Product Finish Added Successfully!' : 'Product Finish Updated Successfully!';
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

        $('#productFinishForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })

        $('body').on('click', '.editbtn', function () {
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('product_finishes.index') }}" + '/' + id + '/edit', function (data) {
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

        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
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
                success: function (response) {
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Product Finishes Deleted Successfully!');
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
            $.get("{{ route('product_finishes.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Product Finish");
                $('#savedata').val("edit-product-finish");
                $('#showProductFinishModal').modal('show');
                $('#showProductFinishForm #product_finish_code').val(data.product_finish_code);
                $('#showProductFinishForm #finish').val(data.finish);

            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

    function resetForm() {
        $('.product_finish_code_error').html('');
        $('.finish_error').html('');
    }
</script>