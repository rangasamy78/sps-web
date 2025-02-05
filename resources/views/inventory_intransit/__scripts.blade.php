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
                url: "{{ route('inventory_intransits.list') }}",
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
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'product_sku',
                    name: 'product_sku'
                },
                {
                    data: 'po_number',
                    name: 'po_number'
                },
                {
                    data: 'po_date',
                    name: 'po_date'
                },
                {
                    data: 'eta_date',
                    name: 'eta_date'
                },
                {
                    data: 'supplier_so',
                    name: 'supplier_so'
                },
                {
                    data: 'po_number',
                    name: 'po_number'
                },
                {
                    data: 'slabs',
                    name: 'slabs'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'units',
                    name: 'units'
                },
                {
                    data: 'ship_to_location',
                    name: 'ship_to_location'
                },
                {
                    data: 'supplier',
                    name: 'supplier'
                },
                {
                    data: 'freight',
                    name: 'freight'
                },
                {
                    data: 'eta_date',
                    name: 'eta_date'
                },
                {
                    data: 'eta_date',
                    name: 'eta_date'
                },
                {
                    data: 'ship_date',
                    name: 'ship_date'
                },
                {
                    data: 'container_number',
                    name: 'container_number'
                },
                {
                    data: 'vessel',
                    name: 'vessel'
                },
                {
                    data: 'customer_loc',
                    name: 'customer_loc'
                },
                
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'sidemark',
                    name: 'sidemark'
                },
                {
                    data: 'supp_pu_note',
                    name: 'supp_pu_note'
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
      
        });


      
    });
</script>