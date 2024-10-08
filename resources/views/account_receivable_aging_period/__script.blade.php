<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            if (validateForm()) {
                $.ajax({
                    url: "{{ route('account_receivable_aging_periods.save') }}",
                    type: "POST",
                    data: $('#accountReceivableAgingPeriodForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == "success") {
                            showToast('success', response.msg);
                        }
                        $('#savedata').html('Update Aging Period');
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                    }
                });
            } else {
                setTimeout(() => {
                    $('#savedata').html('Update Aging Period');
                }, 300);
            }
        });
    });

    function validateForm() {
        let isValid = true;
        let visibleSection = $('#due_date').is(':visible') ? '#due_date' : '#invoice_date';
        let inputs = document.querySelectorAll(`${visibleSection} input[type="number"]:not([readonly]):not([disabled])`);
        inputs.forEach(function(input) {
            if (!input.value) {
                input.style.border = '1px solid red';
                isValid = false;
            } else {
                input.style.border = '';
            }
        });
        if (visibleSection === '#due_date') {
            if (!greaterDueDate()) {
                isValid = false;
            }
        } else if (visibleSection === '#invoice_date') {
            if (!greaterInvoice()) {
                isValid = false;
            }
        }

        return isValid;
    }

    function greaterInvoice() {
        let periods = [
            $('#ar_invoice_date_end_1'),
            $('#ar_invoice_date_end_2'),
            $('#ar_invoice_date_end_3'),
            $('#ar_invoice_date_end_4'),
        ];
        let isValid = true;
        let errorMessage = '';

        for (let i = 0; i < periods.length - 1; i++) {
            let currentPeriod = parseInt(periods[i].val()) || 0;
            let nextPeriod = parseInt(periods[i + 1].val()) || 0;

            if (currentPeriod >= nextPeriod) {
                periods[i + 1].css('border', '1px solid red');
                errorMessage = 'The end date of each invoice period must be greater than the previous period\'s end date.';
                isValid = false;
            } else {
                periods[i + 1].css('border', '');
            }
        }
        $('#error-text').text(errorMessage);
        return isValid;
    }

    function greaterDueDate() {
        let periods = [
            $('#ar_due_date_end_2'),
            $('#ar_due_date_end_3'),
            $('#ar_due_date_end_4'),
            $('#ar_due_date_end_5')
        ];

        let isValid = true;
        let errorMessage = '';

        for (let i = 0; i < periods.length - 1; i++) {
            let currentPeriod = parseInt(periods[i].val()) || 0;
            let nextPeriod = parseInt(periods[i + 1].val()) || 0;

            if (currentPeriod >= nextPeriod) {
                periods[i + 1].css('border', '1px solid red');
                errorMessage = 'The end date of each due date period must be greater than the previous period\'s end date.';
                isValid = false;
            } else {
                periods[i + 1].css('border', '');
            }
        }

        $('#error-text').text(errorMessage);
        return isValid; // Return true if no error message
    }

    $('#btn_invoice_date').click(function() {
        $('#error-text').text('');
        let isValid = true;
        let inputs = document.querySelectorAll('#invoice_date input[type="number"]:not([readonly]):not([disabled])');
        console.log(inputs);
        inputs.forEach(function(input) {
            if (!input.value) {
                input.style.border = '';
            }
        });
        return isValid;
    });

    $('#btn_due_date').click(function() {
        $('#error-text').text('');
        let isValid = true;
        let inputs = document.querySelectorAll('#due_date input[type="number"]:not([readonly]):not([disabled])');
        console.log(inputs);
        inputs.forEach(function(input) {
            if (!input.value) {
                input.style.border = '';
            }
        });
        return isValid;
    });

    function getInvoiceDateValue(id) {
        var currentValue = parseInt($('#' + id).val());
        var nextStartId = '';
        var currentStartId = '';
        switch (id) {
            case 'ar_invoice_date_end_1':
                nextStartId = 'ar_invoice_date_start_2';
                currentStartId = 'ar_invoice_date_start_1';
                break;
            case 'ar_invoice_date_end_2':
                nextStartId = 'ar_invoice_date_start_3';
                currentStartId = 'ar_invoice_date_start_2';
                break;
            case 'ar_invoice_date_end_3':
                nextStartId = 'ar_invoice_date_start_4';
                currentStartId = 'ar_invoice_date_start_3';
                break;
            case 'ar_invoice_date_end_4':
                nextStartId = 'ar_invoice_date_start_5';
                currentStartId = 'ar_invoice_date_start_4';
                break;
        }

        if (currentStartId && $('#' + currentStartId).length) {
            if (currentValue <= parseInt($('#' + currentStartId).val())) {
                $('#' + id).css('border', '1px solid red');
                $('#' + id).val('');
                $('#' + nextStartId).val('');
            } else {
                $('#' + id).css('border', ''); // Remove border if valid
                $('#' + nextStartId).val(currentValue + 1);
            }
        }

        if (nextStartId === 'ar_invoice_date_start_5') {
            if (isNaN(currentValue)) {
                $('#' + nextStartId).html('Over 150 days');
            } else {
                $('#' + nextStartId).html('Over ' + currentValue + ' days');
            }
        }
    }

    function getDueDateValue(id) {
        var currentValue = parseInt($('#' + id).val());
        var nextStartId = '';
        var currentStartId = '';

        switch (id) {
            case 'ar_due_date_end_2':
                nextStartId = 'ar_due_date_start_3';
                currentStartId = 'ar_due_date_start_2';
                break;
            case 'ar_due_date_end_3':
                nextStartId = 'ar_due_date_start_4';
                currentStartId = 'ar_due_date_start_3';
                break;
            case 'ar_due_date_end_4':
                nextStartId = 'ar_due_date_start_5';
                currentStartId = 'ar_due_date_start_4';
                break;
            case 'ar_due_date_end_5':
                nextStartId = 'ar_due_date_start_6';
                currentStartId = 'ar_due_date_start_5';
                break;
        }

        if (currentStartId && $('#' + currentStartId).length) {
            if (currentValue <= parseInt($('#' + currentStartId).val())) {
                $('#' + id).css('border', '1px solid red');
                $('#' + id).val('');
                $('#' + nextStartId).val('');
            } else {
                $('#' + id).css('border', '');
                $('#' + nextStartId).val(currentValue + 1);
            }
        }

        if (nextStartId === 'ar_due_date_start_6') {
            if (isNaN(currentValue)) {
                $('#' + nextStartId).html('Over 150 days');
            } else {
                $('#' + nextStartId).html('Over ' + currentValue + ' days');
            }
        }
    }

    $('#btn_due_date').click(function() {
        $('#btn_due_date').addClass('active');
        $('#btn_invoice_date').removeClass('active');
        $('#due_date').show();
        $('#invoice_date').hide();
    });
    $('#btn_invoice_date').click(function() {
        $('#btn_due_date').removeClass('active');
        $('#btn_invoice_date').addClass('active');
        $('#due_date').hide();
        $('#invoice_date').show();
    });
    document.getElementById('accountReceivableAgingPeriodForm').addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
    document.querySelectorAll('#invoice_date input[type="number"], #due_date input[type="number"]').forEach(function(input) {
        input.addEventListener('input', function() {
            if (input.value) {
                input.style.border = '';
            } else {
                input.style.border = '1px solid red';
            }
        });
    });
</script>
