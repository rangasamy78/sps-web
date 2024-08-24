<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Validation on change
        $('.transaction-starting-number').on('change', function(e) {
            e.preventDefault();
            var allValid = true;
            $('.transaction-starting-number').each(function() {
                var inputField = $(this);
                var inputValue = inputField.val().trim();
                var intValue = parseInt(inputValue);
                if (intValue <= 0 || isNaN(intValue)) {
                    inputField.css('border', '1px solid red');
                    allValid = false; // Mark as invalid
                } else {
                    inputField.css('border', '');
                }
            });

            if (allValid) {
                $.ajax({
                    url: "{{ route('transaction_startings.save') }}",
                    type: "POST",
                    data: $('#transactionStartingNumberForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == "success") {
                            showToast('success', response.msg);
                            $('#transaction_starting_number_id').val(response.lastId);
                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                    }
                });
            }
        });
    });
</script>
