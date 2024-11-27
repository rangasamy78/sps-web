<script type="text/javascript">
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#supplierInvoiceTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('purchase_orders.list') }}",
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
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_date',
                name: 'po_date'
            },
            {
                data: 'required_ship_date',
                name: 'required_ship_date'
            },
            {
                data: 'supplier_so_number',
                name: 'supplier_so_number'
            },
            {
                data: 'supplier_id',
                name: 'supplier_id'
            },
            {
                data: 'container_number',
                name: 'container_number'
            },
            {
                data: 'payment_term_id',
                name: 'payment_term_id'
            }, {
                data: 'po_number',
                name: 'po_number'
            }
        ],
        rowCallback: function(row, data, index) {
            $('td:eq(0)', row).html(table.page.info().start + index + 1);
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [{
            text: '<span class="d-none d-sm-inline-block">Supplier Invoice/Packing List</span>',
            className: 'btn btn-primary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                var poId = $('#po_id').val();

                window.location.href = "{{ route('supplier_invoice.create', ':id') }}"
                    .replace(':id', poId);

            }
        }, ],
    });

});
</script>