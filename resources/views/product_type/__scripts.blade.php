<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#productTypeFilter, #inventoryGLAccountFilter,#salesGLAccountFilter, #cogsGLAccountFilter').on('keyup change', function(e) {
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
                url: "{{ route('product_types.list') }}",
                data: function (d) {
                    d.product_type_search = $('#productTypeFilter').val();
                    d.inventory_gl_account_search = $('#inventoryGLAccountFilter').val();
                    d.sales_gl_account_search = $('#salesGLAccountFilter').val();
                    d.cogs_gl_account_search = $('#cogsGLAccountFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'product_type', name: 'product_type' },
                { data: 'default_gl_accounts', name: 'default_gl_accounts' },
                { data: 'default_values', name: 'default_values' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Product Type</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#productTypeModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Product Type");
                    $('.product_type_error').html('');
                    $('#product_type_id').val('');
                    $('#productTypeForm').trigger("reset");
                    $("#productTypeForm").find("tr:gt(1)").remove();
                    $('#modelHeading').html("Create New Product Type");
                    $('#productTypeModel').modal('show');
                }
            }],
        });

        $('#productTypeForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#product_type_id').val() ? "{{ route('product_types.update', ':id') }}".replace(':id', $('#product_type_id').val()) : "{{ route('product_types.store') }}";
            var type = $('#product_type_id').val() ? "PUT" : "POST";
            var formData = $('#productTypeForm').serializeArray();
            formData.push({ name: 'indivisible', value: $('#indivisible').is(':checked') ? '1' : '0' });
            formData.push({ name: 'non_serialized', value: $('#non_serialized').is(':checked') ? '1' : '0' });
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === "success") {
                        $('#productTypeForm').trigger("reset");
                        $('#productTypeModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Product Type Added Successfully!' : 'Product Type Updated Successfully!';
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
            $('.product_type_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('product_types.index') }}" + '/' + id + '/edit', function (data) {
                $(".product_type_error").html("");
                $('#modelHeading').html("Edit Product Type");
                $('#savedata').val("edit-product-type");
                $('#savedata').html("Update Product Type");
                $('#productTypeModel').modal('show');
                $('#product_type_id').val(data.id);
                $('#product_type').val(data.product_type);
                $('#inventory_gl_account').val(data.inventory_gl_account);
                $('#sales_gl_account').val(data.sales_gl_account);
                $('#cogs_gl_account').val(data.cogs_gl_account);
                if (data.indivisible == 1) {
                    $('#indivisible').prop('checked', true);
                } else {
                    $('#indivisible').prop('checked', false);
                }

                if (data.non_serialized == 1) {
                    $('#non_serialized').prop('checked', true);
                } else {
                    $('#non_serialized').prop('checked', false);
                }

            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteProductType(id);
            });
        });
        function deleteProductType(id) {
            var url = "{{ route('product_types.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === "success") {
                        table.draw();
                        showSuccessMessage('Deleted!', 'Product Type Deleted Successfully!');
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
            $.get("{{ route('product_types.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Product Type");
                $('#savedata').val("edit-product-type");
                $('#showProductTypeModal').modal('show');
                $('#showProductTypeForm #product_type').val(data.product_type);
                $('#inventory_gl_accounts').val(data.inventory_gl_account);
                $('#sales_gl_accounts').val(data.sales_gl_account);
                $('#cogs_gl_accounts').val(data.cogs_gl_account);
                if (data.indivisible == 1) {
                    $('#indivisibles').prop('checked', true);
                } else {
                    $('#indivisibles').prop('checked', false);
                }

                if (data.non_serialized == 1) {
                    $('#non_serializeds').prop('checked', true);
                } else {
                    $('#non_serializeds').prop('checked', false);
                }

            });
        });
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });


function savedefaultValuesChange(checkbox, id, type) {
    const isChecked = checkbox.checked;
    const url ="{{ route('product_types.save_default_value') }}" ;
    const data = {
        id: id,
        type: type,
        checked: isChecked ? 1 : 0
    };
    $.ajax({
        url: url,
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token if needed
        },
        success: function(response) {
            console.log(response);

        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr.responseText);
        }
    });
}
</script>
