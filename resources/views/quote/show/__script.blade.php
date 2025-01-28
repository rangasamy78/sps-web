<script type="text/javascript">
    $(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //opportunity stage 
        $('#opportunity_stage_id').change(function() {
            var selectedValue = $(this).val();
            var opportunityId = $('#opportunity_id').val();

            if (selectedValue) {
                $.ajax({
                    url: "{{ route('opportunities.stages', ':id') }}".replace(':id', opportunityId),
                    type: 'PATCH',
                    data: {
                        opportunity_stage_id: selectedValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                        } else {
                            alert('Failed to update opportunity stages: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating opportunity stages');
                    }
                });
            }
        });

        //probability
        $('#probability_close_id').change(function() {
            var selectedValue = $(this).val();
            var quoteId = $('#quote_id').val();
            if (selectedValue) {
                $.ajax({
                    url: "{{ route('quote.probability_close', ':id') }}".replace(':id', quoteId),
                    type: 'PATCH',
                    data: {
                        probability_close_id: selectedValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                        } else {
                            alert('Failed to update probability close: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating probability close');
                    }
                });
            }
        });

        //internal notes update
        $('#updateInternalNote').click(function() {
            var internalNotes = $('#quote_internal_note').val();
            var quoteId = $('#quote_id').val();
            var loggedInUser = $('#logged_in_user').val();
            var currentDateTime = new Date().toLocaleString();
            var updatedNotes = `${loggedInUser} ${currentDateTime} : ${internalNotes} \n\n`.trim();
            if (internalNotes) {
                $.ajax({
                    url: "{{ route('quote.internal_notes', ':id ') }}".replace(':id', quoteId),
                    type: 'PATCH',
                    data: {
                        quote_internal_note: updatedNotes,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#internal_notes_input').val(response.data);
                            $('#quote_internal_note').val('');
                            showToast('success', response.msg);
                        } else {
                            alert('Failed to update internal notes: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating internal notes');
                    }
                });
            } else {
                alert('Please enter some notes');
            }
        });

        // delete
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteQuote(id);
            });
        });

        function deleteQuote(id) {
            var url = "{{ route('quote.quotes.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, '');
                        window.location.href = "{{ route('opportunities.show', ':id') }}".replace(':id', $('#opportunity_id').val());
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to delete the visit.');
                }
            });
        }

        // update survey rating
        $('#saveSurvey').click(function() {
            var id = $(this).data('id');
            var rating = $('#survey_rating').val();
            if (rating) {
                $.ajax({
                    url: "{{ route('quote.survey', ':id') }}".replace(':id', id),
                    type: 'PATCH',
                    data: {
                        survey_rating: rating,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            $('#checkout').hide();
                        } else {
                            alert('Failed to update opportunity stages: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating opportunity stages');
                    }
                });
            } else {
                alert('Enter a Notes')

            }
        });

        // update quote Status
        $('#quoteStatusForm textarea, #quoteStatusForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');;
            $('.' + inputName + '_error').html('');
        });
        $('#saveStatus').click(function() {
            var id = $(this).data('id');
            var date = $('#quoteStatusForm #status_update_date').val();
            var user_id = $('#quoteStatusForm #status_update_user_id').val();
            var status = $('#quoteStatusForm #status').val();
            var notes = $('#quoteStatusForm #notes').val();
            if (notes) {
                $.ajax({
                    url: "{{ route('quote.status', ':id') }}".replace(':id', id),
                    type: 'PATCH',
                    data: {
                        status_update_date: date,
                        status_update_user_id: user_id,
                        status: status,
                        notes: notes,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            $('#quoteStatusForm').trigger("reset");
                            $('#statusModel').modal('hide');
                            if (status == 'close') {
                                $('.showStatus').text('Closed');
                                $('.quote_status').text('Open Quote');
                                $('#statusModalLabel').text('Open Quote');
                                $('.update_date').text('Opened Date');
                                $('.update_by').text('Opened By');
                                $('#quoteStatusForm #notes').attr('readonly', true);
                                $('#quoteStatusForm #notes').val(notes);
                                $('#quoteStatusForm #status').val('open')
                            } else {
                                $('.showStatus').text('');
                                $('.quote_status').text('Close Quote');
                                $('#statusModalLabel').text('Close Quote');
                                $('.update_date').text('Closed Date');
                                $('.update_by').text('Closed By');
                                $('#quoteStatusForm #notes').attr('readonly', false);
                                $('#quoteStatusForm #notes').val('');
                                $('#quoteStatusForm #status').val('close')
                            }
                        } else {
                            alert('Failed to update opportunity stages: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating opportunity stages');
                    }
                });
            } else {
                $('#quoteStatusForm .notes_error').text('Enter a Notes');
                // alert('Enter a Notes')
            }
        });

    });
</script>