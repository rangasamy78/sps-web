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
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('probability_to_closes.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 1, dir: sort }];
                }
            },
            columns: [
                { data: null, name: 'serial', orderable: false, searchable: false },
                { data: 'probability_to_close', name: 'probability_to_close' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createProbabilityToClose').click(function () {
            $('.probability_to_close_error').html('');
            $('#savedata').html("Save Probability To Close");
            $('#probability_to_close_id').val('');
            $('#probabilityToCloseForm').trigger("reset");
            $('#modelHeading').html("Create New Probability To Close");
            $('#probabilityToCloseModel').modal('show');
        });
        $('#probabilityToCloseForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#probability_to_close_id').val() ? "{{ route('probability_to_closes.update', ':id') }}".replace(':id', $('#probability_to_close_id').val()) : "{{ route('probability_to_closes.store') }}";
            var type = $('#probability_to_close_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#probabilityToCloseForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#probabilityToCloseForm').trigger("reset");
                        $('#probabilityToCloseModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Probability To Close Added Successfully!' : 'Probability To Close Updated Successfully!';
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
            $('.probability_to_close_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('probability_to_closes.index') }}" + '/' + id + '/edit', function (data) {
                $(".probability_to_close_code_error").html("");
                $('#modelHeading').html("Edit Probability To Close");
                $('#savedata').val("edit-probability-to-close");
                $('#savedata').html("Update Probability To Close");
                $('#probabilityToCloseModel').modal('show');
                $('#probability_to_close_id').val(data.id);
                $('#probability_to_close').val(data.probability_to_close);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteProbabilityToClose(id);
            });
        });
        function deleteProbabilityToClose(id) {
            var url = "{{ route('probability_to_closes.destroy', ':id') }}".replace(':id', id);
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
                        showSuccessMessage('Deleted!', 'Probability To Close Deleted Successfully!');
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
            $.get("{{ route('probability_to_closes.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Probability To Close");
                $('#savedata').val("edit-probability_to_close");
                $('#showProbabilityToCloseModal').modal('show');
                $('#showProbabilityToCloseForm #probability_to_close').val(data.probability_to_close);
            });
        });
    });

</script>
