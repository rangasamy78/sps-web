<script type="text/javascript">
    $(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Function to convert numbers to words
        function numberToWords(number) {
            const units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
            const teens = ['Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
            const tens = ['', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
            const scales = ['', 'Thousand', 'Million', 'Billion'];
            if (number === 0) return 'Zero';
            let words = '';

            function convert(num) {
                if (num < 10) return units[num];
                if (num < 20) return teens[num - 11];
                if (num < 100) return tens[Math.floor(num / 10)] + (num % 10 > 0 ? ' ' + units[num % 10] : '');
                if (num < 1000) return units[Math.floor(num / 100)] + ' Hundred' + (num % 100 > 0 ? ' and ' + convert(num % 100) : '');

                for (let i = 0, scale = 1; scale <= num; i++, scale *= 1000) {
                    if (num < scale * 1000) {
                        return convert(Math.floor(num / scale)) + ' ' + scales[i] + (num % scale > 0 ? ' ' + convert(num % scale) : '');
                    }
                }
            }
            words = convert(Math.floor(number));
            return words.trim();
        }

        // Function to handle decimal numbers
        function numberToWordsWithFraction(number) {
            const [integerPart, decimalPart] = number.toString().split('.');
            let words = numberToWords(parseInt(integerPart));
            if (decimalPart) {
                const fraction = decimalPart.substring(0, 2).padEnd(2, '0'); // Pad to ensure two digits
                words += ` and ${fraction}/100`;
            }
            return words;
        }

        $('.quote_percentage').on('click', function() {
            const quotePercentage = parseFloat($(this).val());
            const quoteTotal = parseFloat($('#current_balance_due').val());
            if ($.isNumeric(quotePercentage) && $.isNumeric(quoteTotal) && quoteTotal > 0) {
                const calculatedValue = (quotePercentage / 100) * quoteTotal;
                const fixedValue = calculatedValue.toFixed(2);
                $('#receive_amount').val(fixedValue);
                const amountInWords = numberToWordsWithFraction(fixedValue);
                $('#word_amount').text(`${amountInWords}`);
                const netDue = (quoteTotal - fixedValue).toFixed(2);
                $('#net_amount_due').val(netDue);
            } else {
                alert('Please enter valid numeric values for percentage and total.');
            }
        });

        $('#receive_amount').on('change', function() {
            const receiveAmount = parseFloat($(this).val());
            const quoteTotal = parseFloat($('#current_balance_due').val());
            const netDue = (quoteTotal - receiveAmount).toFixed(2);
            $('#net_amount_due').val(netDue);
            const amountInWords = numberToWordsWithFraction(receiveAmount);
            $('#word_amount').text(`${amountInWords}`);
        });

        //hide show text box based on payment method
        $(document).ready(function() {
            $('#reference').closest('.payment').removeClass('d-none');
            $('#reference_date').closest('.payment').removeClass('d-none');
            $('#authorization').closest('.payment').removeClass('d-none');
            $('#payment_method_id').on('change', function() {
                const selectedText = $('#payment_method_id option:selected').text().trim();
                $('.payment').addClass('d-none');
                if (selectedText === 'Check') {
                    $('#check_code_container').removeClass('d-none');
                    $('#check_date_container').removeClass('d-none');
                } else if (['Cash', 'Wire', 'Other'].includes(selectedText)) {
                    $('#reference').closest('.payment').removeClass('d-none');
                    $('#reference_date').closest('.payment').removeClass('d-none');
                } else if (selectedText) {
                    $('#reference').closest('.payment').removeClass('d-none');
                    $('#reference_date').closest('.payment').removeClass('d-none');
                    $('#authorization').closest('.payment').removeClass('d-none');
                }
            });
        });

        $('#formAddQuoteReceiveDeposit input, #formAddQuoteReceiveDeposit select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });
        
        //save receive deposit
        $('#addNewDepositBtn').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('quote.receive_store') }}";
            var type = "POST";
            var data = $('#formAddQuoteReceiveDeposit').serialize();
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#formAddQuoteReceiveDeposit').trigger("reset");
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

        $('#cancelBtn').click(function() {
            const quoteId = $('#quote_id').val();
            const url = "{{ route('quote.quotes.show', ':id') }}".replace(':id', quoteId);
            window.location.href = url;
        });

    });
</script>