<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('change', 'input[type="checkbox"]', function() {
            var packing_list          = ($('input[name="packing_list"]:checked').val() == 1) ? 1 : 0;
            var invoice               = ($('input[name="invoice"]:checked').val() == 1) ? 1 : 0;
            var credit_check          = ($('input[name="credit_check"]:checked').val() == 1) ? 1 : 0;
            var purchase_order        = ($('input[name="purchase_order"]:checked').val() == 1) ? 1 : 0;
            var relock_sales_order    = ($('input[name="relock_sales_order"]:checked').val() == 1) ? 1 : 0;

            $.ajax({
                url: "{{ route('credit_check_settings.save') }}",
                type: "POST",
                data: {
                    id: $('#credit_check_setting_id').val(),
                    packing_list         : packing_list,
                    invoice              : invoice,
                    credit_check         : credit_check,
                    purchase_order       : purchase_order,
                    relock_sales_order   : relock_sales_order,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        });
    });
</script>
