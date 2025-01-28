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

        $('#updateOpportunitySampleOrder').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var activeDeliveryMethod = $('#pills-tab .nav-link.active').val();
            var url = "{{ route('create.update', ':id') }}".replace(':id', $('#opportunity_id').val());
            var type = "PUT";
            var data = $('#opportunitySampleOrderEditForm').serialize() + "&ship_to_type=" + activeDeliveryMethod;
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#opportunitySampleOrderEditForm').trigger("reset");
                        showToast('success', response.msg);
                        window.location.href = "{{ route('create.edit_product', ':id') }}".replace(':id', response.sample_order_id);
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

        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(button => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-type');
                document.querySelectorAll('.conditional-fields').forEach(field => field.classList.add('d-none'));
                document.querySelector(`#${type}-fields`).classList.remove('d-none');
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
                $('#sample-order-delivery-fields').show();
                // $('#common-fields').hide();
            } else if (selectedType === 'pickup') {
                $('#sample-order-delivery-fields').hide().find('input, select').val('');
                $('#delivery_county_id').val(null).trigger('change');
            }
        });

    });
</script>