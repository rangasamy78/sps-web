<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#formAddNewQuote input, #formAddNewQuote select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#nextStepAddProductBtn').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#quote_id').val() ? "{{ route('quote.quotes.update', ':id') }}".replace(':id', $('#quote_id').val()) : "{{ route('quote.quotes.store') }}";
            var type = $('#quote_id').val() ? "PUT" : "POST";
            var data = $('#quote_id').val() ? $('#formUpdateNewQuote').serialize() : $('#formAddNewQuote').serialize();
            var id = $('#quote_id').val();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#formAddNewQuote').trigger("reset");
                        sending(button, true);
                        showToast('success', response.msg);
                        window.location.href = "{{ route('quote.quotes.show', ':id') }}".replace(':id', response.quote_id);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
    });
</script>