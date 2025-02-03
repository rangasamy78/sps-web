<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   

    var table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('supplier_invoices.list') }}",
            data: function(d) {
                sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                d.order = [{
                    column: 1,
                    dir: sort
                }];
            }
        },
        columns: [{
                data: null,
                name: 'serial',
                orderable: false,
                searchable: false
            },
            {
                data: 'sipl_bill',
                name: 'sipl_bill'
            },
            {
                data: 'po_id',
                name: 'po_id'
            },
            {
                data: 'entry_date',
                name: 'entry_date'
            },
            {
                data: 'invoice',
                name: 'invoice'
            },
            {
                data: 'payment_term_id',
                name: 'payment_term_id'
            },
            {
                data: 'supplier_so',
                name: 'supplier_so'
            },
            {
                data: 'container_number',
                name: 'container_number'
            },
            {
                data: 'supplier_id',
                name: 'supplier_id'
            },
            {
                data: 'sipl_status',
                name: 'sipl_status'
            },
            {
                data: 'ship_to_location_id',
                name: 'ship_to_location_id'
            },
            {
                data: 'freight_forwarder_id',
                name: 'freight_forwarder_id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'received_date',
                name: 'received_date'
            },
            {
                data: 'received_date',
                name: 'received_date'
            },
            {
                data: 'balance_due',
                name: 'balance_due'
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
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',

        buttons: [{
            text: '<span class="d-none d-sm-inline-block">New Supplier Invoice</span>',
            className: 'btn btn-primary me-2',
            attr: {
                id: 'supplier',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('supplier_invoices.create') }}";
            }
        }, ],
    });


    
    $('body').on('click', '.deletebtn', function() {
       
       var id = $(this).data('id');
       confirmDelete(id, function() {
           deletePO(id);
       });
   });

   function deletePO(id) {
       var url = "{{ route('supplier_invoices.destroy', ':id') }}".replace(':id', id);
       $.ajax({
           url: url,
           type: "DELETE",
           data: {
               id: id,
               _token: '{{ csrf_token() }}'
           },
           success: function(response) {

                   window.location.href = "{{ route('supplier_invoices.index') }}";
           },
           error: function(xhr) {
               console.error('Error:', xhr.statusText);
               showError('Oops!', 'Failed to fetch data.');
           }
       });
   }


});

</script>