<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#opportunityQuoteForm input, #opportunityQuoteForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#saveOpportunityQuote').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var activeDeliveryMethod = $('#pills-tab .nav-link.active').val();
            var url = "{{ route('quote.save') }}";
            var type = "POST";
            var data = $('#opportunityQuoteForm').serialize() + "&ship_to_type=" + activeDeliveryMethod;
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#opportunityQuoteForm').trigger("reset");
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

        $('#cancelButton').click(function() {
            const url = "{{ route('opportunities.index') }}";
            window.location.href = url;
        });

    });
</script>