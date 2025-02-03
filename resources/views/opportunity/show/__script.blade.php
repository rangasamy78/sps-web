<script type="text/javascript">
    $(function() {

        // CSRF token setup for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //sub transactions
        var Id = $('#opportunity_id').val();
        $('#datatableSubTransction').css('font-size', '10pt');

        var tbale_subtransaction = $('#datatableSubTransction').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,

            ajax: {
                url: "{{ route('subtransactions.list', ':id') }}".replace(':id', Id),
                data: function(d) {
                    // You can pass additional parameters to the server if needed here
                },
                dataSrc: function(json) {
                    // Convert the object to an array, as DataTable expects an array of data
                    return Object.values(json.data);
                }
            },
            columns: [{
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'time',
                    name: 'time'
                },
                {
                    data: 'days',
                    name: 'days'
                },
                {
                    data: 'expiryDate',
                    name: 'expiryDate'
                },
                {
                    data: 'transaction',
                    name: 'transaction'
                },
                {
                    data: 'projectType',
                    name: 'projectType'
                },
                {
                    data: 'endUseSegment',
                    name: 'endUseSegment'
                },
                {
                    data: 'label',
                    name: 'label'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'salesOrder',
                    name: 'salesOrder'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            rowCallback: function(row, data, index) {
                // Adjusting the row numbering based on the current page
                // $('td:eq(0)', row).html(tbale_subtransaction.page.info().start + index + 1);
            },
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
        // update survey rating
        $('#saveSurvey').click(function() {
            var id = $(this).data('id');
            var rating = $('#survey_rating_notes').val();
            if (rating) {
                $.ajax({
                    url: "{{ route('opportunities.survey', ':id') }}".replace(':id', id),
                    type: 'PATCH',
                    data: {
                        survey_rating_notes: rating,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('success', response.msg);
                            $('#checkout').hide();
                        } else {
                            alert('Failed to update opportunity survey rating: ' + response.msg);
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
