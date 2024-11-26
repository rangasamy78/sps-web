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
                    element.find('.fc-content').css({'color':'darkslategray'});
                },
                timeFormat: 'hh:mm A',
                selectable: true,
                selectHelper: true,
                eventClick: function(info){
                    info.jsEvent.preventDefault(); // don't let the browser navigate

                        if (info.event.url) {
                        window.open(info.event.url);
                        }
                }
            });

    });
</script>
