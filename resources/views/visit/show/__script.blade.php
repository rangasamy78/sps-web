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
            var selectedValue = $(this).val(); // Get the selected value
            var visitId = $('#visit_id').val(); // Get the opportunity ID
            if (selectedValue) {
                $.ajax({
                    url: "{{ route('visits.probability_close', ':id') }}".replace(':id', visitId),
                    type: 'PATCH',
                    data: {
                        probability_close_id: selectedValue, // Send the selected value
                        _token: '{{ csrf_token() }}' // CSRF token for security
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

        // delete
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteVisit(id);
            });
        });

        function deleteVisit(id) {
            var url = "{{ route('visits.destroy', ':id') }}".replace(':id', id);
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
                    url: "{{ route('visits.survey', ':id') }}".replace(':id', id),
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

    });
</script>