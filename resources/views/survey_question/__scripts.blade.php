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
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('survey_questions.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'transaction', name: 'transaction' },
                { data: 'short_label', name: 'short_label' },
                { data: 'question', name: 'question' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });

        $('#createSurveyQuestion').click(function () {
            resetForm();
            $('#savedata').html("Save Survey Question");
            $('#survey_question_id').val('');
            $('#surveyQuestionForm').trigger("reset");
            $('#modelHeading').html("Create New Survey Question");
            $('#surveyQuestionModel').modal('show');
        });

        $('#surveyQuestionForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#surveyQuestionForm input, #surveyQuestionForm select').on('input change', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#survey_question_id').val() ? "{{ route('survey_questions.update', ':id') }}".replace(':id', $('#survey_question_id').val()) : "{{ route('survey_questions.store') }}";
            var type = $('#survey_question_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#surveyQuestionForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#surveyQuestionForm').trigger("reset");
                        $('#surveyQuestionModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Survey Question Added Successfully!' : 'Survey Question Updated Successfully!';
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
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('survey_questions.index') }}" + '/' + id + '/edit', function (data) {
                $('#modelHeading').html("Edit Survey Question");
                $('#surveyQuestionModel').modal('show');
                $('#savedata').val("edit-survey-question");
                $('#savedata').html("Update Survey Question");
                $('#survey_question_id').val(data.id);
                $('#transaction').val(data.transaction);
                $('#short_label').val(data.short_label);
                $('#question').val(data.question);
                $('#transaction_question_id').val(data.transaction_question_id);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteSurveyQuestion(id);
            });
        });

        function deleteSurveyQuestion(id) {
            var url = "{{ route('survey_questions.destroy', ':id') }}".replace(':id', id);
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
                        showSuccessMessage('Deleted!', 'Survey Question Deleted Successfully!');
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
            $.get("{{ route('survey_questions.index') }}" + '/' + id, function (data) {
                $('#showSurveyQuestionModal').modal('show');
                $('#showSurveyQuestionForm #transaction').val(data.transaction);
                $('#showSurveyQuestionForm #short_label').val(data.short_label);
                $('#showSurveyQuestionForm #question').val(data.question);
                $('#showSurveyQuestionForm #transaction_question_id').val(data.transaction_question_id);
            });
        });
    });

    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
        $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
    }, 300);

    function resetForm() {
        $('.transaction_error').html('');
        $('.short_label_error').html('');
        $('.question_error').html('');
    }

    $('body').on('change', '#transaction', function () {
        const url ="{{ route('survey_questions.transaction') }}" ;
        var id = $(this).val();
         $.ajax({
            url: url,
            type: 'GET',
            data: {
                    id: id,
                }, 
            contentType: 'application/json',
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token if needed
            },
            success: function(response) {
                $('#transaction_question_id').val(++response.count);
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
     });
</script>