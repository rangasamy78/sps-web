<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       

        $('#po_internal_save_data').click(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            var button = $(this);
            sending(button);
            var url = "{{ route('po_internal_notes.store') }}";
            var type = "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#pointernalNoteForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        showToast('success', response.msg);
                    }
                    $("#po_internal_notes").val('');
                    displayData();
                    sending(button, true);
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        function displayData(){
            var displayUrl = "{{ route('po_internal_notes.list') }}";
            var id = $("#pointernalNoteForm #purchase_order_id").val();
            $.ajax({
                type: 'GET',
                url: displayUrl,
                data: {id: id},
                success: function(data){
                    $('#pointernalData').html(data.data)
                }
            });
        }
        displayData();

        $('#pointernalNoteForm textarea').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });
    });
</script>
