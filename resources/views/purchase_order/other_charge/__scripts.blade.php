<script type="text/javascript">
$(function() {


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#po_details').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('vendor_pos.po_details') }}",
            data: function(d) {
                d.vendor_po_search = $('#vendorPoFilter').val();
                sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                d.order = [{
                    column: 1,
                    dir: sort
                }];
            }
        },
        columns: [{
                data: 'service_supplies',
                name: 'service_supplies'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'qty',
                name: 'qty'
            },
            {
                data: 'fulfilled_qty',
                name: 'fulfilled_qty'
            },
            {
                data: 'uom',
                name: 'uom'
            },
            {
                data: 'unit_cost',
                name: 'unit_cost'
            },
            {
                data: 'extended',
                name: 'extended'
            }
        ],
        rowCallback: function(row, data, index) {

            $('td:eq(0)', row).html(table.page.info().start + index + 1);
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Vendor Po</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    id: 'createVendorPo',
                },
                action: function(e, dt, node, config) {
                    window.location.href = "{{ route('vendor_pos.create') }}";
                }
            },
            {
                extend: 'collection',
                className: 'btn btn-label-secondary dropdown-toggle mx-3',
                text: '<i class="bx bx-export me-1"></i>Export',
                buttons: [{
                        extend: 'print',
                        text: '<i class="bx bx-printer me-2"></i>Print',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="bx bx-file me-2"></i>Csv',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="bx bxs-file-export me-2"></i>Excel',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'copy',
                        text: '<i class="bx bx-copy me-2"></i>Copy',
                        className: 'dropdown-item'
                    }
                ]
            }
        ]
    });

});
</script>