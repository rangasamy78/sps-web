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

        var aging_period_ap_2_to = parseInt($('#aging_period_ap_1_end').val()) + 1;
        var aging_period_ap_3_to = parseInt($('#aging_period_ap_2_end').val()) + 1;
        var aging_period_ap_4_to = parseInt($('#aging_period_ap_3_end').val()) + 1;

        $('#aging_period_ap_2_start').val(aging_period_ap_2_to);
        $('#aging_period_ap_3_start').val(aging_period_ap_3_to);
        $('#aging_period_ap_4_start').val(aging_period_ap_4_to);

        var ap_over_days_val = ($('#aging_period_ap_4_end').val() > 0) ? $('#aging_period_ap_4_end').val() : $('#aging_period_ap_3_end').val();
        $('#aging_period_ap_over_days').html(ap_over_days_val);

        $(document).on('change', 'input[type="number"]', function() {
            var aging_period_ap_2_to = parseInt($('#aging_period_ap_1_end').val()) + 1;
            var aging_period_ap_3_to = parseInt($('#aging_period_ap_2_end').val()) + 1;
            var aging_period_ap_4_to = parseInt($('#aging_period_ap_3_end').val()) + 1;
            $('#aging_period_ap_2_start').val(aging_period_ap_2_to);
            $('#aging_period_ap_3_start').val(aging_period_ap_3_to);
            $('#aging_period_ap_4_start').val(aging_period_ap_4_to);
            var ap_over_days_val = ($('#aging_period_ap_4_end').val() > 0) ? $('#aging_period_ap_4_end').val() : $('#aging_period_ap_3_end').val();
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
                url: "{{ route('account_payable_aging_periods.save') }}",
                type: "POST",
                data: {
                    id: $('#aging_period_ap_id').val(),
                    ap_invoice_date_start_1: 0,
                    ap_due_date_start_2: 1,
                    ap_invoice_date_start_2: $('#aging_period_ap_2_start').val(),
                    ap_due_date_start_3: $('#aging_period_ap_2_start').val(),
                    ap_invoice_date_start_3: $('#aging_period_ap_3_start').val(),
                    ap_due_date_start_4: $('#aging_period_ap_3_start').val(),
                    ap_invoice_date_start_4: $('#aging_period_ap_4_start').val(),
                    ap_due_date_start_5: $('#aging_period_ap_4_start').val(),
                    ap_invoice_date_end_1: $('#aging_period_ap_1_end').val(),
                    ap_due_date_end_2: $('#aging_period_ap_1_end').val(),
                    ap_invoice_date_end_2: $('#aging_period_ap_2_end').val(),
                    ap_due_date_end_3: $('#aging_period_ap_2_end').val(),
                    ap_invoice_date_end_3: $('#aging_period_ap_3_end').val(),
                    ap_due_date_end_4: $('#aging_period_ap_3_end').val(),
                    ap_invoice_date_end_4: $('#aging_period_ap_4_end').val(),
                    ap_due_date_end_5: $('#aging_period_ap_4_end').val(),
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
                    var response = xhr.responseJSON;
                    if (response.errors.aging_period_ap_1_greater_than) {
                        if (response.errors.aging_period_ap_1_greater_than.length > 0) {
                            $('.period_must_be_greater_error').text(response.errors.aging_period_ap_1_greater_than[0]);
                            $('#aging_period_ap_1_end').addClass('is-invalid');
                        }
                    }

                    if (response.errors.aging_period_ap_2_greater_than) {
                        if (response.errors.aging_period_ap_2_greater_than.length > 0) {
                            $('.period_must_be_greater_error').text(response.errors.aging_period_ap_2_greater_than[0]);
                            $('#aging_period_ap_2_end').addClass('is-invalid');
                        }
                    }

                    if (response.errors.aging_period_ap_3_greater_than) {
                        if (response.errors.aging_period_ap_3_greater_than.length > 0) {
                            $('.period_must_be_greater_error').text(response.errors.aging_period_ap_3_greater_than[0]);
                            $('#aging_period_ap_3_end').addClass('is-invalid');
                        }
                    }

                    if (response.errors.aging_period_ap_4_greater_than) {
                        if (response.errors.aging_period_ap_4_greater_than.length > 0) {
                            $('.period_must_be_greater_error').text(response.errors.aging_period_ap_4_greater_than[0]);
                            $('#aging_period_ap_4_end').addClass('is-invalid');
                        }
                    }
                }
            });
        });

        $('#agingPeriodAPForm input').on('input', function() {
            let fieldName = 'invoice_' + $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        function resetForm() {
            $('.ap_invoice_date_start_1_end_error').html('');
            $('.ap_invoice_date_start_2_end_error').html('');
            $('.ap_invoice_date_start_3_end_error').html('');
            $('.period_must_be_greater_error').html('');
            $('#aging_period_ap_1_end').removeClass('is-invalid');
            $('#aging_period_ap_2_end').removeClass('is-invalid');
            $('#aging_period_ap_3_end').removeClass('is-invalid');
            $('#aging_period_ap_4_end').removeClass('is-invalid');
        }
});
</script>
