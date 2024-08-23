    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#createLinkedAccountTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                ajax: {
                    url: "{{ route('linked_accounts.list') }}",
                    data: function(d) {
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
                        data: 'account_code',
                        name: 'account_code',
                    },
                    {
                        data: 'account_name',
                        name: 'account_name',
                    },
                    {
                        data: 'account_type',
                        name: 'account_type',
                    },
                    {
                        data: 'account_sub_type',
                        name: 'account_sub_type',
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

                dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [{
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Create Linked Account</span>',
                    className: 'create-new btn btn-primary',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#linkedAccountModel',
                    },
                    action: function(e, dt, node, config) {
                        $('#savedata').html("Save Linked Account");
                        clearError();
                        $('#linkedAccountForm').trigger("reset");
                        $("#linkedAccountForm").find("tr:gt(1)").remove();
                        $('#modelHeading').html("Create New Linked Account");
                        $('#linkedAccountModel').modal('show');
                    }
                }],
            });

            function clearError() {
                $('#linked_account_id').val('');
                $('.account_code_error').text('');
                $('.account_name_error').text('');
                $('.account_type_error').text('');
                $('.account_sub_type_error').text('');
            }

            $('#linkedAccountForm input, #linkedAccountForm select').on('keyup change', function() {
                var inputName = $(this).attr('name');
                $('.' + inputName + '_error').html('');
            });

            $('#savedata').click(function(e) {
                e.preventDefault();
                var button = $(this);
                sending(button);
                var url = $('#linked_account_id').val() ? "{{ route('linked_accounts.update', ':id') }}".replace(':id', $('#linked_account_id').val()) : "{{ route('linked_accounts.store') }}";
                var type = $('#linked_account_id').val() ? "PUT" : "POST";
                $.ajax({
                    url: url,
                    type: type,
                    data: $('#linkedAccountForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == "success") {
                            $('#linkedAccountForm').trigger("reset");
                            $('#linkedAccountModel').modal('hide');
                            table.draw();
                            var successMessage = type === 'POST' ? 'Linked Account Added Successfully!' : 'Linked Account Updated Successfully!';
                            var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                            showSuccessMessage(successTitle, successMessage);
                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                        sending(button,true);
                    }
                });
            });


            $('body').on('click', '.editbtn', function() {
                clearError();
                var id = $(this).data('id');
                $.get("{{ route('linked_accounts.index') }}" + '/' + id + '/edit', function(data) {
                    $('#modelHeading').html("Update Linked Account");
                    $('#savedata').val("edit-linked-account");
                    $('#savedata').html("Update Linked Account");
                    $('#linkedAccountModel').modal('show');
                    $('#linked_account_id').val(data.id);
                    $('#account_code').val(data.account_code);
                    $('#account_name').val(data.account_name);
                    $('#account_type').val(data.account_type);
                    $('#account_sub_type').val(data.account_sub_type);
                });
            });

            $('body').on('click', '.deletebtn', function() {
                var id = $(this).data('id');
                confirmDelete(id, function() {
                    deleteLinkedAccount(id);
                });
            });

            function deleteLinkedAccount(id) {
                var url = "{{ route('linked_accounts.destroy', ':id') }}".replace(':id', id);
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            table.draw(); // Assuming 'table' is defined for DataTables
                            showSuccessMessage('Deleted!', 'Linked Account Deleted Successfully!');
                        } else {
                            showError('Deleted!', response.msg);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.statusText);
                        showError('Oops!', 'Failed to fetch data.');
                    }
                });
            }

            $('body').on('click', '.showbtn', function() {
                var id = $(this).data('id');
                $.get("{{ route('linked_accounts.index') }}" + '/' + id, function(data) {
                    $('#showLinkedAccountModal').modal('show');
                    $('#showLinkedAccountForm #account_code').val(data.account_code);
                    $('#showLinkedAccountForm #account_name').val(data.account_name);
                    $('#showLinkedAccountForm #account_type').val(data.account_type);
                    $('#showLinkedAccountForm #account_sub_type').val(data.account_sub_type);
                });
            });
        });
    </script>