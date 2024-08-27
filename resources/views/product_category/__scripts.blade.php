<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productCategoryNameFilter, #productSubCategoryFilter').on('keyup change', function(e) {
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
                url: "{{ route('product_categories.list') }}",
                data: function (d) {
                    d.product_category_name_search = $('#productCategoryNameFilter').val();
                    d.product_sub_category_name_search = $('#productSubCategoryFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'product_category_name', name: 'product_category_name' },
                { data: 'subcategory', name: 'subcategory' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            }
        });

        $('#createProductCategory').click(function () {
            $('#product_category_form').trigger("reset");
            $('.product_category_name_error').html('');
            $('#savedata').html("Save Product Category");
            $('#product_category_id').val('');
            $('#productCategoryForm').trigger("reset");
            $('#modelHeading').html("Create New Product Category");
            $('#productCategoryModel').modal('show');
            $('#subcategory-container').html('');

            var blankSubcategoryRow = `
                <div class="row subcategory-row">
                    <div class="col-sm-4">
                        <label class="" for="product_sub_category_name">Sub Category Name</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="product_sub_categories[][product_sub_category_name]"  class="form-control"
                            placeholder="Enter Subcategory Name" aria-label="Subcategory" />
                             <span class="error-message" style="color: red; display: none;">Duplicate subcategory name found.</span>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary add-subcategory-btn"
                            style="width: 30px; height: 30px;">
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
                            <label class="" for="product_sub_category_name">Sub Category Name</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="product_sub_categories[][product_sub_category_name]" class="form-control" placeholder="Enter Sub Category Name" aria-label="Category Name" />
                            <span class="error-message" style="color: red; display: none;">Duplicate subcategory name found.</span>
                        </div>
                        <div class="col-sm-2">
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

        $('#productCategoryForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {
            e.preventDefault();

            if (checkSubcategoryDuplicate()) {
                return;
            }
            var button = $(this);
            sending(button);
            var url = $('#product_category_id').val() ? "{{ route('product_categories.update', ':id') }}".replace(':id', $('#product_category_id').val()) : "{{ route('product_categories.store') }}";
            var type = $('#product_category_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productCategoryForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#productCategoryForm').trigger("reset");
                        $('#productCategoryModel').modal('hide');
                        table.draw();
                        showToast('success', response.msg);
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
                }
            });
        });

        $('body').on('click', '.editbtn', function () {
            $('.product_category_name_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('product_categories.index') }}" + '/' + id + '/edit', function (data) {
                $(".product_category_name_error").html("");
                $('#modelHeading').html("Edit Product Category");
                $('#savedata').val("edit-product-category");
                $('#savedata').html("Update Product Category");
                $('#productCategoryModel').modal('show');
                $('#product_category_id').val(data.id);
                $('#product_category_name').val(data.product_category_name);
                $('#subcategory-container').html('');

                var blankSubcategoryRow = `
                    <div class="row subcategory-row">
                        <div class="col-sm-4">
                            <label for="product_sub_category_name">Sub Category Name</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="product_sub_categories[][product_sub_category_name]" class="form-control"
                                placeholder="Enter Subcategory Name" aria-label="Subcategory" />
                            <span class="error-message" style="color: red; display: none;">Duplicate subcategory name found.</span>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary add-subcategory-btn"
                                style="width: 30px; height: 30px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>`;

                if (data.sub_categories.length === 0) {
                    $('#subcategory-container').append(blankSubcategoryRow);
                } else {
                    data.sub_categories.forEach(function (subcategory, index) {
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
                                    <label for="product_sub_category_name">Sub Category Name</label>
                                </div><br><br>
                                <div class="col-sm-6">
                                    <input type="text" name="product_sub_categories[][product_sub_category_name]" class="form-control"
                                        placeholder="Enter Subcategory Name" aria-label="Subcategory" value="${subcategory.product_sub_category_name ? subcategory.product_sub_category_name : ''}" />
                                    <span class="error-message" style="color: red; display: none;">Duplicate subcategory name found.</span>
                                </div>
                                <div class="col-sm-2">
                                    ${buttonHtml}
                                </div>
                            </div>`;
                        $('#subcategory-container').append(subcategoryRow);
                    });
                }
            });
        });

        $('body').on('click', '.remove-subcategory-btn', function () {
            $(this).closest('.subcategory-row').remove();
        });

        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteProductCategory(id);
            });
        });

        function deleteProductCategory(id) {
            var url = "{{ route('product_categories.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('product_categories.index') }}" + '/' + id, function (data) {
                const subCategoryNames = data.sub_categories.map(subcategory => subcategory.product_sub_category_name).join(',');
                $('#modelHeading').html("Show Product Category");
                $('#savedata').val("edit-product-category");
                $('#showProductCategoryModal').modal('show');
                $('#showProductCategoryForm #product_category_name').val(data.product_category_name);
                $('#subcategory-containers').html('');
                data.sub_categories.forEach(function (subcategory) {
                    var subcategoryRow = `
                        <div class="row subcategory-row">
                            <div class="col-sm-4">
                                <label class="" for="product_sub_category_name">Sub Category Name</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="product_sub_categories[][product_sub_category_name]"   disabled class="form-control"
                                    placeholder="Enter Subcategory Name" aria-label="Subcategory"
                                    value="${subcategory.product_sub_category_name ? subcategory.product_sub_category_name : ''}" />
                            </div><br><br>
                        </div>`;
                    $('#subcategory-containers').append(subcategoryRow);
                });
            });
        });

        $(document).on('click', '.remove-subcategory-btn', function () {
            $(this).closest('.subcategory-row').remove();
        });

    });
    var hasDuplicates = false;
    function checkSubcategoryDuplicate() {
        var allInputs = document.querySelectorAll('input[name="product_sub_categories[][product_sub_category_name]"]');
        var selectTypes = [];
        hasDuplicates = false;

        allInputs.forEach(function (inputElement) {
            var selectType = inputElement.value.trim();
            var errorMessageSpan = inputElement.parentElement.querySelector('.error-message');

            if (selectType === "") {
                if (errorMessageSpan) {
                    errorMessageSpan.style.display = 'none';
                }
                return;
            }

            if (selectTypes.includes(selectType)) {
                hasDuplicates = true;
                if (errorMessageSpan) {
                    errorMessageSpan.style.display = 'inline';
                }
                inputElement.focus();
            } else {
                selectTypes.push(selectType);
                if (errorMessageSpan) {
                    errorMessageSpan.style.display = 'none';
                }
            }
        });

        return hasDuplicates;
    }

</script>
