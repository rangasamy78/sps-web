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

        $('#updateOpportunityVisit').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var activeDeliveryMethod = $('#pills-tab .nav-link.active').val();
            var url = "{{ route('visit.opportunities.update', ':id') }}".replace(':id', $('#opportunity_id').val());
            var type = "PUT";
            var data = $('#opportunityVisitEditForm').serialize() + "&ship_to_type=" + activeDeliveryMethod;
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#opportunityVisitEditForm').trigger("reset");
                        showToast('success', response.msg);
                        window.location.href = "{{ route('visits.edit_visit_product', ':id') }}".replace(':id', response.visit_id);
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
    });
</script>