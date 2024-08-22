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
                url: "{{ route('transaction_startings.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'type', name: 'type' },
                { data: 'starting_number', name: 'starting_number' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createTransactionStarting').click(function () {
            resetForm();
            $('#savedata').html("Save Transaction Starting Number");
            $('#transaction_startings_id').val('');
            $('#transactionStartingForm').trigger("reset");
            $('#modelHeading').html("Create New Transaction Starting Number");
            $('#transactionStartingModel').modal('show');
        });
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#transaction_starting_id').val() ? "{{ route('transaction_startings.update', ':id') }}".replace(':id', $('#transaction_starting_id').val()) : "{{ route('transaction_startings.store') }}";
            var type = $('#transaction_starting_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#transactionStartingForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#transactionStartingForm').trigger("reset");
                        $('#transactionStartingModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });

        $('#transactionStartingForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })

        $('body').on('click', '.editbtn', function () {
            resetForm();
            var id = $(this).data('id');

            $.get("{{ route('transaction_startings.index') }}" + '/' + id + '/edit', function (data) {
                $('#modelHeading').html("Edit Transaction Starting Number");
                $('#savedata').val("edit-transaction-starting");
                $('#savedata').html("Update Transaction Starting Number");
                $('#transactionStartingModel').modal('show');
                $('#transaction_starting_id').val(data.id);
                $('#type').val(data.type);
                $('#starting_number').val(data.starting_number);
            });
        });

        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteTransactionStarting(id);
            });
        });

        function deleteTransactionStarting(id) {
            var url = "{{ route('transaction_startings.destroy', ':id') }}".replace(':id', id);
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
            $.get("{{ route('transaction_startings.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Transaction Starting Numbers");
                $('#savedata').val("edit-starting-transaction");
                $('#showTransactionStartingModal').modal('show');
                $('#showTransactionStartingForm #type').val(data.type);
                $('#showTransactionStartingForm #starting_number').val(data.starting_number);

            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

    function resetForm() {
        $('.type_error').html('');
        $('.starting_number_error').html('');
    }
</script>
