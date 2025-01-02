<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#opportunitySampleOrderForm input, #opportunitySampleOrderForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });

        $('#saveOpportunitySampleOrder').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var activeDeliveryMethod = $('#pills-tab .nav-link.active').val();
            var url = "{{ route('create.save') }}";
            var type = "POST";
            var data = $('#opportunitySampleOrderForm').serialize() + "&ship_to_type=" + activeDeliveryMethod;
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#opportunitySampleOrderForm').trigger("reset");
                        showToast('success', response.msg);
                        window.location.href = "{{ route('create.index_product', ':id') }}".replace(':id', response.sample_order_id);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('#sample_order_copy_bill_to').click(function() {
            const fields = ['attn', 'address', 'suite', 'city', 'state', 'zip'];
            fields.forEach(field => {
                $(`#delivery_${field}`).val('');
                $(`#delivery_${field}`).val($(`#${field}`).val());
            });
        });

        $('#sample_order_copy_job_address').click(function() {
            const fields = ['attn', 'address', 'suite', 'city', 'state', 'zip'];
            fields.forEach(field => {
                $(`#delivery_${field}`).val('');
                $(`#delivery_${field}`).val($(`#ship_to_${field}`).val() || '');
            });
            const countyValue = $('#ship_to_county_id').val();
            $('#delivery_county_id').val(countyValue).trigger('change');
        });


        $('input[name="delivery_type"]').on('change', function() {
            const selectedType = $(this).val();
            if (selectedType === 'delivery') {
                $('#sample_order_field').show();
            } else if (selectedType === 'pickup') {
                $('#sample_order_field')
                    .hide()
                    .find('input, select').val('');
                $('#delivery_county_id').val(null).trigger('change');
            }
        });

        $('#cancelButton').click(function() {
            const url = "{{ route('opportunities.index') }}";
            window.location.href = url;
        });

    });
</script>