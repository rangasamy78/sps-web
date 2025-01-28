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
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);;
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
        $('#probability_to_close_id').change(function() {
            var selectedValue = $(this).val();
            var holdId = $('#hold_id').val();
            if (selectedValue) {
                $.ajax({
                    url: "{{ route('hold.probability_close', ':id') }}".replace(':id', holdId),
                    type: 'PATCH',
                    data: {
                        probability_to_close_id: selectedValue,
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
            var internalNotes = $('#internal_notes').val();
            var holdId = $('#hold_id').val();
            var loggedInUser = $('#logged_in_user').val();
            var currentDateTime = new Date().toLocaleString();
            var updatedNotes = `${loggedInUser} ${currentDateTime} : ${internalNotes} \n\n`.trim();
            if (internalNotes) {
                $.ajax({
                    url: "{{ route('hold.internal_notes', ':id ') }}".replace(':id', holdId),
                    type: 'PATCH',
                    data: {
                        internal_notes: updatedNotes,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#internal_notes_input').val(response.data);
                            $('#internal_notes').val('');
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

        // update survey rating
        $('#saveSurvey').click(function() {
            var id = $(this).data('id');
            var rating = $('#survey_rating').val();
            if (rating) {
                $.ajax({
                    url: "{{ route('hold.survey', ':id') }}".replace(':id', id),
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

        // delete
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteSampleOrder(id);
            });
        });

        function deleteSampleOrder(id) {
            var url = "{{ route('create.sample_orders.destroy', ':id') }}".replace(':id', id);
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
    });
</script>