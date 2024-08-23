<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#selectTypeCategoryNameFilter, #selectTypeSubCategoryNameFilter').on('keyup change', function(e) {
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
                url: "{{ route('select_type_sub_categories.list') }}",
                data: function (d) {
                    d.select_type_category_name_search = $('#selectTypeCategoryNameFilter').val();
                    d.select_type_sub_category_search = $('#selectTypeSubCategoryNameFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'select_type_category_names', name: 'select_type_category' },
                { data: 'select_type_sub_categories', name: 'select_type_sub_category' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            }
        });

        $('#createSelectTypeSubCategory').click(function () {
            $('#select_type_sub_category_form').trigger("reset");
            $('.select_type_category_id_error').html('');
            $('#select_type_category_id').val('').prop('disabled', false);
            $('#savedata').html("Save Select Type Sub Category");
            $('#select_type_sub_category_id').val('');
            $('#selectTypeSubCategoryForm').trigger("reset");
            $('#modelHeading').html("Create New Select Type Sub Category");
            $('#selectTypeSubCategoryModel').modal('show');
            $('#subcategory-container').html('');
            var blankSubcategoryRow = `
                <div class="row subcategory-row">
                    <div class="col-sm-4">
                        <label class="" for="select_type">Select Type Sub Category Name</label>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" name="select_type_sub_categories[][select_type_sub_category_name]" class="form-control" placeholder="Enter Select Type Sub Category Name" aria-label="Subcategory" />
                        <span class="error-message" style="color: #ff3e1d; display: none;">Duplicate subcategory name found.</span>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary add-subcategory-btn" style="width: 30px; height: 30px;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>`;
            $('#subcategory-container').append(blankSubcategoryRow);
        });

        $(document).on('click', '.add-subcategory-btn', function () {
            var subcategoryRows = $('#subcategory-container .subcategory-row').length;
            if (subcategoryRows < 10) {
                var newSubcategoryRow = `
                    <div class="row subcategory-row mt-2">
                        <div class="col-sm-4">
                            <label class="" for="select_type">Select Type Sub Category Name</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" name="select_type_sub_categories[][select_type_sub_category_name]" class="form-control" placeholder="Enter Select Type Sub Category Name" aria-label="Category Name" />
                            <span class="error-message" style="color: #ff3e1d; display: none;">Duplicate subcategory name found.</span>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-danger remove-subcategory-btn" style="width: 30px; height: 30px;">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#subcategory-container').append(newSubcategoryRow);
            } else {
                alert('You can only add up to 10 subcategory rows.');
            }
        });

        $('#selectTypeSubCategoryForm select').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#select_type_sub_category_id').val() ? "{{ route('select_type_sub_categories.update', ':id') }}".replace(':id', $('#select_type_sub_category_id').val()) : "{{ route('select_type_sub_categories.store') }}";
            var type = $('#select_type_sub_category_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#selectTypeSubCategoryForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#selectTypeSubCategoryForm').trigger("reset");
                        $('#selectTypeSubCategoryModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Select Type Sub Category Added Successfully!' : 'Select Type Sub Category Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('.error-message').hide().html('');
                    $('.select_type_category_id_error').html('');
                    if (errors['select_type_category_id']) {
                        $('.select_type_category_id_error').html(errors['select_type_category_id'][0]).show();
                    }
                    if (errors['select_type_sub_categories.0.select_type_sub_category_name']) {
                        $('#subcategory-container .subcategory-row:first-child .error-message').html(errors['select_type_sub_categories.0.select_type_sub_category_name'][0]).show();
                    }
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('select_type_sub_categories.index') }}" + '/' + id + '/edit', function (data) {
                $(".select_type_category_id_error").html("");
                $('#modelHeading').html("Edit Select Type Sub Category");
                $('#savedata').val("edit-select-type-sub-category");
                $('#savedata').html("Update Select Type Sub Category");
                $('#selectTypeSubCategoryModel').modal('show');
                $('#select_type_sub_category_id').val(data.id);
                $('#select_type_category_id').val(data.id);
                $('#select_type_category_id').val(data.id).prop('disabled', true);
                $('#subcategory-container').html('');
                var blankSubcategoryRow = `
                    <div class="row subcategory-row">
                        <div class="col-sm-4">
                            <label for="select_type">Select Type Sub Category Name</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" name="select_type_sub_categories[][select_type_sub_category_name]" class="form-control"
                                placeholder="Enter  Select Type Sub Category" aria-label="Subcategory" />
                            <span class="error-message" style="color: #ff3e1d; display: none;">Duplicate subcategory name found.</span>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary add-subcategory-btn"
                                style="width: 30px; height: 30px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>`;
                if (data.select_type_sub_category.length === 0) {
                    $('#subcategory-container').append(blankSubcategoryRow);
                } else {
                    data.select_type_sub_category.forEach(function (subcategory, index) {
                        var buttonHtml = '';

                        if (index === 0) {
                            buttonHtml = `
                        <button type="button" class="btn btn-primary add-subcategory-btn" style="width: 30px; height: 30px;">
                            <i class="fas fa-plus"></i>
                        </button>`;
                        } else {
                            buttonHtml = `
                        <button type="button" class="btn btn-danger remove-subcategory-btn" style="width: 30px; height: 30px;">
                            <i class="fas fa-minus"></i>
                        </button>`;
                        }

                        var subcategoryRow = `
                            <div class="row subcategory-row">
                                <div class="col-sm-4">
                                    <label for="select_type">Select Type Sub Category Name</label>
                                </div><br><br>
                                <div class="col-sm-7">
                                    <input type="text" name="select_type_sub_categories[][select_type_sub_category_name]" class="form-control"
                                        placeholder="Enter  Select Type Sub Category Name" aria-label="Subcategory" value="${subcategory.select_type_sub_category_name ? subcategory.select_type_sub_category_name : ''}" />
                                    <span class="error-message" style="color: #ff3e1d; display: none;">Duplicate subcategory name found.</span>
                                </div>
                                <div class="col-sm-1">
                                    ${buttonHtml}
                                </div>
                            </div>`;
                    $('#subcategory-container').append(subcategoryRow);
                    });
                }
            });
        });

        $('#subcategory-container').on('input', 'input[name="select_type_sub_categories[][select_type_sub_category_name]"]', function () {
            $(this).siblings('.error-message').hide();
        });

        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteSelectTypeSubCategory(id);
            });
        });

        function deleteSelectTypeSubCategory(id) {
            var url = "{{ route('select_type_sub_categories.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log(response);
                    if (response.status == "success") {
                        table.draw();
                        showSuccessMessage('Deleted!', response.msg);
                    }
                    else if (response.status == "error") {
                        showError('Oops!', 'Sub Category cannot be deleted because it has Policies.');
                    }
                    else {
                        showError('Delete Failed', response.msg);
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
            $.get("{{ route('select_type_sub_categories.index') }}" + '/' + id, function (data) {
                const subCategoryNames = data.select_type_sub_category.map(subcategory => subcategory.select_type).join(',');
                $('#modelHeading').html("Show Select Type Sub Category");
                $('#savedata').val("edit-select-type-sub-category");
                $('#showSelectTypeSubCategoryModal').modal('show');
                $('#showSelectTypeSubCategoryForm #select_type_category_id').val(data.id);
                $('#subcategory-containers').html('');
                data.select_type_sub_category.forEach(function (subcategory) {
                var subcategoryRow = `
                    <div class="row subcategory-row">
                        <div class="col-sm-4">
                            <label class="" for="select_type">Select Type Sub Category Name</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="select_type_sub_categories[][select_type_sub_category_name]"   disabled class="form-control"
                                placeholder="Enter  Select Type Sub Category" aria-label="Subcategory"
                                value="${subcategory.select_type_sub_category_name ? subcategory.select_type_sub_category_name : ''}" />
                        </div><br><br>

                    </div>`;
                    $('#subcategory-containers').append(subcategoryRow);
                });
            });
        });
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);

        $(document).on('click', '.remove-subcategory-btn', function () {
            $(this).closest('.subcategory-row').remove();
        });
    });
</script>
