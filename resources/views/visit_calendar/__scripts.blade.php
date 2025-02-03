<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#calendar').fullCalendar({
                header: {
                    left: 'prev, next today',
                    center: 'title',
                    right: 'month, agendaWeek, agendaDay',
                },
                events: @json($events),
                eventRender: function(event, element) {
                    element.find('.fc-title').html(event.title);  // This ensures HTML tags are rendered
                },
                timeFormat: 'hh:mm A',
                selectable: true,
                editable: true,
                selectHelper: true,
                eventClick: function(event){
                    var id = event.id
                    $('#visitCalendarModel').modal('show');
                    $('#visit_printed_notes').val(event.visit_printed_notes);
                    $('#internal_notes').val(event.internal_notes);
                    $('#visit_id').val(event.id);
                    $('#opportunity_id').val(event.opportunity_id);
                    $('#opportunity_code').html(event.opportunity_code);
                    $('#dataval').html(event.formattedDate);
                    $('#ship_to_job_name').html(event.ship_to_job_name);
                    $('#primary_sales_person_name').html(event.primary_sales_person_name);
                    $('#secondary_sales_person_name').html(event.secondary_sales_person_name);
                    $('#ship_to_address').html(event.ship_to_address);
                    $('#company_name').html(event.company_name);
                    $('#product_details').html(event.product_details);

                    $('#savedata').click(function(e) {
                    e.preventDefault();
                    var url = "{{ route('visit_calendars.update', ':id') }}".replace(':id', event.id);
                    $.ajax({
                        url: url,
                        type: "PUT",
                        data: $('#visitCalendarForm').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == "success") {
                                location.reload();
                                showToast('success', response.msg);
                            }
                        },
                        error: function(xhr) {
                            handleAjaxError(xhr);
                        }
                    });
                });

                }
            });

    });
</script>
