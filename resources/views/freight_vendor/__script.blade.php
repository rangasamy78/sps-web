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
            url: "{{ route('freight_vendors.list') }}",
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
                data: 'expenditure_name',
                name: 'expenditure_name'
            },
            {
                data: 'print_name',
                name: 'print_name'
            },
            {
                data: 'expenditure_type_id',
                name: 'expenditure_type_id'
            },
            {
                data: 'address_combined',
                name: 'address'
            },
            {
                data: 'phone_combined',
                name: 'primary_phone'
            },
            {
                data: 'parent_location_id',
                name: 'parent_location_id'
            },
            {
                data: 'payment_method_id',
                name: 'payment_method_id'
            },
            {
                data: 'account',
                name: 'account'
            },
            {
                data: 'internal_notes',
                name: 'internal_notes'
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