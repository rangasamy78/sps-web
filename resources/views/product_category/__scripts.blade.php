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
                url: "{{ route('product_categories.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
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

            // Add a blank subcategory row for adding new subcategories
            var blankSubcategoryRow = `
                <div class="row subcategory-row">
                    <div class="col-sm-4">
                        <label class="" for="product_sub_category_name">Sub Category Name</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="product_sub_categories[][product_sub_category_name]" onchange="checksubcategoryduplicate()"  class="form-control"
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
            var newSubcategoryRow = `
            <div class="row subcategory-row mt-2">
                <div class="col-sm-4">
                    <label class="" for="product_sub_category_name">Sub Category Name</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" name="product_sub_categories[][product_sub_category_name]" onchange="checksubcategoryduplicate()"  class="form-control" placeholder="Enter Sub Category Name" aria-label="Category Name" />
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
        });
        $('#productCategoryForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();

            if (checkSubcategoryDuplicate()) {
                return;
            }

            var button = $(this).html();
            $(this).html('Sending..');
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
                        var successMessage = type === 'POST' ? 'Product Category Added Successfully!' : 'Product Category Updated Successfully!';
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
                <input type="text" name="product_sub_categories[][product_sub_category_name]" onchange="checksubcategoryduplicate()" class="form-control"
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

        if (data.subcategories.length === 0) {
            $('#subcategory-container').append(blankSubcategoryRow);
        } else {
            data.subcategories.forEach(function (subcategory, index) {
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
                    <input type="text" name="product_sub_categories[][product_sub_category_name]" onchange="checksubcategoryduplicate()" class="form-control"
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
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Product Category Deleted Successfully!');
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
            $.get("{{ route('product_categories.index') }}" + '/' + id, function (data) {
                const subCategoryNames = data.subcategories.map(subcategory => subcategory.product_sub_category_name).join(',');
                $('#modelHeading').html("Show Product Category");
                $('#savedata').val("edit-product-category");
                $('#showProductCategoryModal').modal('show');
                $('#showProductCategoryForm #product_category_name').val(data.product_category_name);
                $('#subcategory-containers').html('');
                data.subcategories.forEach(function (subcategory) {
                    var subcategoryRow = `
                <div class="row subcategory-row">
                    <div class="col-sm-4">
                        <label class="" for="product_sub_category_name">Sub Category Name</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="product_sub_categories[][product_sub_category_name]"   disabled class="form-control"
                            placeholder="Enter Subcategory Name" aria-label="Subcategory"
                            value="${subcategory.product_sub_category_name ? subcategory.product_sub_category_name : ''}" />
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
   var hasDuplicates = false;

   function checkSubcategoryDuplicate() {
    var allInputs = document.querySelectorAll('input[name="product_sub_categories[][product_sub_category_name]"]');
    var values = [];
    var hasDuplicates = false;

    allInputs.forEach(function (inputElement) {
        var value = inputElement.value.trim();
        
        // Skip empty or whitespace-only values
        if (value === "") {
            return;
        }
        
        console.log("Checking value:", value);
        
        if (values.includes(value)) {
            console.log("Duplicate found:", value);
            hasDuplicates = true;
            var errorMessageSpan = inputElement.parentElement.querySelector('.error-message');
            if (errorMessageSpan) {
                errorMessageSpan.style.display = 'inline';
            }
            inputElement.focus();
        } else {
            console.log("No duplicate, adding value:", value);
            values.push(value);
            var errorMessageSpan = inputElement.parentElement.querySelector('.error-message');
            if (errorMessageSpan) {
                errorMessageSpan.style.display = 'none';
            }
        }
    });

    console.log("Final values:", values);
    return hasDuplicates;
}





</script>