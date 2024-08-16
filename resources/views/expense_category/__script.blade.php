<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#expenseCategoryTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('expense_categories.list') }}",
                data: function(d) {
                    d.expense_category_search = $('#expenseCategoryFilter').val();
                    d.expense_account_search = $('#expenseAccountFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 0,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'expense_category_name',
                    name: 'expense_category_name'
                },
                {
                    data: 'linked_account_id',
                    name: 'linked_account_id'
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Expense Category</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#expenseCategoryModel',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Expense Category");
                    $('#expense_category_id').val('');
                    $('#expenseCategoryForm').trigger("reset");
                    $(".expense_category_name_error").html("");
                    $(".expense_account_error").html("");
                    $('#modelHeading').html("Create New Expense Category");
                    $('#expenseCategoryModel').modal('show');
                }
            }],
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right',
                '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left',
                '30px');
        }, 300);

        $('#expenseCategoryForm input, #expenseCategoryForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#expense_category_id').val() ? "{{ route('expense_categories.update', ':id') }}".replace(':id', $('#expense_category_id').val()) : "{{ route('expense_categories.store') }}";
            var type = $('#expense_category_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#expenseCategoryForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#expenseCategoryForm').trigger("reset");
                        $('#expenseCategoryModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Expense Category Added Successfully!' : 'Expense Category Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $(".expense_category_name_error").html("");
            $(".expense_account_error").html("");
            $.get("{{ route('expense_categories.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update Expense Category");
                $('#savedata').html("Update Expense Category");
                $('#expenseCategoryModel').modal('show');
                $('#expense_category_id').val(data.id);
                $('#expense_category_name').val(data.expense_category_name);
                $('#expense_account').val(data.expense_account);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteExpenseCategory(id);
            });
        });

        function deleteExpenseCategory(id) {
            var url = "{{ route('expense_categories.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        table.draw();
                        showSuccessMessage('Deleted!', 'Expense Category Deleted Successfully!');
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function(xhr) {
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('expense_categories.index') }}" + '/' + id, function(data) {
                $('#showExpenseCategoryModal').modal('show');
                $('#showExpenseCategoryForm #expense_category_name').val(data.expense_category_name);
                $('#showExpenseCategoryForm #expense_account').val(data.expense_account);
            });
        });
        $('#expenseCategoryFilter, #expenseAccountFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });
    });
</script>