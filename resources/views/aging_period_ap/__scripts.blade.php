<script type="text/javascript">
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        $('#period_current_1').hide();
        $('#aging_period_ap_1_lbl').html(1);
        $('#aging_period_ap_2_lbl').html(2);
        $('#aging_period_ap_3_lbl').html(3);
        $('#aging_period_ap_4_lbl').html(4);
        $('#aging_period_ap_5_lbl').html(5);

        var aging_period_ap_2_to = parseFloat($('#aging_period_ap_1_end').val()) + 1;
        var aging_period_ap_3_to = parseFloat($('#aging_period_ap_2_end').val()) + 1;
        var aging_period_ap_4_to = parseFloat($('#aging_period_ap_3_end').val()) + 1;
        $('#aging_period_ap_2_start').val(aging_period_ap_2_to);
        $('#aging_period_ap_3_start').val(aging_period_ap_3_to);
        $('#aging_period_ap_4_start').val(aging_period_ap_4_to);

        var ap_over_days_val = ($('#aging_period_ap_4_end').val() > 0) ? $('#aging_period_ap_4_end').val() : $(
            '#aging_period_ap_3_end').val();
        $('#aging_period_ap_over_days').html(ap_over_days_val);

        $(document).on('change', 'input[type="number"]', function() {
            var aging_period_ap_2_to = parseFloat($('#aging_period_ap_1_end').val()) + 1;
            var aging_period_ap_3_to = parseFloat($('#aging_period_ap_2_end').val()) + 1;
            var aging_period_ap_4_to = parseFloat($('#aging_period_ap_3_end').val()) + 1;
            $('#aging_period_ap_2_start').val(aging_period_ap_2_to);
            $('#aging_period_ap_3_start').val(aging_period_ap_3_to);
            $('#aging_period_ap_4_start').val(aging_period_ap_4_to);
            var ap_over_days_val = ($('#aging_period_ap_4_end').val() > 0) ? $('#aging_period_ap_4_end')
                .val() : $('#aging_period_ap_3_end').val();
            $('#aging_period_ap_over_days').html(ap_over_days_val);
        });
        $('button[name="btn_invoice_due_date"]').on('click', function() {
            resetForm();
            var toggleBtnVal = $(this).val();
            if (toggleBtnVal == '1') {
                $('#period_current_1').hide();
                $('#aging_period_ap_1_lbl').html(1);
                $('#aging_period_ap_2_lbl').html(2);
                $('#aging_period_ap_3_lbl').html(3);
                $('#aging_period_ap_4_lbl').html(4);
                $('#aging_period_ap_5_lbl').html(5);
                $('#aging_period_ap_1_start').val(0);
            } else {
                $('#period_current_1').show();
                $('#aging_period_ap_1_lbl').html(2);
                $('#aging_period_ap_2_lbl').html(3);
                $('#aging_period_ap_3_lbl').html(4);
                $('#aging_period_ap_4_lbl').html(5);
                $('#aging_period_ap_5_lbl').html(6);
                $('#aging_period_ap_1_start').val(1);
            }
        });

        $('#savedata').click(function(e) {
            resetForm();
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            $.ajax({
                url: "{{ route('aging_periods_aps.save') }}",
                type: "POST",
                data: {
                    id: $('#aging_period_ap_id').val(),
                    invoice_aging_period_ap_1_start: 0,
                    due_date_aging_period_ap_1_start: 1,
                    invoice_aging_period_ap_2_start: $('#aging_period_ap_2_start').val(),
                    due_date_aging_period_ap_2_start: $('#aging_period_ap_2_start').val(),
                    invoice_aging_period_ap_3_start: $('#aging_period_ap_3_start').val(),
                    due_date_aging_period_ap_3_start: $('#aging_period_ap_3_start').val(),
                    invoice_aging_period_ap_4_start: $('#aging_period_ap_4_start').val(),
                    due_date_aging_period_ap_4_start: $('#aging_period_ap_4_start').val(),
                    invoice_aging_period_ap_1_end: $('#aging_period_ap_1_end').val(),
                    due_date_aging_period_ap_1_end: $('#aging_period_ap_1_end').val(),
                    invoice_aging_period_ap_2_end: $('#aging_period_ap_2_end').val(),
                    due_date_aging_period_ap_2_end: $('#aging_period_ap_2_end').val(),
                    invoice_aging_period_ap_3_end: $('#aging_period_ap_3_end').val(),
                    due_date_aging_period_ap_3_end: $('#aging_period_ap_3_end').val(),
                    invoice_aging_period_ap_4_end: $('#aging_period_ap_4_end').val(),
                    due_date_aging_period_ap_4_end: $('#aging_period_ap_4_end').val(),
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#savedata').html(button);
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });
        $('#agingPeriodAPForm input').on('input', function() {
            let fieldName = 'invoice_' + $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
        function resetForm() {
        $('.invoice_aging_period_ap_1_end_error').html('');
        $('.invoice_aging_period_ap_2_end_error').html('');
        $('.invoice_aging_period_ap_3_end_error').html('');
    }
});
</script>
