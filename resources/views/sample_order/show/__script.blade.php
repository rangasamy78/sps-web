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
            var sampleOrderId = $('#sample_order_id').val();
            if (selectedValue) {
                $.ajax({
                    url: "{{ route('create.probability_close', ':id') }}".replace(':id', sampleOrderId),
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

        //Status
        $('#status').change(function() {
            var selectedValue = $(this).val();
            var sampleOrderId = $('#sample_order_id').val();
            if (selectedValue) {
                $.ajax({
                    url: "{{ route('create.status', ':id') }}".replace(':id', sampleOrderId),
                    type: 'PATCH',
                    data: {
                        status: selectedValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);

                        } else {
                            alert('Failed to update status: ' + response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                        alert('An error occurred while updating status');
                    }
                });
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