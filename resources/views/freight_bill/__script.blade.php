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
            url: "{{ route('freight_bills.list') }}",
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
                data: 'bill_inv',
                name: 'bill_inv'
            },
            {
                data: 'purchse_order',
                name: 'purchse_order'
            },
            {
                data: 'invoice_date',
                name: 'invoice_date'
            },
            {
                data: 'due_date',
                name: 'due_date'
            },
            {
                data: 'vendor_po_id',
                name: 'vendor_po_id'
            },
            {
                data: 'location',
                name: 'location'
            },

            {
                data: 'extended_total',
                name: 'extended_total'
            },
            {
                data: 'balance',
                name: 'balance'
            },
            {
                data: 'supplier',
                name: 'supplier'
            },
            {
                data: 'sipl_inv',
                name: 'sipl_inv'
            },
            {
                data: 'sipl_inv_dt',
                name: 'sipl_inv_dt'
            },
            {
                data: 'sipl_ship_dt',
                name: 'sipl_ship_dt'
            },
            {
                data: 'container',
                name: 'container'
            },
            {
                data: 'sipl_amount',
                name: 'sipl_amount'
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
                text: '<span class="d-none d-sm-inline-block">Freight Bills</span>',
                className: 'btn btn-secondary me-2',
                attr: {
                    id: 'freight',
                },
                action: function(e, dt, node, config) {
                    window.location.href = "{{ route('freight_bills.index') }}";
                }
            },
            {
                text: '<span class="d-none d-sm-inline-block">Freight Vendor</span>',
                className: 'create-new btn btn-primary me-2',
                attr: {
                    id: 'freight_vendor',
                },
                action: function(e, dt, node, config) {
                    window.location.href = "{{ route('freight_vendors.index') }}";
                }
            },
        ],
    });
});
</script>