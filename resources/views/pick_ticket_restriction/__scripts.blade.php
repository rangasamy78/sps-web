<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('change', 'input[type="checkbox"], input[type="radio"]', function() {

            var enable_pick_ticket_restriction    = ($('input[name="enable_pick_ticket_restriction"]:checked').val() == 1) ? 1 : 0;
            var default_pick_ticket_restriction   = $('input[name="default_pick_ticket_restriction"]:checked').val();
            var pick_ticket_restriction_required  = ($('input[name="pick_ticket_restriction_required"]:checked').val() == 1) ? 1 : 0;
            var default_lot_restriction_based_on  = $("input[name='lot_restriction_based_on']:checked").val();

            enable_pick_ticket_restriction == 1 ? $('#pickTicketDisplay').show() : $('#pickTicketDisplay').hide();

            $.ajax({
                url: "{{ route('pick_ticket_restrictions.save') }}",
                type: "POST",
                data: {
                    id: $('#pick_ticket_restriction_id').val(),
                    enable_pick_ticket_restriction   : enable_pick_ticket_restriction,
                    default_pick_ticket_restriction  : default_pick_ticket_restriction,
                    pick_ticket_restriction_required : pick_ticket_restriction_required,
                    default_lot_restriction_based_on : default_lot_restriction_based_on,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        var successMessage = response.msg;
                        var successTitle   = response.status;
                        showSuccessMessage(successTitle, successMessage);
                        $('#pick_ticket_restriction_id').val(response.lastId);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });

        });
    });
</script>
