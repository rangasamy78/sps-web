<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#opportunityVisitForm input, #opportunityVisitForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#saveOpportunityVisit').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var activeDeliveryMethod = $('#pills-tab .nav-link.active').val();
            var url = "{{ route('visit.opportunities.save') }}";
            var type = "POST";
            var data = $('#opportunityVisitForm').serialize() + "&ship_to_type=" + activeDeliveryMethod;
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#opportunityVisitForm').trigger("reset");
                        showToast('success', response.msg);
                        window.location.href = "{{ route('visits.show_add_product', ':id') }}".replace(':id', response.visit_id);
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