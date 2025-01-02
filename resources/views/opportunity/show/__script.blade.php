<script type="text/javascript">
    $(function() {

        // CSRF token setup for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        

        //internal notes update
        $('#updateInternalNote').click(function() {
            var internalNotes = $('#internal_notes').val();
            var opportunityId = $('#opportunity_id').val();
            var loggedInUser = $('#logged_in_user').val();
            var currentDateTime = new Date().toLocaleString();
            var updatedNotes = `${loggedInUser} ${currentDateTime} : ${internalNotes} \n\n`;
            if (internalNotes) {
                $.ajax({
                    url: "{{ route('opportunities.internal_notes', ':id ') }}".replace(':id', opportunityId),
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
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
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
        //probability close
        $('#probability_to_close_id').change(function() {
            var selectedValue = $(this).val(); // Get the selected value
            var opportunityId = $('#opportunity_id').val(); // Get the opportunity ID

            if (selectedValue) {
                $.ajax({
                    url: "{{ route('opportunities.probability_close', ':id') }}".replace(':id', opportunityId),
                    type: 'PATCH',
                    data: {
                        probability_to_close_id: selectedValue, // Send the selected value
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            opportunity_contact_list.draw();
                            handleAjaxResponse(response, opportunity_contact_list);
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
        //opportunity stage 
        $('#opportunity_stage_id').change(function() {
            var selectedValue = $(this).val(); // Get the selected value
            var opportunityId = $('#opportunity_id').val(); // Get the opportunity ID

            if (selectedValue) {
                $.ajax({
                    url: "{{ route('opportunities.stages', ':id') }}".replace(':id', opportunityId),
                    type: 'PATCH',
                    data: {
                        opportunity_stage_id: selectedValue, // Send the selected value
                        _token: '{{ csrf_token() }}' // CSRF token for security
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


    });

    function toggleTaxCode() {
        const checkbox = document.getElementById("is_ship_to_address");
        const taxCodeContainer = document.getElementById("taxCodeContainer");
        const taxCodeSelect = document.getElementById("tax_code_id");

        if (checkbox.checked) {
            taxCodeContainer.style.display = "block";
            taxCodeSelect.setAttribute("required", "required");
            taxCodeSelect.classList.add("is-invalid"); // Add Bootstrap's red border
        } else {
            taxCodeContainer.style.display = "none";
            taxCodeSelect.removeAttribute("required");
            taxCodeSelect.classList.remove("is-invalid"); // Remove Bootstrap's red border
            taxCodeSelect.value = ""; // Optionally clear the selection
        }
    }
</script>