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
                element.find('.fc-title').html(event.title); // This ensures HTML tags are rendered
                element.find('.fc-content').css({
                    'color': 'darkslategray'
                });
            },
            dayClick: function(date, jsEvent, view, cell) {
                var fullUrl = window.location.href;
                var baseUrl = window.location.origin +'/'+ window.location.pathname.split('/')[1];
                var clickedDate = date.toISOString().split('T')[0];
                customURL   = baseUrl+"/my_events/create/"+clickedDate;
                window.open(customURL, '_blank');
            },
            dayRender: function(date, cell) {
                cell.append('<div class="mt-1" style="background: #efefef;border: 1px solid #B2B8CC;border-top-left-radius: 2px;border-bottom-left-radius: 2px;"><i class="fas fa-plus text-primary ps-3"></i></div>');
            },
            timeFormat: 'hh:mm A',
            selectable: true,
            selectHelper: true,
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // don't let the browser navigate

                if (info.event.url) {
                    window.open(info.event.url);
                }
            }
        });

    });
</script>
