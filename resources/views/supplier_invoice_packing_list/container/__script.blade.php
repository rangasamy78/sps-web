<script type="text/javascript">
    $(function() {
       
        var currentDate = new Date().toISOString().split('T')[0]; 
        $('#received_on').val(currentDate);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var table = $('#containerTable').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    searching: false,
    order: [[0, 'desc']],
    ajax: {
        url: "{{ route('supplier_invoice_containers.list') }}",
        data: function(d) {
            var sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
            d.order = [{
                column: 1,
                dir: sort
            }];
        }
    },
    columns: [
        {
            data: null,
            name: 'serial',
            orderable: false,
            searchable: false
        },
        {
            data: 'container_number',
            name: 'container_number'
        },
        {
            data: 'received_on',
            name: 'received_on'
        },
        {
            data: 'received_by',
            name: 'received_by'
        },
        {
            data: 'notes',
            name: 'notes'
        },
        {
            data: 'po_id',
            name: 'po_id'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
    ],
    rowCallback: function(row, data, index) {
        $('td:eq(0)', row).html(table.page.info().start + index + 1);
    }
});


        $('#savedata').click(function(e) {
           
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = "{{ route('supplier_invoice_containers.store') }}"; 
            
            var type = "POST"; 
            $.ajax({
                url: url,
                type: type,
                data: $('#addContainerForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#addContainerForm').trigger("reset");
                        
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });





    });
</script>